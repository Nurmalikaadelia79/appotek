@extends('templates.app') 
<!-- Meng-extend template app yang sudah ada -->

@section('content-dinamis') 
<!-- untuk menyimpan konten dinamis(konten dinamis didpatkan dari yield) -->

{{-- <div class="container"> 
    <h1>Create</h1>
</div> --}}
<!-- Kode komentar HTML yang bisa digunakan untuk menampilkan judul, saat ini tidak ditampilkan -->

<!-- Form untuk mengedit data pengguna -->
<form action="{{ route('kelola_akun.ubah.proses', $user['id'])}}" method="POST" class="card p-5">
    <!-- Form ini akan mengirim data ke route 'kelola_akun.ubah.proses' dengan method POST, 
    dan menggunakan data dari pengguna yang akan diubah berdasarkan ID -->

    @csrf 
    <!-- Token CSRF digunakan untuk keamanan dalam pengiriman form -->

    @method('PATCH') 
    <!-- Mengubah method form menjadi PATCH karena kita akan memperbarui data -->

    <!-- Menampilkan pesan kesalahan validasi jika ada -->
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li> 
                    <!-- Menampilkan setiap pesan kesalahan yang terjadi selama validasi -->
                @endforeach
            </ul>
        </div>
    @endif
    <!-- Bagian ini akan memeriksa apakah ada error pada form dan menampilkan pesan error yang sesuai -->

    <!-- Input untuk nama pengguna -->
    <div class="mb-3 row">
        <label for="name" class="col-sm-2 col-form-label">Nama : </label>
        <!-- Label untuk input nama pengguna -->
        <div class="col-sm-10">
            <input type="text" class="form-control" id="name" name="name" value="{{ $user['name'] }}"> <!-- untuk data tetap ada tidak hilang -->
            <!-- Input text untuk memasukkan atau memperbarui nama pengguna, nilai default diambil dari data pengguna -->
        </div>
    </div>

    <!-- Input untuk email pengguna -->
    <div class="mb-3 row">
        <label for="email" class="col-sm-2 col-form-label">Gmail: </label>
        <!-- Label untuk input email pengguna -->
        <div class="col-sm-10">
            <input type="text" class="form-control" id="email" name="email" value="{{ $user['email']}}">
            <!-- Input text untuk memasukkan atau memperbarui email pengguna, nilai default diambil dari data pengguna -->
        </div>
    </div>

    <!-- Input untuk password pengguna -->
    <div class="mb-3 row">
        <label for="password" class="col-sm-2 col-form-label">Password: </label>
        <!-- Label untuk input password pengguna -->
        <div class="col-sm-10">
            <input type="text" class="form-control" id="password" name="password">
            <!-- Input text untuk memasukkan password baru jika diperlukan -->
        </div>
    </div>

    <!-- Dropdown untuk memilih role pengguna -->
    <div class="mb-3 row">
        <label for="type" class="col-sm-2 col-form-label">Role : </label>
        <!-- Label untuk memilih role pengguna -->
        <div class="col-sm-10">
            <select class="form-select" name="type" id="type">
                <!-- Dropdown untuk memilih peran (role) pengguna -->
                <option value="admin" {{ $user['type'] == "admin" ? 'selected' : ''}}>admin</option>
                <!-- Pilihan 'admin', akan otomatis terpilih jika role pengguna saat ini adalah admin -->
                <option value="kasir" {{ $user['type'] == "kasir" ? 'selected' : ''}}>Kasir</option>
                <!-- Pilihan 'kasir', akan otomatis terpilih jika role pengguna saat ini adalah kasir -->
                <option value="user" {{ $user['type'] == "user" ? 'selected' : ''}}>User</option>
                <!-- Pilihan 'user', akan otomatis terpilih jika role pengguna saat ini adalah user -->
            </select>
        </div>
    </div>

    <!-- Tombol untuk mengirimkan form -->
    <button type="submit" class="btn btn-primary mt-3">Kirim</button>
    <!-- Tombol submit untuk mengirim data form -->
</form>

@endsection
<!-- Menutup section 'content-dinamis' -->
