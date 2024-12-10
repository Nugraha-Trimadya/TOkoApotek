@extends('layouts.layout')

@section('content')
    @if (Session::get('failed'))
        <div class="alert alert-danger text-center">
            {{ Session::get('failed') }}
        </div>
    @endif
    <form action="{{ route('pembelian.store_order') }}" class="card mx-auto my-5 d-block p-5 w-75" method="POST">
        @csrf
        <p>Penanggung Jawab: <b>{{ Auth::user()->name }}</b></p>
        <div class="mb-3 row">
            <label for="name_customer" class="col-sm-2 col-form-label">Nama Pembeli:</label>
            <div class="col-sm-10">
                <input type="text" name="name_customer" id="name_customer" class="form-control">
            </div>
        </div>
        <div class="row mb-3">
            <label for="medicines" class="col-sm-2 col-form-label">Obat :</label>
            <div class="col-sm-10">
                @if(isset($valueBefore))
                    @foreach($valueBefore['medicines'] as $key => $medicine)
                        <div class="d-flex" id="medicines-{{ $key }}">
                            <select name="medicines[]" id="medicines-{{ $key }}" class="form-select">
                                <option disabled selected hidden>Pesanan {{ $key + 1 }}</option>
                                @foreach ($medicines as $item)
                                    <option value="{{ $item['id'] }}" 
                                            @if($item['id'] == $medicine['id']) selected @endif>
                                        {{ $item['name'] }} ({{ $item['stock'] }})
                                    </option>
                                @endforeach
                            </select>
                            @if($key > 0)
                                <div>
                                    <span style="cursor: pointer" class="text-danger p-4" onclick="deleteSelect('medicines-{{ $key }}')">X</span>
                                </div>
                            @endif
                        </div>
                        <br>
                    @endforeach
                @else
                    <select name="medicines[]" id="medicines-0" class="form-select" value="{{ old('medicines[]') }}">
                        <option selected hidden disabled>Pesanan 1</option>
                        @foreach ($medicines as $item)
                            <option value="{{ $item['id'] }}">{{ $item['name'] }} ({{ $item['stock'] }})</option>
                        @endforeach
                    </select>
                @endif
        
                <div id="medicines-wrap"></div>
                <br>
                <p style="cursor: pointer" class="text-primary" id="add-select">+ Tambah Obat</p>
            </div>
        </div>
        <button type="submit" class="btn btn-primary w-100">Konfirmasi Pembelian</button>
    </form>
@endsection

@push('script')
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>
    let medicinesData = @json($medicines); // Pass medicines to JavaScript
    let no = {{ isset($valueBefore) ? count($valueBefore['medicines']) + 1 : 2 }}; // Starting number

    $("#add-select").on("click", function() {
        let optionsHtml = '';
        medicinesData.forEach(item => {
            optionsHtml += `<option value="${item.id}">${item.name} (${item.stock})</option>`;
        });

        let html = `<div class="d-flex align-items-center mt-2" id="medicines-${no}">
                        <select name="medicines[]" class="form-select me-2" id="medicines-${no}">
                            <option disabled selected hidden>Pesanan ${no}</option>
                            ${optionsHtml}
                        </select>
                        <div>
                            <span style="cursor: pointer" class="text-danger p-4" onclick="deleteSelect('medicines-${no}')">X</span>
                        </div>
                    </div>`;

        $("#medicines-wrap").append(html);
        no++;
    });

    function deleteSelect(id) {
        $("#" + id).remove();
    }
</script>
@endpush
