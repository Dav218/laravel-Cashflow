<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\UserBalance;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        Log::info('Register request data:', $request->all()); // Log request data for debugging
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
            'role' => 'required|in:ayah,ibu,anak',
        ]);

        // Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        // Create user balance entry with initial balance of 0
        UserBalance::create([
            'user_id' => $user->id,
            'balance' => 0,
        ]);

        // Log in the user
        Auth::login($user);

        // Redirect to login with a success message
        return redirect()->route('login')->with('success', 'Akun berhasil dibuat. Silakan login.');
    }
}
