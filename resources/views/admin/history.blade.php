@extends('layouts.master')

@section('css')
    <style>
        body {
            padding-top: 56px; /* Memberikan ruang untuk navbar fixed-top */
        }
        .container {
            margin-top: 20px;
        }
        .card-header {
            background-color: #17a2b8;
            color: #fff;
            text-align: center;
        }
        .table th, .table td {
            text-align: center;
        }
        .btn-export {
            background-color: #28a745;
            color: #fff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 16px;
        }
        .btn-export:hover {
            background-color: #218838;
        }
        .search-input {
            margin-bottom: 20px; /* Jarak antara input pencarian dan tabel */
            width: 100%;
            max-width: 400px; /* Lebar maksimum input pencarian */
            margin-left: auto;
            margin-right: auto;
        }
        .no-results {
            text-align: center;
            margin-top: 20px;
            color: #dc3545; /* Warna merah */
            display: none; /* Tersembunyi secara default */
        }
        .btn-back {
            margin-top: 20px;
            display: block;
            width: 150px;
            margin-left: auto;
            margin-right: auto;
            background-color: #6c757d; /* Warna tombol */
            color: #fff; /* Teks putih */
            border: none; /* Tanpa border */
            border-radius: 5px; /* Sudut membulat */
            padding: 10px; /* Padding dalam tombol */
            text-align: center; /* Teks di tengah */
            text-decoration: none; /* Menghilangkan garis bawah */
            transition: background-color 0.3s; /* Transisi warna */
        }
        .btn-back:hover {
            background-color: #5a6268; /* Warna saat hover */
        }
    </style>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h1>Riwayat Transaksi</h1>
    </div>
    <div class="card-body">
        <input type="text" class="form-control search-input" placeholder="Cari transaksi..." id="search" onkeyup="filterTransactions()">
        <table class="table table-striped" id="transactionsTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Type</th>
                    <th>Amount</th>
                    <th>Description</th>
                    <th>Date</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            @forelse($transactions as $transaction)
                <tr>
                    <td>{{ $transaction->id }}</td>
                    <td>{{ $transaction->user->name }}</td>
                    <td>{{ ucfirst($transaction->type) }}</td>
                    <td>Rp {{ number_format($transaction->amount, 0, ',', '.') }}</td>
                    <td>{{ $transaction->description }}</td>
                    <td>{{ $transaction->date }}</td>
                    <td>
                        <!-- Edit Button -->
                        <button class="btn btn-primary" data-toggle="modal" data-target="#editTransactionModal{{ $transaction->id }}">Edit</button>

                        <!-- Delete Form -->
                        <form action="{{ route('transaction.destroy', $transaction->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>

                <!-- Edit Modal -->
                <div class="modal fade" id="editTransactionModal{{ $transaction->id }}" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <form action="{{ route('transaction.update', $transaction->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Transaksi</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="amount">Amount</label>
                                        <input type="number" name="amount" class="form-control" value="{{ $transaction->amount }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <input type="text" name="description" class="form-control" value="{{ $transaction->description }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="date">Date</label>
                                        <input type="date" name="date" class="form-control" value="{{ $transaction->date }}" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
            @empty
                <tr>
                    <td colspan="7" class="text-center">No transactions found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
        <div class="no-results" id="noResults">Tidak ditemukan</div>
        <button class="btn-export" onclick="printPage()">Export As PDF</button>
        <a href="{{ route('home') }}" class="btn-back">Kembali</a> <!-- Update this route -->

    </div>
</div>

<script>
    function printPage() {
        window.print();
    }

    function filterTransactions() {
        const input = document.getElementById('search');
        const filter = input.value.toLowerCase();
        const table = document.getElementById('transactionsTable');
        const tr = table.getElementsByTagName('tr');
        let hasResults = false;

        for (let i = 1; i < tr.length; i++) {
            const tdID = tr[i].getElementsByTagName('td')[0];
            const tdUser = tr[i].getElementsByTagName('td')[1];
            const tdType = tr[i].getElementsByTagName('td')[2];
            const tdAmount = tr[i].getElementsByTagName('td')[3];
            const tdDescription = tr[i].getElementsByTagName('td')[4];
            const tdDate = tr[i].getElementsByTagName('td')[5];

            if (tdID || tdUser || tdType || tdAmount || tdDescription || tdDate) {
                const txtValueID = tdID.textContent || tdID.innerText;
                const txtValueUser = tdUser.textContent || tdUser.innerText;
                const txtValueType = tdType.textContent || tdType.innerText;
                const txtValueAmount = tdAmount.textContent || tdAmount.innerText;
                const txtValueDescription = tdDescription.textContent || tdDescription.innerText;
                const txtValueDate = tdDate.textContent || tdDate.innerText;

                if (
                    txtValueID.toLowerCase().indexOf(filter) > -1 ||
                    txtValueUser.toLowerCase().indexOf(filter) > -1 ||
                    txtValueType.toLowerCase().indexOf(filter) > -1 ||
                    txtValueAmount.toLowerCase().indexOf(filter) > -1 ||
                    txtValueDescription.toLowerCase().indexOf(filter) > -1 ||
                    txtValueDate.toLowerCase().indexOf(filter) > -1
                ) {
                    tr[i].style.display = "";
                    hasResults = true; // Ada hasil yang ditemukan
                } else {
                    tr[i].style.display = "none";
                }
            }
        }

        // Tampilkan pesan tidak ditemukan jika tidak ada hasil
        document.getElementById('noResults').style.display = hasResults ? 'none' : 'block';
    }
</script>
@endsection
