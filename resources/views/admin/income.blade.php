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
            margin-top: 20px; /* Jarak atas untuk tombol export */
            display: block;
            width: 150px;
            margin-left: auto;
            margin-right: auto;
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
        <h1>Daftar Pemasukan</h1>
    </div>
    <div class="card-body">
        <input type="text" class="form-control search-input" placeholder="Cari pemasukan..." id="search" onkeyup="filterTransactions()">
        <input type="date" class="form-control search-input" id="searchDate" oninput="filterTransactionsByDate()">
        
        <table class="table table-striped" id="incomeTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Amount</th>
                    <th>Description</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($incomeTransactions as $transaction)
                    <tr>
                        <td>{{ $transaction->id }}</td>
                        <td>{{ $transaction->user->name }}</td>
                        <td>Rp {{ number_format($transaction->amount, 2, ',', '.') }}</td>
                        <td>{{ $transaction->description }}</td>
                        <td>{{ $transaction->date }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Tidak ada pemasukan ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="no-results" id="noResults">Tidak ditemukan</div>
        <button class="btn-export" onclick="printPage()">Export As PDF</button>
        <a href="{{ route('home') }}" class="btn-back">Kembali</a>
    </div>
</div>

<script>
    function printPage() {
        window.print();
    }

    function filterTransactions() {
        const input = document.getElementById('search');
        const filter = input.value.toLowerCase();
        const table = document.getElementById('incomeTable');
        const tr = table.getElementsByTagName('tr');
        let hasResults = false;

        for (let i = 1; i < tr.length; i++) {
            const tdID = tr[i].getElementsByTagName('td')[0];
            const tdUser = tr[i].getElementsByTagName('td')[1];
            const tdAmount = tr[i].getElementsByTagName('td')[2];
            const tdDescription = tr[i].getElementsByTagName('td')[3];
            const tdDate = tr[i].getElementsByTagName('td')[4];

            if (tdID || tdUser || tdAmount || tdDescription || tdDate) {
                const txtValueID = tdID.textContent || tdID.innerText;
                const txtValueUser = tdUser.textContent || tdUser.innerText;
                const txtValueAmount = tdAmount.textContent || tdAmount.innerText;
                const txtValueDescription = tdDescription.textContent || tdDescription.innerText;
                const txtValueDate = tdDate.textContent || tdDate.innerText;

                if (
                    txtValueID.toLowerCase().indexOf(filter) > -1 ||
                    txtValueUser.toLowerCase().indexOf(filter) > -1 ||
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

    function filterTransactionsByDate() {
        const input = document.getElementById('searchDate');
        const filterDate = input.value;
        const table = document.getElementById('incomeTable');
        const tr = table.getElementsByTagName('tr');
        let hasResults = false;

        for (let i = 1; i < tr.length; i++) {
            const tdDate = tr[i].getElementsByTagName('td')[4];

            if (tdDate) {
                const txtValueDate = tdDate.textContent || tdDate.innerText;

                if (txtValueDate.includes(filterDate)) {
                    tr[i].style.display = "";
                    hasResults = true;
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
