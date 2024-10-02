<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function loginProses()
    {
        $validator = Validator::make(request()->all(), [
            'nama' => 'required',
            'password' => 'required',
        ], [
            'nama.required' => 'Nama Harus Diisi',
            'password.required' => 'Password Wajib Diisi',
        ]);


        if ($validator->passes()) {
            if (Auth::attempt([
                'name' => request()->input('nama'),
                'password' => request()->input('password'),
            ])) {
                request()->session()->regenerate();

                return redirect()->intended('/home');
            }


            return back()->with('pesan', $validator->messages()->get('*'));
        }
    }



    public function logout()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('login');
    }
}
