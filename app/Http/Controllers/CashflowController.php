<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Carbon\Carbon;
use App\Models\Transaction;
use App\Models\UserBalance;
use App\Models\User; // Ensure you have this


class CashflowController extends Controller
{
    public function home()
{
    // Ambil pengguna yang sedang login
    $user = auth()->user();
    
    // Ambil semua transaksi untuk pengguna yang sedang login
    $income = Transaction::where('type', 'income')->where('user_id', $user->id)->get();
    $expenses = Transaction::where('type', 'expense')->where('user_id', $user->id)->get();
    
    // Hitung total saldo untuk pengguna yang sedang login
    $totalIncome = $income->sum('amount');
    $totalExpenses = $expenses->sum('amount');
    $totalBalance = $totalIncome - $totalExpenses;

    // Jika pengguna adalah admin, hitung total saldo admin
    $totalAdminBalance = 0;
    if ($user->role === 'admin') {
        $allIncome = Transaction::where('type', 'income')->sum('amount');
        $allExpenses = Transaction::where('type', 'expense')->sum('amount');
        $totalAdminBalance = $allIncome - $allExpenses;
    }

    // Kembalikan view dengan data yang dibutuhkan
    return view('home', [
        'totalBalance' => $totalBalance,
        'totalIncome' => $totalIncome,
        'totalExpenses' => $totalExpenses,
        'totalAdminBalance' => $totalAdminBalance, // Tambahkan total saldo admin hanya jika admin
    ]);
}

    


    public function showPemasukanForm()
    {
        return view('pemasukan');
    }

    public function storePemasukan(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01', // Ensure amount is positive
            'description' => 'required|string',
            'date' => 'required|date',
        ]);

        $userId = Auth::id();
        if (!$userId) {
            return redirect()->back()->withErrors(['msg' => 'User is not authenticated']);
        }

        // Create a new transaction
        Transaction::create([
            'type' => 'income',
            'amount' => $request->amount,
            'description' => $request->description,
            'date' => $request->date,
            'user_id' => $userId,
        ]);

        // Update balance
        UserBalance::updateOrCreate(
            ['user_id' => $userId], // Menggunakan 'user_id' sebagai kunci pencarian
            ['balance' => DB::raw('balance + ' . $request->amount)] // Update saldo
        );

        return redirect()->route('home');
    }


    public function showPengeluaranForm()
    {
        return view('pengeluaran');
    }

    public function storePengeluaran(Request $request)
    {
        // Validate input
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'description' => 'required|string',
            'date' => 'required|date_format:Y-m-d', // Ensure date is in the correct format
        ]);

        $userId = Auth::id();
        if (!$userId) {
            return redirect()->back()->withErrors(['msg' => 'User is not authenticated']);
        }

        // Log the incoming request data for debugging
        Log::info("Storing expense with data: ", $request->all());

        // Create a new transaction
        Transaction::create([
            'type' => 'expense',
            'amount' => $request->amount,
            'description' => $request->description,
            'date' => $request->date,
            'user_id' => $userId,
        ]);

        // Update balance
        UserBalance::updateOrCreate(
            ['user_id' => $userId],
            ['balance' => DB::raw('balance - ' . $request->amount)]
        );

        return redirect()->route('home');
    }

    public function history()
    {
        $user = Auth::user(); // Mengambil pengguna yang sedang login
        
        // Mengambil transaksi untuk pengguna yang sedang login
        $transactions = Transaction::where('user_id', $user->id)->orderBy('date', 'desc')->get();
        
        // Mengambil histori admin (jika diperlukan)
        $adminHistories = Transaction::where('type', 'admin')->get();
    
        return view('admin.history', [
            'transactions' => $transactions,
            'adminHistories' => $adminHistories,
        ]);
    }
    
    

    public function destroy($id)
    {
        Log::info("Attempting to delete transaction with ID: $id");
        $transaction = Transaction::findOrFail($id);
        $transaction->delete();

        return redirect()->route('admin.history')->with('success', 'Transaction successfully deleted');
    }

    public function destroyUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users')->with('success', 'User successfully deleted');
    }


    protected function getFatherBalance()
    {
        return $this->calculateBalanceByRole('ayah');
    }

    protected function getMotherBalance()
    {
        return $this->calculateBalanceByRole('ibu');
    }

    protected function getChildBalance()
    {
        return $this->calculateBalanceByRole('anak');
    }

    private function calculateBalanceByRole($role)
    {
        // Adjust this method if necessary to fit your role-based logic
        $income = Transaction::where('type', 'income')->whereHas('user', function ($query) use ($role) {
            $query->where('role', $role);
        })->sum('amount');

        $expense = Transaction::where('type', 'expense')->whereHas('user', function ($query) use ($role) {
            $query->where('role', $role);
        })->sum('amount');

        return $income - $expense;
    }

    public function showAllUsers()
    {
        $users = User::all(); // Fetch all users
        return view('admin.users', compact('users'));
    }

    public function showAllIncome()
    {
        $incomeTransactions = Transaction::where('type', 'income')->get();
        return view('admin.income', compact('incomeTransactions'));
    }

    public function showAllExpenses()
    {
        $expenseTransactions = Transaction::where('type', 'expense')->get();
        return view('admin.expense', compact('expenseTransactions'));
    }

    public function showAllHistory()
    {
        $allTransactions = Transaction::with('user')->get(); // Eager load user relationships
        return view('admin.history', ['transactions' => $allTransactions]); // Pass transactions to view
    }
    public function updateUser(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:6',
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->password) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return redirect()->route('admin.users')->with('success', 'User updated successfully!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'description' => 'required|string',
            'date' => 'required|date',
        ]);

        $transaction = Transaction::findOrFail($id);
        $transaction->update([
            'amount' => $request->amount,
            'description' => $request->description,
            'date' => $request->date,
        ]);


        if ($transaction->isDirty('amount')) {
            $balanceChange = $request->amount - $transaction->getOriginal('amount');
            UserBalance::where('user_id', $transaction->user_id)->increment('balance', $balanceChange);
        }

        return redirect()->route('admin.history')->with('success', 'Transaction updated successfully');
    }

    public function userHistory()
{
    $user = Auth::user(); // Get the currently logged-in user

    // Get transactions for the logged-in user
    $transactions = Transaction::where('user_id', $user->id)->orderBy('date', 'desc')->get();
    
    // Get admin history (if necessary)
    $adminHistories = Transaction::where('type', 'admin')->get();
    
    return view('history', [
        'transactions' => $transactions,
        'adminHistories' => $adminHistories,
    ]);
}

