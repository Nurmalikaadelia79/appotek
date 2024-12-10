@extends('templates.app')

@section('content-dinamis')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Lilita+One&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
    th {
        text-align: center
    }

    h1 {
        font-family: "Poppins", sans-serif;
        font-weight: 700
    }
</style>
    <div class="container mt-4">
        <div class="d-flex justify-content-end">
            <a href="{{route('kasir.tambah')}}" class="btn btn-primary">Tambah order</a>
        </div>
        <table class="table table-stripped table-bordered mt-3 text-center">
            <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th>Pembeli</th>
                    <th>Medicines</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->name_customer }}</td>
                        <td>
                            <ol>
                                @foreach ($order->medicines as $medicine)
                                    <li>{{ $medicine['name_medicine'] }}</li>
                                @endforeach
                            </ol>
                        </td>
                        <td>{{\Carbon\Carbon::parse($order->created_at)->locale('id')->translatedFormat('d F, Y H:i:s') }}</td>
                        <td>
                            <a href="{{ route('kasir.download.pdf', $order->id) }}" class="btn btn-primary">Print PDF</a>
                        </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div>
        {{ $orders->links() }}
        </div>
    </div>
@endsection
<style>
/* CSS for container */
/* Container styling */
.container {
    background-color: #E0F7FA; /* Biru muda lembut */
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

/* CSS for the button */
.btn-primary {
    background-color: #B3E5FC; /* Biru pastel */
    color: #333; /* Teks gelap untuk kontras */
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    transition: background-color 0.3s ease;
}

.btn-primary:hover {
    background-color: #81D4FA; /* Biru pastel lebih gelap saat hover */
    color: #333;
}

/* Fix for alignment issues */
.d-flex.justify-content-end {
    justify-content: flex-end;
}


</style>