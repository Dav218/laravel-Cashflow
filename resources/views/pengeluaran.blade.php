@extends('layouts.master')
@section('css')
    <style>
        body {
            padding-top: 56px; /* Memberikan ruang untuk navbar fixed-top */
            background-color: #f8f9fa; /* Latar belakang terang untuk kontras */
        }

        .container {
            margin-top: 20px;
            max-width: 600px; /* Lebar maksimum kontainer */
        }

        .card {
            border: none;
            border-radius: 15px; /* Sudut melengkung */
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1); /* Bayangan halus */
        }

        .card-header {
            background-color: #28a745; /* Warna hijau untuk header */
            color: #fff;
            text-align: center;
            border-top-left-radius: 15px; /* Sudut melengkung */
            border-top-right-radius: 15px; /* Sudut melengkung */
            padding: 20px; /* Tambahkan padding */
        }

        .form-group label {
            font-weight: bold;
            color: #343a40; /* Teks label lebih gelap */
        }

        .form-control {
            border-radius: 10px; /* Sudut melengkung pada field input */
            border: 1px solid #ced4da; /* Border untuk field input */
        }

        .form-control:focus {
            box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25); /* Efek fokus */
            border-color: #28a745; /* Warna border saat fokus */
        }

        .btn-custom {
            margin-top: 20px;
            width: 100%; /* Tombol memenuhi lebar */
            border-radius: 10px; /* Sudut melengkung pada tombol */
        }

        .btn-success {
            background-color: #218838; /* Warna hijau gelap */
            border: none; /* Hapus border */
        }

        .btn-success:hover {
            background-color: #1e7e34; /* Lebih gelap saat hover */
        }

        .dropdown-menu a {
            color: #333;
        }

        .dropdown-menu a:hover {
            background-color: #f1f1f1; /* Sorot saat hover */
        }
    </style>
@endsection

@section('content')

<body>
    <!-- Navbar dengan dropdown user -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
        <a class="navbar-brand" href="#">Cashflow App</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('pemasukan.form') }}">Pemasukan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('pengeluaran.form') }}">Pengeluaran</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('user.history') }}">History</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="https://img.icons8.com/ios-filled/50/ffffff/user.png" alt="user-icon" style="width: 24px; height: 24px;">
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Konten utama -->
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h1>Tambah Pengeluaran</h1>
            </div>
            <div class="card-body">
                <form action="{{ route('pengeluaran.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="amount">Nominal:</label>
                        <input type="number" id="amount" name="amount" class="form-control" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Keterangan:</label>
                        <input type="text" id="description" name="description" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="date">Tanggal:</label>
                        <input type="date" id="date" name="date" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-success btn-custom">Simpan</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Link ke Bootstrap JS dan dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
