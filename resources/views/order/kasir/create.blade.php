@extends('templates.app')

@section('content-dinamis')
<div class="container mt-3">

    <form action="{{ route('kasir.store') }}" class="card m-auto p-5" method="POST">
        @csrf

        {{-- Validation error messages --}}
        @if ($errors->any())
            <ul class="alert alert-danger p-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        {{-- Session failure message --}}
        @if (Session::get('failed'))
            <div class="alert alert-danger">{{ Session::get('failed') }}</div>
            @php
                $valueFormBefore = Session::get('valueFormBefore');
            @endphp
        @endif

        <p>Penanggung Jawab: <b>{{ Auth::user()->name }}</b></p>

        <div class="mb-3 row">
            <label for="name_customer" class="col-sm-2 col-form-label">Nama Pembeli</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="name_customer" name="name_customer" value="{{ $valueFormBefore['name_customer'] ?? ''}}">
            </div>

        </div>

        <div class="mb-3 row">
            <label for="medicines" class="col-sm-2 col-form-label">Obat</label>
            <div class="col-sm-10">
                @if (isset ($valueFormBefore))
                  @foreach ($valueFormBefore['medicines'] as $key =>$medicine)
                  <div class="d-flex" id="medicines-{{$key}}">
                      <select name="medicines[]" id="medicines" class="form-select mb-2">
                        @foreach ($medicines as $item)
                        <option value="{{ $item['id']}}" {{ $medicine == $item['id'] ? 'selected' : ''}}>{{ $item['name']}}</option>
                        @endforeach
                    </select>
                    <div>
                        <span style="cursor:pointer" onclick="deleteSelect('medicines-{{$key}}')">X</span>
                    </div>
                  </div>
            @endforeach
            @else
                {{-- Name is an array to allow multiple medicines selection --}}
                <select name="medicines[]" id="medicines" class="form-select">
                    <option selected hidden disabled>Pesanan 1</option>
                    @foreach ($medicines as $item)
                        <option value="{{ $item['id'] }}">{{ $item['name'] }}</option>
                    @endforeach
                </select>
                
            </div>
            @endif
        </div>

        {{-- Container for additional medicine selects --}}
        <div id="wrap-medicines"></div>
        <br>
        <p style="cursor: pointer" class="text-primary" id="add-select">+ tambah obat</p>

        <button type="submit" class="btn btn-block btn-lg btn-primary">Konfirmasi Pembelian</button>
    </form>
</div>
@endsection

@push('script')
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous" ></script>
<script>
    let no ={{ isset($valueFormBefore) ? count($valueFormBefore['medicines']) +1 : 2}};

    // Add new medicine select on click
    $("#add-select").on("click", function() {
        let el = ` <div id="medicines-${no}" class="d-flex mb-2">
            <br>
            <select name="medicines[]" class="form-select">
                <option selected hidden disabled>Pesanan ${no}</option>
                @foreach ($medicines as $item)
                    <option value="{{ $item['id'] }}">{{ $item['name'] }}</option>
                @endforeach
            </select>
            <span style="cursor:pointer" onclick="deleteSelect('medicines-${no}')">X</span>
            </div>
        `;
        $("#wrap-medicines").append(el);
        no++;
    });
    function deleteSelect(elementId) {
        //pakai abcklik karna mau panggil variable
        //remove:mengahpus element terkait
        $(`#${elementId}`).remove()
    }
</script>
@endpush
<style>
    /* Container styling */
.container {
    max-width: 700px;
    margin-top: 30px;
    padding: 20px;
}

/* Card styling */
.card {
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
    background: linear-gradient(135deg, #e0f7fa, #ffffff);
    transition: transform 0.3s ease;
}

.card:hover {
    transform: scale(1.02);
}

/* General form input styling */
.form-control, .form-select {
    border-radius: 5px;
    padding: 10px;
    border: 1px solid #ddd;
    transition: all 0.3s ease;
    background-color: #fefefe;
}

.form-control:focus, .form-select:focus {
    border-color: #ff4081;
    box-shadow: 0 0 8px rgba(255, 64, 129, 0.4);
}

/* Label styling */
.col-form-label {
    font-weight: bold;
    color: #ff4081;
}

/* Button styling */
.btn-primary {
    background-color: #29b6f6;
    border: none;
    padding: 12px 20px;
    font-size: 1rem;
    border-radius: 5px;
    transition: all 0.3s ease;
    width: 100%;
    color: #fff;
}

.btn-primary:hover {
    background-color: #0288d1;
    box-shadow: 0px 4px 8px rgba(2, 136, 209, 0.4);
    transform: translateY(-2px);
}

/* Error message styling */
.alert-danger {
    border-radius: 5px;
    color: #fff;
    background-color: #ff5252;
    border: none;
    padding: 10px;
    font-weight: bold;
    animation: fadeIn 0.5s ease-in-out;
}

/* Add medicine link */
.text-primary {
    color: #ff4081;
    cursor: pointer;
    font-weight: bold;
    transition: color 0.3s ease;
}

.text-primary:hover {
    color: #d81b60;
}

/* Animations */
@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

</style>