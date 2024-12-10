@extends('templates.app')
{{-- extends : mengimport/memanggil file view (biasanya untuk template nya, isi dr template merupakan content tetap/content yg selalu ada di setiap halaman) --}}

{{-- section : mengisi element html ke yield dengan nama yg sama ke file templatenya --}}
@section('content-dinamis')
    <div class="container text-center mt-5">
        <h2 class="welcome-message">HALLO, SELAMAT DATANG, {{ Auth::user()->email }}</h2>
     

        @if (Session::get('failed'))
            <div class="alert alert-danger">{{ Session::get('failed')}}</div>
        @endif
@endsection

<style>
/* Styling dasar untuk body */
body {
    background-color: #f0f8ff; /* Warna latar belakang lembut */
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; /* Jenis huruf */
    color: #333; /* Warna teks utama */
}

/* Kontainer utama */
.container {
    max-width: 800px; /* Lebar maksimum */
    margin: 0 auto; /* Center kontainer */
    padding: 20px; /* Padding dalam kontainer */
    background-color: #ffffff; /* Warna latar belakang kontainer */
    border-radius: 12px; /* Sudut membulat */
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15); /* Bayangan */
}

/* Styling untuk judul Apotek */
.apotek-title {
    color: #007bff; /* Warna biru untuk teks */
    font-size: 3rem; /* Ukuran font besar */
    font-weight: 700; /* Teks tebal */
    margin-bottom: 15px; /* Jarak bawah */
}

/* Styling untuk heading selamat datang */
.welcome-message {
    color: #333; /* Warna teks utama */
    font-size: 2.5rem; /* Ukuran teks besar */
    font-weight: 700; /* Teks tebal */
    margin-bottom: 15px; /* Jarak bawah */
}

/* Styling untuk subtext */
.subtext {
    font-size: 1.2rem; /* Ukuran font untuk subtext */
    color: #555; /* Warna subtext */
    font-weight: 400; /* Teks normal */
    line-height: 1.6; /* Jarak antar baris */
    margin-bottom: 30px; /* Jarak bawah */
}

/* Alert styling */
.alert-danger {
    background-color: #f8d7da; /* Warna latar belakang alert */
    color: #721c24; /* Warna teks alert */
    border: 1px solid #f5c6cb; /* Border alert */
    border-radius: 8px; /* Sudut membulat */
    padding: 12px; /* Padding dalam alert */
    text-align: center; /* Teks rata tengah */
    margin-bottom: 20px; /* Jarak bawah */
}

/* Additional Info styling */
.additional-info h3 {
    color: #007bff; /* Warna biru untuk teks */
    font-size: 1.8rem; /* Ukuran teks */
    margin: 10px 0; /* Jarak atas dan bawah */
}

/* Responsif untuk perangkat kecil */
@media (max-width: 768px) {
    .apotek-title {
        font-size: 2.5rem; /* Ukuran font lebih kecil di layar kecil */
    }
    .welcome-message {
        font-size: 2rem; /* Ukuran font lebih kecil di layar kecil */
    }
    .subtext {
        font-size: 1rem; /* Ukuran font subtext lebih kecil */
    }
    .additional-info h3 {
        font-size: 1.5rem; /* Ukuran teks lebih kecil untuk info tambahan */
    }
}
</style>

