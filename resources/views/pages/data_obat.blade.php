@extends('templates.app')

@section('content-dinamis')
    <div class="container mt-5">
        <div class="d-flex justify-content-end">
            <form class="d-flex me-3" action="{{ route('data_obat.data') }}" method="GET">
                {{-- 1. tag form harus ada action sama method
                    2. value method GET/POST
                        - GET : form yg fungsinya untuk mencari
                        - POST : form yg fungsinya untuk menambah/menghapus/mengubah
                    3. input harus ada attr name, name => mengambil data dr isian input agar bisa di proses di controller
                    4. ada button/input yg type="submit"
                    5. action
                        - form untuk mencari : action ambil route yg menampilkan halaman blade ini (return view blade ini)
                        - form bukan mencari : action terpisah dengan route return view bladenya
                 --}}
                @if (Request::get('sort_stock') == 'stock')
                    <input type="hidden" name="sort_stock" value="stock">
                @endif
                <input type="text" name="cari" placeholder="Cari Nama Obat..." class="form-control me-2">
                <button type="submit" class="btn btn-primary">Cari</button>
            </form>
            <form action="{{ route('data_obat.data') }}" method="GET" class="me-2">
                <input type="hidden" name="sort_stock" value="stock">
                <button type="submit" class="btn btn-primary">Urutkan Stok</button>
            </form>
            {{-- <button class="btn btn-success">+ Tambah</button> --}}

            <a href="{{ route('data_obat.tambah')}}" class="btn btn-success">+ Tambah</a>
        </div>

        @if(Session::get('success'))
        <div class="alert alert-success">
            {{ Session::get('success')}}
        </div>
    @endif
        <table class="table table-stripped table-bordered mt-3 text-center">
            <thead>
                <th>#</th>
                <th>Nama Obat</th>
                <th>Tipe</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Aksi</th>
            </thead>
            <tbody>
                {{-- jika data obat kosong --}}
                @if (count($medicines) < 0)
                    <tr>
                        <td colspan="6">Data Obat Kosong</td>
                    </tr>
                @else
                {{-- $medicines : dari compact controller nya, diakses dengan loop karna data $medicines banyak (array) --}}
                    @foreach ($medicines as $index => $item)
                        <tr>
                            <td>{{ ($medicines->currentPage()-1) * ($medicines->perpage()) + ($index+1) }}</td>
                            <td>{{ $item['name'] }}</td>
                            <td>{{ $item['type'] }}</td>
                            <td>Rp. {{ number_format($item['price'], 0, ',', '.') }}</td>
                            <td class="{{ $item['stock'] <= 3 ? 'bg-danger text-white' : '' }}" style="cursor: pointer;" onclick="showModalStock({{ $item ['id']}} , {{ $item['stock']}})">{{ $item['stock'] }}</td>
                            {{-- $item['column_di_migration'] --}}
                            <td class="d-flex justify-content-center">
                                <a href="{{ route('data_obat.ubah',$item['id']) }}" class="btn btn-primary me-2">Edit</a>
                                <button class="btn btn-danger" onclick ="showModalDelete( '{{ $item->id }}','{{ $item->name}}')">Hapus</button>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>

        {{-- memanggil pagination --}}
        <div class="d-flex justify-content-end my-3">
            {{ $medicines->links() }}
        </div>
        <!-- Modal -->

        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form class="modal-content" method="POST" action="">
        {{-- action kosong,diisi melalui js karna id dikirim le js nya--}}
        @csrf
        {{-- menimpa method="POST" jadi DELETE sesuai web.php hhtp-method--}}
        @method('DELETE')
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">HAPUS DATA OBAT</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            {{-- konten dinamis pada teks ini bagian nama obat ,sehingga nama obatnya disediakan tempat penyimpanan (tag--}}
          Apakah Anda Yakin Ingin Menghapus Data Obat <bd id="nama_obat"></b>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-danger">Hapus</button>
        </div>
    </form>
    </div>
  </div>
    </div>


    <!-- Modal stok -->
    <div class="modal fade" id="modalEditStock" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <form class="modal-content" method="POST" action="">
            {{-- action kosong,diisi melalui js karna id dikirim le js nya--}}
            @csrf
            {{-- menimpa method="POST" jadi DELETE sesuai web.php hhtp-method--}}
            @method('PATCH')
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">EDIT STOK OBAT</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{-- konten dinamis pada teks ini bagian nama obat ,sehingga nama obatnya disediakan tempat penyimpanan (tag--}}
              <div class="from-group">
                <label for="stock" class="form-label">Stok :</label>
                <input type="number" name="stock" id="stock" class="form-control">
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
              <button type="submit" class="btn btn-primaru">Edit</button>
            </div>
        </form>
        </div>
      </div>

