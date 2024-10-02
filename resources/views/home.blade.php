@extends('layouts.master')

@section('css')
    <style>
        body {
            background-color: #f0f2f5;
            font-family: Arial, sans-serif;
        }

        .sidebar {
            background-color: #343a40;
            color: #fff;
            height: 100vh;
            position: fixed;
            width: 250px;
            top: 0;
            left: 0;
            padding-top: 20px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }

        .sidebar h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .sidebar a {
            color: #fff;
            padding: 15px 20px;
            display: block;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .sidebar a:hover {
            background-color: #495057;
        }

        .content {
            margin-left: 260px;
            padding: 20px;
        }

        .summary-container {
            display: flex;
            justify-content: space-between; /* Space evenly */
            margin-top: 60px; /* Jarak dari navbar */
        }

        .summary-item {
            background: #4A90E2;
            color: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            text-align: center;
            width: 24%; /* Lebar item diubah */
            margin: 0 5px; /* Margin antara item */
            box-sizing: border-box; /* Include padding in width */
        }

        .summary-item .lead {
            font-size: 1.5rem;
        }

        .icon {
            font-size: 2rem;
            margin-right: 10px;
            vertical-align: middle;
        }
    </style>
@endsection

@section('content')
    <div class="sidebar">
        <h2>Menu</h2>
        <a href="{{ route('home') }}">Dashboard</a>
        @if(Auth::user()->role == 'admin')
            <a href="{{ route('admin.users') }}">Daftar Semua Akun</a>
            <a href="{{ route('admin.income') }}">Pemasukan</a>
            <a href="{{ route('admin.expense') }}">Pengeluaran</a>
            <a href="{{ route('admin.history') }}">History</a>
        @else
            @if(Auth::user()->role == 'ayah')
                <a href="#">Fitur untuk Ayah</a>
            @elseif(Auth::user()->role == 'ibu')
                <a href="#">Fitur untuk Ibu</a>
            @elseif(Auth::user()->role == 'anak')
                <a href="#">Fitur untuk Anak</a>
            @endif
        @endif
    </div>

    <div class="content">
        <div class="summary-container">
            <div class="summary-item">
                <p>
                    <i class="icon fas fa-wallet"></i>
                    <span class="lead">Total Saldo: Rp {{ number_format($totalBalance, 2, ',', '.') }}</span>
                </p>
            </div>
            <div class="summary-item">
                <p>
                    <i class="icon fas fa-arrow-up"></i>
                    <span class="lead">Total Pemasukan: Rp {{ number_format($totalIncome, 2, ',', '.') }}</span>
                </p>
            </div>
            <div class="summary-item">
                <p>
                    <i class="icon fas fa-arrow-down"></i>
                    <span class="lead">Total Pengeluaran: Rp {{ number_format($totalExpenses, 2, ',', '.') }}</span>
                </p>
            </div>

            @if(Auth::user()->role == 'admin') <!-- Cek jika user adalah admin -->
                <div class="summary-item">
                    <p>
                        <i class="icon fas fa-chart-pie"></i>
                        <span class="lead">Total Saldo Admin: Rp {{ number_format($totalAdminBalance, 2, ',', '.') }}</span>
                    </p>
                </div>
            @endif
        </div>
    </div>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endsection
