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
            margin-bottom: 20px; /* Tambahkan margin untuk jarak antara tombol dan tabel */
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
    </style>
@endsection

@section('content')
<!-- History Transaksi -->
<div class="card">
    <div class="card-header">
        <h1>History Transaksi</h1>
    </div>
    <div class="card-body">
        <input type="text" class="form-control search-input" placeholder="Cari transaksi..." id="search" onkeyup="filterTransactions()">
        
        <!-- Tombol Ekspor ke Excel -->
        <button class="btn-export" onclick="window.location='{{ route('export.transactions') }}'">Export to Excel</button>
        
        <!-- Tombol Ekspor ke PDF -->
        <button class="btn-export" onclick="printPage()">Export As PDF</button>
        
        <table class="table table-bordered table-striped" id="transactionsTable">
            <thead>
                <tr>
                    <th>Type</th>
                    <th>Nominal</th>
                    <th>Keterangan</th>
                    <th>Tanggal</th> <!-- Kolom baru untuk Tanggal -->
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $transaction)
                    <tr>
                        <td>{{ ucfirst($transaction->type) }}</td>
                        <td>{{ number_format($transaction->amount, 0, ',', '.') }}</td>
                        <td>{{ $transaction->description }}</td>
                        <td>{{ \Carbon\Carbon::parse($transaction->date)->format('Y-m-d') }}</td> <!-- Tanggal -->
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="no-results" id="noResults">Tidak ditemukan</div>
    </div>
</div>

<script>
    function printPage() {
        window.print();
    }

    function filterTransactions() {
        const input = document.getElementById('search');
        const filter = input.value.toLowerCase();
        const table = document.getElementById('transactionsTable');
        const tr = table.getElementsByTagName('tr');
        let hasResults = false;

        for (let i = 1; i < tr.length; i++) {
            const tdType = tr[i].getElementsByTagName('td')[0];
            const tdNominal = tr[i].getElementsByTagName('td')[1];
            const tdKeterangan = tr[i].getElementsByTagName('td')[2];
            const tdTanggal = tr[i].getElementsByTagName('td')[3]; // Ambil kolom tanggal
            
            if (tdType || tdNominal || tdKeterangan || tdTanggal) {
                const txtValueType = tdType.textContent || tdType.innerText;
                const txtValueNominal = tdNominal.textContent || tdNominal.innerText;
                const txtValueKeterangan = tdKeterangan.textContent || tdKeterangan.innerText;
                const txtValueTanggal = tdTanggal.textContent || tdTanggal.innerText; // Ambil teks tanggal

                if (txtValueType.toLowerCase().indexOf(filter) > -1 ||
                    txtValueNominal.toLowerCase().indexOf(filter) > -1 ||
                    txtValueKeterangan.toLowerCase().indexOf(filter) > -1 ||
                    txtValueTanggal.toLowerCase().indexOf(filter) > -1) { // Cek juga tanggal
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
</script>
@endsection
