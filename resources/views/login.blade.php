@extends('templates.app')

@section('content-dinamis')
<div class="container mt-4">
    <h2 class="text-center text-primary mb-4">LOGIN TERLEBIH DAHULU</h2>
    <form action="{{ route('login.proses')}}" method="POST" class="card d-block mx-auto p-5 w-75">
        @csrf
        @if (Session::get('failed'))
        <div class="alert alert-danger">
            {{ Session::get('failed')}}
        </div>
        @endif
        @if (Session::get('logout'))
        <div class="alert alert-primary">{{ Session::get('logout')}}</div>
        @endif
        <div class="form-group">
            <label for="email" class="form-label">Email :</label>
            <input type="email" name="email" id="email" class="form-control">
            @error('email')
                <small class="text-danger">{{ $message}}</small>
            @enderror
        </div>
        <div class="form-group">
            <label for="password" class="form-label">Password :</label>
            <input type="password" name="password" id="password" class="form-control mb-4">
            @error('password')
                <small class="text-danger">{{ $message}}</small>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary w-100">LOGIN</button>
    </form>
</div>
@endsection

<style>
/* Styling dasar untuk body */
body {
    background-color: #f0f8ff;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    color: #333;
}

/* Heading styling */
.text-center.text-primary {
    font-size: 1.8rem;
    color: #007bff;
    font-weight: bold;
}

/* Styling untuk card form dengan latar belakang biru */
.card {
    background-color: #e0f7fa; /* Biru terang lembut */
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    transition: transform 0.3s;
}
.card:hover {
    transform: translateY(-5px);
}

/* Spasi antara elemen form */
.form-group {
    margin-bottom: 1.5rem;
}

/* Label form */
.form-label {
    font-weight: 600;
    color: #333;
}

/* Input styling */
.form-control {
    padding: 12px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 16px;
    transition: all 0.3s ease;
}

/* Hover dan fokus pada input */
.form-control:focus {
    border-color: #007bff;
    box-shadow: 0 0 8px rgba(0, 123, 255, 0.3);
}

/* Tombol login */
.btn-primary {
    background-color: #007bff;
    border: none;
    padding: 12px;
    font-size: 1rem;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

.btn-primary:hover {
    background-color: #0056b3;
}

/* Alert styling */
.alert {
    padding: 10px;
    margin-bottom: 15px;
    border-radius: 5px;
    font-size: 0.9rem;
}

.alert-danger {
    background-color: #ffcccc;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

.alert-primary {
    background-color: #cce5ff;
    color: #004085;
    border: 1px solid #b8daff;
}

/* Responsif untuk perangkat kecil */
@media (max-width: 768px) {
    .card {
        width: 90%;
        padding: 20px;
    }

    .btn-primary {
        padding: 10px;
    }

    .text-center.text-primary {
        font-size: 1.5rem;
    }
}
</style>
