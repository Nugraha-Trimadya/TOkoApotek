@extends('layouts.layout')
@section('content')
    <div class="container">
        <div class="d-flex justify-content-between mb-3">
            <!-- Tombol Tambah Pengguna -->
            <a href="{{ route('user.tambah_pengguna') }}" class="btn btn-success">Tambah Pengguna</a>

            <!-- Form Pencarian -->
            <form class="d-flex" role="search" action="{{ route('user.login') }}" method="GET">
                <input type="text" name="search_user" class="form-control me-2" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
        </div>
        <a href="{{ route('user.admin.export') }}" class="btn btn-success mb-3">Export Excel</a>

        @if (Session::get('success'))
            <div class="alert alert-success">
                {{ Session::get('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Pengguna</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @if (count($users) < 1)
                    <tr>
                        <td colspan="5" class="text-center">Data kosong</td>
                    </tr>
                @else
                    @foreach ($users as $user => $index)
                        <!-- Looping data pengguna -->
                        <tr>
                            <td>{{ ($users->currentpage() - 1) * ($users->perPage()) + ($user + 1) }}</td>
                            <td>{{ $index->name }}</td>
                            <td>{{ $index->email }}</td>
                            <td>{{ $index->role }}</td>
                            <td>
                                <a href="{{ route('user.edit', $index->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <button type="button" class="btn btn-danger btn-sm" onclick="showModal('{{ $index->id }}', '{{ $index->name }}')">Hapus</button>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>

        <div class="d-flex justify-content-end">
            {{-- link : memunculkan button pagination --}}
            {{ $users->links() }}
        </div>
    </div>

    <!-- Modal Hapus -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="form-delete-user" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Hapus Data User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Apakah anda yakin ingin menghapus <span id="nama-user"></span>?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batalkan</button>
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('script')
    <script>
        // Function untuk menampilkan modal hapus
        function showModal(id, name) {
            let urlDelete = "{{ route('user.hapus', ':id') }}";
            urlDelete = urlDelete.replace(':id', id);
            $('#form-delete-user').attr('action', urlDelete);
            $('#nama-user').text(name);

            // Memunculkan modal
            var modal = new bootstrap.Modal(document.getElementById('exampleModal'));
            modal.show();
        }
    </script>
@endpush
