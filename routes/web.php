<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CashflowController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;

// Redirect root URL to login
Route::get('/', function () {
    return redirect()->route('halaman');
});

// Route for login page
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login-proses', [LoginController::class, 'loginProses']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Route for registration form (GET)
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');

// Route for registration submission (POST)
Route::post('register-proses', [RegisterController::class, 'register'])->name('register.proses');

// Routes for authenticated users
Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', [CashflowController::class, 'home'])->name('home');
    Route::get('/pemasukan', [CashflowController::class, 'showPemasukanForm'])->name('pemasukan.form');
    Route::post('/pemasukan', [CashflowController::class, 'storePemasukan'])->name('pemasukan.store');
    Route::get('/pengeluaran', [CashflowController::class, 'showPengeluaranForm'])->name('pengeluaran.form');
    Route::post('/pengeluaran', [CashflowController::class, 'storePengeluaran'])->name('pengeluaran.store');
    Route::get('/history', [CashflowController::class, 'userHistory'])->name('user.history');   
    Route::delete('/transaction/{id}', [CashflowController::class, 'destroy'])->name('transaction.destroy');
    Route::get('/export-transactions', [CashflowController::class, 'exportToExcel'])->name('export.transactions');
    
    // Role-based routes for 'admin'
    Route::group(['middleware' => ['role:admin']], function () {
        Route::get('/admin/users', [CashflowController::class, 'showAllUsers'])->name('admin.users');
        Route::get('/admin/income', [CashflowController::class, 'showAllIncome'])->name('admin.income');
        Route::get('/admin/expense', [CashflowController::class, 'showAllExpenses'])->name('admin.expense');
        Route::get('/admin/history', [CashflowController::class, 'showAllHistory'])->name('admin.history');
        Route::get('/export-transactions-excel', [CashflowController::class, 'exportToExcel'])->name('export.transactions.excel');

        // Route for updating user details
        Route::put('/user/{id}', [CashflowController::class, 'updateUser'])->name('user.update');
        Route::put('/transaction/{id}', [CashflowController::class, 'update'])->name('transaction.update');

        // Route for deleting a user
        Route::delete('/user/{id}', [CashflowController::class, 'destroyUser'])->name('user.destroy');
    });

    // Role-based routes for specific roles
    Route::group(['middleware' => ['role:ayah']], function () {
        // Routes for 'ayah' role
    });

    Route::group(['middleware' => ['role:ibu']], function () {
        // Routes for 'ibu' role
    });

    Route::group(['middleware' => ['role:anak']], function () {
        // Routes for 'anak' role
    });
});

// Public route for halaman
Route::get('/halaman', [CashflowController::class, 'Halaman'])->name('halaman');




