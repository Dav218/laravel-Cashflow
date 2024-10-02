<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Family Cashflow</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        /* Navbar styling */
        .navbar {
            background-color: #343a40; /* Warna gelap untuk navbar */
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .navbar .nav-link {
            color: white !important;
            font-weight: bold;
            transition: color 0.3s;
        }
        .navbar .nav-link:hover {
            color: #e0f2f1 !important; /* Warna hover */
        }

        /* Style untuk konten utama */
        .content {
            text-align: center;
            margin-top: 50px;
            flex: 1;
        }
        .content h1 {
            font-size: 2.5rem;
            font-family: 'Poppins', sans-serif;
            color: #333;
            font-weight: 700;
        }
        .content p {
            font-size: 1.2rem;
            color: #666;
            margin-bottom: 30px;
        }

        /* Tombol login */
        .btn-login {
            background-color: #007bff;
            color: white;
            font-weight: bold;
            padding: 12px 30px;
            border-radius: 50px;
            transition: background-color 0.3s ease;
        }
        .btn-login:hover {
            background-color: #0056b3;
        }

        /* Background warna lembut */
        body {
            background: #f4f4f9;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Style untuk gambar logo navbar */
        .navbar-brand img {
            height: 50px;
        }

        /* Style untuk ucapan selamat datang */
        .welcome-content {
            display: flex;
            align-items: center;
            justify-content: center; /* Ubah menjadi center */
            text-align: left;
            padding: 0 20px; /* Menambahkan padding */
            gap: 20px; /* Menambahkan jarak antara teks dan gambar */
        }

        .welcome-content div {
            max-width: 50%;
        }

        .welcome-content img {
            max-width: 40%; /* Mengurangi lebar gambar */
            border-radius: 15px;
            transition: transform 0.3s;
        }
        .welcome-content img:hover {
            transform: scale(1.05);
        }

        /* Footer styling */
        footer {
            background-color: #343a40; /* Warna yang sama dengan navbar */
            color: #fff;
            padding: 20px;
            text-align: center;
            margin-top: auto;
            border-top: 2px solid #292b2c; /* Warna sedikit lebih gelap untuk garis atas */
        }

        footer p {
            margin: 0;
            font-size: 0.9rem;
        }

        .contact {
            margin-top: 10px;
        }

        .contact a {
            margin: 0 10px;
            color: #d3d3d3;
            font-size: 1.5rem;
            transition: color 0.3s ease;
        }
        
        .contact a:hover {
            color: #a9a9a9;
        }
    </style>
</head>
<body>
    <!-- Navbar dengan logo dan tombol login -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <a class="navbar-brand" href="#">
            <img src="{{ asset('images/logo.png') }}" alt="Family Cashflow Logo">
        </a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ml-auto">
                @guest
                <li class="nav-item">
                    <a class="nav-link btn-login" href="{{ route('login') }}">Login</a>
                </li>
                @endguest
            </ul>
        </div>
    </nav>

    <!-- Ucapan Selamat Datang -->
    <div class="container content">
        <div class="welcome-content">
            <div>
                <h1>Selamat Datang di Family Cashflow</h1>
                <p>Kelola keuangan keluarga Anda dengan lebih baik dan rasakan kemudahan dalam setiap transaksi.</p>
                <a href="{{ route('login') }}" class="btn btn-login">Mulai Sekarang</a>
            </div>
            <img src="{{ asset('images/pngegg.png') }}" alt="Family Photo" class="img-fluid">
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <p>© 2024 Family Cashflow. Semua Hak Dilindungi.</p>
        <div class="contact">
            <a href="https://wa.me/085855228346" target="_blank" title="WhatsApp"><i class="fab fa-whatsapp"></i></a>
            <a href="https://www.instagram.com/dagistyan" target="_blank" title="Instagram"><i class="fab fa-instagram"></i></a>
        </div>
    </footer>

    <!-- Link ke Bootstrap JS dan dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
