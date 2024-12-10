@extends('layouts.layout')
@section('content')


    <div class="container">
        <h1>Halaman Tambah Obat</h1>
        <div class="card p-5">
            <form action="{{ route('obat.tambah_obat.formulir') }}" method="POST">
                {{--
                1.tag </form> attr action & method
                method :
                POST-> form tujuan menambahkan/menghapus/mengubah
                GET-> form tujuan mencari data (search)
                action-> route untuk memproses data
                -arahkan route yg akan menangani proses data ke db nya
                -jika GET : arahkan ke route yg sama dengan route yang menampilkan blade ini
                -jika POST : arahkan ke route baru dengan http method sesuai tujuan POST (tambah), PACTH (ubah), DELETE(hapus)
                2. jika form method POST : @csrf
                3. input attr name (isi disamakn dengan column di migration)
                4. button/input type submit

                --}}
                @csrf
                @if(Session::get('success'))
                    <div class="alert alert-success">
                        {{ Session::get('success') }}
                    </div>
                @endif
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="mb-3 row">
                    <label for="name" class="col-sm-2 col-form-label">Nama Obat:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="type" class="col-sm-2 col-form-label">Jenis Obat:</label>
                    <div class="col-sm-10">
                        <select class="form-select" id="type" name="type">
                            <option selected disabled hidden>Pilih</option>
                            <option value="tablet"{{ old('type') == 'tablet' ? 'selected' : '' }}>Tablet</option>
                            <option value="sirup" {{ old('type') == 'kapsul' ? 'selected' : '' }}>Sirup</option>
                            <option value="kapsul"  {{ old('type') == 'sirup' ? 'selected' : '' }}>Kapsul</option>
                        </select>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="price" class="col-sm-2 col-form-label">Harga Obat:</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="price" name="price" value="{{ old('price') }}">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="stock" class="col-sm-2 col-form-label">Stock Tersedia:</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="stock" name="stock" value="{{ old('stock') }}">
                    </div>
                </div>
                <button type="submit" class="btn btn-outline-primary btn-custom w-100" >Tambah Data</button>
            </form>
        </div>
    </div>
    @endsection
