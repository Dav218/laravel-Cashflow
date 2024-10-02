<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Link ke Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Latar belakang dengan gambar tema family cashflow */
        body {
            background-image: url('{{ asset('images/coba.png') }}');
            background-size: contain; 
            background-position: center; 
            background-repeat: no-repeat; 
            background-attachment: fixed; 
            height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        
        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5); /* Overlay gelap dengan transparansi */
            z-index: -1; /* Di belakang konten */
        }

        .login-table {
            width: 100%;
            max-width: 400px;
            border-radius: 10px; 
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            background-color: rgba(255, 255, 255, 0.8); 
            margin: 0 auto;
            position: relative; /* Untuk overlay */
            z-index: 1; /* Di atas overlay */
        }

        .login-table td {
            padding: 15px;
        }

        .card-header {
            background-color: rgba(128, 128, 128, 0.8);
            color: #fff;
            text-align: center;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            padding: 15px 0;
            font-weight: bold;
        }

        .card-body {
            background-color: rgba(240, 240, 240, 0.9); /* Warna abu-abu terang dengan transparansi */
            padding: 0;
        }

        .form-group label {
            font-weight: bold;
            color: rgba(128, 128, 128, 0.8); /* Warna abu-abu gelap untuk label */
        }

        .form-control {
            background-color: #ffffff; /* Warna putih untuk input */
            border: 1px solid #ced4da; /* Warna border abu-abu */
            color: #495057; /* Warna teks abu-abu gelap */
        }

        .btn-primary {
            background-color: rgba(128, 128, 128, 0.8); /* Warna abu-abu gelap untuk tombol */
            border-color: rgba(128, 128, 128, 0.8);
            padding: 10px 20px;
            border-radius: 50px;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: rgba(105, 105, 105, 0.9); /* Abu-abu lebih gelap saat hover */
        }

        .form-footer {
            text-align: center;
            margin-top: 15px;
        }

        .form-footer a {
            color: rgba(128, 128, 128, 0.8); /* Warna abu-abu untuk link */
            transition: color 0.3s ease;
        }

        .form-footer a:hover {
            color: rgba(105, 105, 105, 0.9); /* Abu-abu lebih gelap saat hover */
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="overlay"></div>
    <div class="container">
        <table class="login-table">
            <tr>
                <td class="card-header">
                    <h4>Login</h4>
                </td>
            </tr>
            <tr>
                <td class="card-body">
                    <form action="{{ url('login-proses') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="nama">Nama:</label>
                            <input type="text" id="nama" name="nama" class="form-control" required placeholder="Masukkan Nama">
                        </div>
                        <div class="form-group">
                            <label for="password">Password:</label>
                            <input type="password" id="password" name="password" class="form-control" required placeholder="Masukkan Password">
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Login</button>
                    </form>
                </td>
            </tr>
            <tr>
                <td class="card-footer form-footer">
                    <p>Belum punya akun? <a href="{{ route('register') }}">Buat Akun</a></p>
                    <p><a href="{{ route('halaman') }}">Balik Ke Home</a></p>
                </td>
            </tr>
        </table>
    </div>
    <!-- Link ke Bootstrap JS dan dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
