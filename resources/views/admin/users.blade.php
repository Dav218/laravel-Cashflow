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
        <h1>Daftar Semua Akun</h1>
    </div>
    <div class="card-body">
        <input type="text" class="form-control search-input" placeholder="Cari akun..." id="search" onkeyup="filterUsers()">
        
        <table class="table table-striped" id="userTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->role }}</td>
                        <td>
                            <button class="btn btn-primary" data-toggle="modal" data-target="#editUserModal{{ $user->id }}">Edit</button>
                            <form action="{{ route('user.destroy', $user->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus akun ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>

                    <!-- Modal Edit User -->
                    <div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editUserModalLabel">Edit User {{ $user->name }}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('user.update', $user->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input type="text" class="form-control" name="name" value="{{ $user->name }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control" name="email" value="{{ $user->email }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="password">Password (Kosongkan jika tidak ingin mengubah)</label>
                                            <input type="password" class="form-control" name="password">
                                        </div>
                                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Tidak ada akun ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="no-results" id="noResults">Tidak ditemukan</div>
        <a href="{{ route('home') }}" class="btn-back">Kembali</a>
    </div>
</div>

<script>
    function filterUsers() {
        const input = document.getElementById('search');
        const filter = input.value.toLowerCase();
        const table = document.getElementById('userTable');
        const tr = table.getElementsByTagName('tr');
        let hasResults = false;

        for (let i = 1; i < tr.length; i++) {
            const tdName = tr[i].getElementsByTagName('td')[1];
            const tdEmail = tr[i].getElementsByTagName('td')[2];
            const tdRole = tr[i].getElementsByTagName('td')[3];

            if (tdName || tdEmail || tdRole) {
                const txtValueName = tdName.textContent || tdName.innerText;
                const txtValueEmail = tdEmail.textContent || tdEmail.innerText;
                const txtValueRole = tdRole.textContent || tdRole.innerText;

                if (
                    txtValueName.toLowerCase().indexOf(filter) > -1 ||
                    txtValueEmail.toLowerCase().indexOf(filter) > -1 ||
                    txtValueRole.toLowerCase().indexOf(filter) > -1
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
</script>
@endsection