@endsection



@push('script')
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>
    function showModalDelete(id, name) {
         //memasukan teks dari parameter ke html nagian id="nama_obat"
    $("#nama_obat").text(name);
    //memanggil route hapus
    let url = "{{ route('data_obat.hapus', ':id') }}";
    //isi path dinamis :id dari data parameter id
    url = url.replace(':id', id);
    //action="" di form diisi dengan url di atas 
    $("form").attr("action", url);
    //munculkan modal dengan id="exampleModal"
    $('#exampleModal').modal('show');
    }

    function showModalStock(id, stock) {
        //value input id="stock"
        $("#stock").val(stock);
        let url = "{{ route('data_obat.ubah.stok', ':id') }}";
        url = url.replace(':id', id);
        $("form").attr('action', url);
        $("#modalEditStock").modal("show");
    }
    //jika eror isset (ada with failed,modal jangan di close)
    //if menggunakan @ karna dia ngambil session (data dari bahasa php)
    @if(Session::get('failed'))
    //isi param id,stok di showModalStock ambil dari with controller updateStock
    $( document ).ready(function(){
        let id ="{{Session::get('id')}}";
        let stock = "{{Session::get('stock')}}";
        showModalStock(id,stock);
    })
    @endif
</script> 
@endpush

<style>
    /* Styling dasar untuk body */
body {
    background-color: #f8f9fa;
    font-family: 'Poppins', sans-serif;
    color: #343a40;
}

/* Styling container */
.container {
    background-color: #ffffff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    margin-bottom: 20px;
}

/* Form Pencarian */
form.d-flex input[type="text"] {
    border-radius: 5px;
    border: 1px solid #ced4da;
    padding: 8px 15px;
    width: 200px;
    transition: all 0.3s ease;
}

form.d-flex input[type="text"]:focus {
    border-color: #007bff;
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.3);
}

form.d-flex button {
    padding: 8px 20px;
    border-radius: 5px;
    background-color: #007bff;
    color: #fff;
    border: none;
    transition: all 0.3s ease;
}

form.d-flex button:hover {
    background-color: #0056b3;
}

.btn-success {
    background-color: #28a745;
    color: #fff;
    padding: 10px 20px;
    border-radius: 5px;
    transition: all 0.3s ease;
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
    color: #fff;
    padding: 12px 15px;
    text-align: center;
    border: 1px solid #dee2e6;
}

.table tbody td {
    padding: 10px 15px;
    border: 1px solid #dee2e6;
    text-align: center;
}

.table tbody tr:nth-child(even) {
    background-color: #f8f9fa;
}

.table .bg-danger {
    background-color: #dc3545;
}

.table .bg-danger:hover {
    background-color: #c82333;
}

.table .btn {
    padding: 5px 10px;
    font-size: 14px;
}

/* Pagination */
.pagination {
    justify-content: center;
}

.pagination .page-item .page-link {
    color: #007bff;
}

.pagination .page-item.active .page-link {
    background-color: #007bff;
    border-color: #007bff;
}

/* Alert sukses */
.alert-success {
    margin-top: 20px;
    padding: 10px;
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
    border-radius: 5px;
}

/* Modal Styling */
.modal-content {
    border-radius: 10px;
    padding: 20px;
}

.modal-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
}

.modal-title {
    font-weight: bold;
    color: #dc3545;
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

    .form-control {
        width: 100%;
    }
}

</style>