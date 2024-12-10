@extends('layouts.layout')

@section('content')
    <div class="container">
        <h1 class="text-center">Edit Data Pengguna</h1>
        <div class="card p-5">
            <form action="{{ route('user.edit_formulir', $users->id ) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="mb-3 row">
                    <label for="name" class="col-sm-2 col-form-label">Name:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="name" name="name" value="{{ $users->name }}" required>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="email" class="col-sm-2 col-form-label">Email:</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control" id="email" name="email" value="{{ $users->email}}" required>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="password" class="col-sm-2 col-form-label">Password :</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="role" class="col-sm-2 col-form-label">Role:</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="role" name="role" required>
                            <option value="admin" {{ $users->role == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="kasir" {{ $users->role == 'kasir' ? 'selected' : '' }}>Kasir</option>
                            <option value="kasir" {{ $users->role == 'user' ? 'selected' : '' }}>user</option>
                        </select>
                    </div>
                </div>

                <button type="submit" class="btn btn-outline-primary btn-custom w-100">Edit Data</button>
            </form>
        </div>
    </div>
@endsection
