@extends('templates.app') <!-- Menggunakan template 'app' sebagai layout dasar -->

@section('content-dinamis') <!-- Menandai bagian konten dinamis -->

{{-- Bagian ini dapat diaktifkan jika diperlukan, untuk menampilkan judul atau informasi tambahan
<div class="container">
    <h1>Create</h1>
</div> --}}

<form action="{{ route('kelola_akun.tambah.proses')}}" class="card p-5" method="POST"> <!-- Form untuk mengirim data ke route yang ditentukan -->
    @csrf <!-- Menambahkan token CSRF untuk keamanan form -->
    
    @if($errors->any()) <!-- Mengecek jika ada error yang dikirimkan -->
        <div class="alert alert-danger"> <!-- Menampilkan pesan error -->
            <ul>
                @foreach($errors->all() as $error) <!-- Mengulangi semua error -->
                    <li>{{ $error }}</li> <!-- Menampilkan setiap error sebagai item list -->
                @endforeach
            </ul>
        </div>
    @endif

    @if (Session::get('success')) <!-- Mengecek jika ada pesan sukses di session -->
        <div class="alert alert-success"> <!-- Menampilkan pesan sukses -->
            {{ Session::get('success') }} <!-- Menampilkan isi pesan sukses -->
        </div>
    @endif
    
    <!-- Input untuk Nama -->
    <div class="mb-3 row">
        <label for="name" class="col-sm-2 col-form-label">Nama: </label> <!-- Label untuk input Nama -->
        <div class="col-sm-10">
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}"> <!-- Input untuk Nama dengan value dari old input -->
        </div>
    </div>
    
    <!-- Input untuk Email -->
    <div class="mb-3 row">
        <label for="email" class="col-sm-2 col-form-label">Email: </label> <!-- Label untuk input Email -->
        <div class="col-sm-10">
            <input type="text" class="form-control" id="email" name="email" value="{{ old('email') }}"> <!-- Input untuk Email -->
        </div>
    </div>
    
    <!-- Input untuk Password -->
    <div class="mb-3 row">
        <label for="password" class="col-sm-2 col-form-label">Password: </label> <!-- Label untuk input Password -->
        <div class="col-sm-10">
            <input type="password" class="form-control" id="password" name="password" value="{{ old('password') }}"> <!-- Input untuk Password, sebaiknya tipe password -->
        </div>
    </div>

    <!-- Input untuk Role -->
    <div class="mb-3 row">
        <label for="type" class="col-sm-2 col-form-label">Role: </label> <!-- Label untuk input Role -->
        <div class="col-sm-10">
            <select class="form-select" name="type" id="type"> <!-- Dropdown untuk memilih Role -->
                <option selected disabled hidden>Pilih</option> <!-- Pilihan awal yang tidak bisa dipilih -->
                <option value="admin" {{ old('type') == "admin" ? 'selected' : ''}}>admin</option> <!-- Pilihan admin -->
                <option value="kasir" {{ old('type') == "kasir" ? 'selected' : ''}}>Kasir</option> <!-- Pilihan kasir -->
                <option value="user" {{ old('type') == "user" ? 'selected' : ''}}>User</option> <!-- Pilihan user -->
            </select>
        </div>
    </div>

    <button type="submit" class="btn btn-primary mt-3">Kirim</button> <!-- Tombol untuk mengirim form -->
</form>
@endsection <!-- Mengakhiri bagian konten dinamis -->
