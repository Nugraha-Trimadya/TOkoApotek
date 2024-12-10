@extends('layouts.layout')

@section('content')
    <div class="container mt-4">
        <!-- Success message display -->
        @if (Session::get('success'))
            <div class="alert alert-success text-center mb-4">
                {{ Session::get('success') }}
            </div>
        @endif

        <!-- Add New Order button and Search Form -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <form method="GET" action="" class="d-flex align-items-center">
                <input type="date" name="search_day" id="search_day" class="form-control me-2" value="{{ request('search_day') }}">
                <button type="submit" class="btn btn-primary">Cari</button>
                <a href="{{ route('pembelian.admin') }}" class="btn btn-secondary ms-2">Clear</a>
            </form>
            <a href="{{ route('pembelian.admin.export') }}" class="btn btn-success">Export Excel</a>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Pembeli</th>
                        <th class="text-center">Obat</th>
                        <th class="text-center">Total Bayar</th>
                        <th class="text-center">Tanggal Pembelian</th>
                        <th class="text-center">Nama Kasir</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp
                    @foreach($orders as $item)
                        <tr>
                            <td class="text-center">{{ $no++ }}</td>
                            <td class="text-center">{{ $item->name_costumer }}</td>
                            <td>
                                <ul class="list-unstyled mb-0">
                                    @foreach($item['medicines'] as $medicine)
                                        <li class="mb-1">
                                            {{ $medicine['name_medicine'] }}
                                            (Rp. {{ number_format($medicine['price'], 0, ',', '.') }}) :
                                            Rp. {{ number_format($medicine['total_price'], 0, ',', '.') }}
                                            <small>qty {{ $medicine['qty'] }}</small>
                                        </li>
                                    @endforeach
                                </ul>
                            </td>
                            <td class="text-center">Rp. {{ number_format($item['total_price'], 0, ',', '.') }}</td>
                            <td class="text-center">{{ \Carbon\Carbon::parse($item['created_at'])->locale('id')->isoFormat('dddd, DD MMMM YYYY HH:mm:ss') }}</td>
                            <td class="text-center">{{ $item->user->name }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination links -->
        <div class="d-flex justify-content-end mt-3">
            @if ($orders->count() > 0)
                {{ $orders->links() }}
            @endif
        </div>
    </div>
@endsection
