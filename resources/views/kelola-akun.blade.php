@extends('templates.app')

@section('content-dinamis')
    <div class="container mt-5">
        <!-- Bagian Pencarian dan Tombol Tambah -->
        <div class="d-flex justify-content-end">
            <!-- Form pencarian pengguna berdasarkan nama -->
            <form class="d-flex me-3" action="{{ route('kelola_akun.user') }}" method="GET">
                <!-- Mengecek apakah parameter pengurutan sort_role digunakan, jika ya menyertakan dalam form -->
                @if (Request::get('sort_role') == 'role')
                    <input type="hidden" name="sort_role" value="role">
                @endif
                <!-- Input pencarian nama dan tombol submit -->
                <input type="text" name="cari" placeholder="Cari Nama Pengguna..." class="form-control me-2">
                <button type="submit" class="btn btn-primary">Cari</button>
            </form>

            <!-- Tombol tambah pengguna baru -->
            <a href="{{ route('kelola_akun.tambah') }}" class="btn btn-success">+ Tambah</a>
        </div>

        <!-- Pesan sukses jika ada session dengan key 'success' -->
        @if(Session::get('success'))
            <div class="alert alert-success">
                {{ Session::get('success') }}
            </div>
        @endif

        <!-- Tabel Data Pengguna -->
        <table class="table table-stripped table-bordered mt-3 text-center">
            <thead>
                <th>#</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
                <th>Aksi</th>
            </thead>
            <tbody>
                <!-- Jika tidak ada data pengguna, tampilkan pesan -->
                @if (count($users) < 1)
                    <tr>
                        <td colspan="5">Data Pengguna Kosong</td>
                    </tr>
                @else
                    <!-- Looping untuk menampilkan data pengguna -->
                    @foreach ($users as $index => $user)
                        <tr>
                            <!-- Penomoran halaman sesuai dengan pagination -->
                            <td>{{ ($users->currentPage() - 1) * ($users->perpage()) + ($index + 1) }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->role }}</td>
                            <!-- Tombol untuk mengedit dan menghapus pengguna -->
                            <td class="d-flex justify-content-center">
                                <a href="{{ route('kelola_akun.ubah', $user->id) }}" class="btn btn-primary me-2">Edit</a>
                                <button class="btn btn-danger" onclick="showModalDelete('{{ $user->id }}', '{{ $user->name }}')">Hapus</button>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>

        <!-- Navigasi pagination -->
        <div class="d-flex justify-content-end my-3">
            {{ $users->links() }}
        </div>

        <!-- Modal konfirmasi hapus pengguna -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form class="modal-content" method="POST" action="">
                    @csrf
                    <!-- Override method menjadi DELETE sesuai dengan route penghapusan -->
                    @method('DELETE')
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">HAPUS DATA PENGGUNA</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Konfirmasi hapus dengan nama pengguna yang dipilih -->
                        Apakah Anda Yakin Ingin Menghapus Data Pengguna <b id="nama_user"></b>?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>
    // Fungsi untuk menampilkan modal konfirmasi hapus
    function showModalDelete(id, name) {
        // Menampilkan nama pengguna di dalam modal
        $("#nama_user").text(name);
        // Mengganti ID dalam URL action sesuai ID pengguna
        let url = "{{ route('kelola_akun.hapus', ':id') }}";
        url = url.replace(':id', id);
        // Mengatur action form sesuai dengan ID pengguna
        $("form").attr("action", url);
        // Menampilkan modal
        $('#exampleModal').modal('show');
    }

    // Jika ada session failed, jalankan fungsi tertentu
    @if(Session::get('failed'))
        $(document).ready(function(){
            let id = "{{ Session::get('id') }}";
            let role = "{{ Session::get('role') }}";
            // Anda dapat menambahkan fungsi tambahan di sini jika diperlukan untuk modal edit
        });
    @endif
</script>
@endpush

<style>
    /* Styling dasar untuk body */
body {
    background-color: #f9f9f9;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    color: #333;
}

/* Container styling untuk keseluruhan halaman */
.container {
    background-color: #ffffff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

/* Form pencarian dan tombol tambah */
form.d-flex input[type="text"] {
    border-radius: 5px;
    border: 1px solid #ccc;
    padding: 5px 10px;
    width: 200px;
    transition: all 0.3s ease;
}

form.d-flex input[type="text"]:focus {
    border-color: #007bff;
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.3);
}

.btn-primary,
.btn-success {
    padding: 10px 20px;
    border-radius: 5px;
    font-size: 16px;
}

.btn-primary:hover,
.btn-success:hover {
    background-color: #0056b3;
}

.btn-success {
    background-color: #28a745;
}

.btn-success:hover {
    background-color: #218838;
}

/* Styling tabel */
.table {
    margin-top: 20px;
    width: 100%;
    border-collapse: collapse;
}

.table thead th {
    background-color: #007bff;
    color: #ffffff;
    padding: 12px 15px;
    text-align: center;
    border: 1px solid #ddd;
}

.table tbody td {
    padding: 10px 15px;
    border: 1px solid #ddd;
    text-align: center;
}

.table tbody tr:nth-child(even) {
    background-color: #f2f2f2;
}

/* Tombol aksi (edit & hapus) */
.table .btn {
    padding: 5px 10px;
    font-size: 14px;
}

/* Pesan sukses */
.alert-success {
    margin-top: 20px;
    padding: 10px;
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
    border-radius: 5px;
}

/* Modal styling */
.modal-content {
    border-radius: 8px;
    padding: 20px;
}

.modal-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
}

.modal-title {
    font-weight: bold;
    color: #dc3545; /* Warna merah untuk penghapusan */
}

.modal-body {
    font-size: 16px;
}

.modal-footer .btn-secondary {
    background-color: #6c757d;
    border: none;
}

.modal-footer .btn-danger {
    background-color: #dc3545;
}

.modal-footer .btn-danger:hover {
    background-color: #c82333;
}

/* Responsif untuk perangkat kecil */
@media (max-width: 768px) {
    .container {
        padding: 15px;
    }

    .table thead th, .table tbody td {
        padding: 8px;
        font-size: 14px;
    }

    .btn {
        font-size: 12px;
    }
}

</style>