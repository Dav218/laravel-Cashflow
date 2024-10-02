<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CashFlow</title>
    <!-- Link ke Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    @yield('css')
</head>
<body>
    <!-- Navbar dengan dropdown user -->
   @include('layouts.navbar')

    <!-- Konten utama -->
    <div class="container">
        @yield('content')
    </div>

    <!-- Link ke Bootstrap JS dan dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- JavaScript untuk Memeriksa Saldo -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Ambil elemen saldo dan peringatan
            var saldoElement = document.getElementById('saldo');
            var warningElement = document.getElementById('warning');

            // Ambil saldo dari teks elemen (menghapus teks "Total Saldo: " dan mengkonversi ke angka)
            var saldoText = saldoElement.textContent.replace('Total Saldo: ', '').trim();
            var saldo = parseFloat(saldoText);

            // Periksa apakah saldo negatif
            if (saldo < 0) {
                saldoElement.classList.add('text-danger'); // Tambahkan kelas CSS untuk warna merah
                warningElement.style.display = 'block'; // Tampilkan peringatan
            }
        });
    </script>
</body>
</html>
