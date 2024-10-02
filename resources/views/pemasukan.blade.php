@extends('layouts.master')
@section('css')
    <style>
        body {
            padding-top: 56px; /* Space for fixed-top navbar */
            background-color: #f8f9fa; /* Light background for contrast */
        }

        .container {
            margin-top: 20px;
            max-width: 600px; /* Adjust maximum width */
        }

        .card {
            border: none;
            border-radius: 15px; /* Rounded corners */
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1); /* Subtle shadow */
        }

        .card-header {
            background-color: #007bff; /* Header color */
            color: #fff;
            text-align: center;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
            padding: 20px; /* Added padding */
        }

        .form-group label {
            font-weight: bold;
            color: #343a40; /* Darker text for labels */
        }

        .form-control {
            border-radius: 10px; /* Rounded input fields */
            border: 1px solid #ced4da; /* Border for input fields */
        }

        .form-control:focus {
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25); /* Focus effect */
            border-color: #007bff; /* Focus border color */
        }

        .btn-custom {
            margin-top: 20px;
            width: 100%; /* Full width button */
            border-radius: 10px; /* Rounded button */
        }

        .btn-primary {
            background-color: #0056b3; /* Darker primary color */
            border: none; /* Remove border */
        }

        .btn-primary:hover {
            background-color: #004494; /* Darker on hover */
        }

        .dropdown-menu a {
            color: #333;
        }

        .dropdown-menu a:hover {
            background-color: #f1f1f1; /* Highlight on hover */
        }
    </style>
@endsection

@section('content')

<body>
    <!-- Navbar dengan dropdown user -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
        <a class="navbar-brand" href="#">Cashflow App</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
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
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="https://img.icons8.com/ios-filled/50/ffffff/user.png" alt="user-icon"
                            style="width: 24px; height: 24px;">
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
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
                <h1>Tambah Pemasukan</h1>
            </div>
            <div class="card-body">
                <form action="{{ route('pemasukan.store') }}" method="POST">
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
                    <button type="submit" class="btn btn-primary btn-custom">Simpan</button>
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