public function exportToExcel()
{
    try {
        // Ambil ID pengguna yang sedang login
        $userId = auth()->id();

        // Ambil semua transaksi untuk pengguna yang sedang login
        $transactions = Transaction::with('user')->where('user_id', $userId)->get();

        Log::info("Jumlah transaksi untuk diekspor: " . $transactions->count());

        if ($transactions->isEmpty()) {
            return response()->json(['message' => 'Tidak ada transaksi untuk diekspor.'], 404);
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set header kolom
        $headers = ['ID', 'Pengguna', 'Tipe', 'Jumlah', 'Keterangan', 'Tanggal'];
        foreach ($headers as $key => $header) {
            $sheet->setCellValue(chr(65 + $key) . '1', $header);
        }

        // Inisialisasi $row
        $row = 2;

        // Masukkan data transaksi yang relevan
        foreach ($transactions as $transaction) {
            $sheet->setCellValue('A' . $row, $transaction->id);
            $sheet->setCellValue('B' . $row, $transaction->user->name ?? 'N/A'); // Nama pengguna
            $sheet->setCellValue('C' . $row, ucfirst($transaction->type)); // Tipe
            $sheet->setCellValue('D' . $row, 'Rp ' . number_format($transaction->amount, 0, ',', '.')); // Jumlah
            $sheet->setCellValue('E' . $row, $transaction->description); // Keterangan
            $sheet->setCellValue('F' . $row, \Carbon\Carbon::parse($transaction->date)->format('Y-m-d')); // Tanggal
            $row++;
        }

        // Set lebar kolom
        foreach (range('A', 'F') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        // Set header untuk download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="transaksi.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;

    } catch (\Exception $e) {
        Log::error("Error during export: " . $e->getMessage());
        return response()->json(['message' => 'Terjadi kesalahan saat mengekspor.', 'error' => $e->getMessage()], 500);
    }
}




    public function Halaman()
    {
        return view('halaman');
    }
}
