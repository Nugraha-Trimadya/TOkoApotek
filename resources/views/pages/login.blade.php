@extends('layouts.layout')

@section('content')
    <div class="container d-flex justify-content-center align-items-center ">
        <form action="{{ route('login.proses') }}" class="card p-5 shadow-lg" method="POST"
            style="width: 400px; border-radius: 15px;">
            @csrf
            <h1 class="text-center mb-4">Login</h1>
            @if (Session::get('success'))
                <div class="alert alert-success text-center">
                    {{ Session::get('success') }}
                </div>
            @endif
            @if (Session::get('failed'))
                <div class="alert alert-danger text-center">
                    {{ Session::get('failed') }}
                </div>
            @endif

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>

            <div class="d-flex justify-content-between mb-3">
                <div>
                    <a href="#" class="text-primary">Forgot Password?</a>
                </div>
                <div>
                    <a href="#" class="text-primary">Create Account</a>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100">Masuk</button>
        </form>
    </div>

    <style>
        body {
            background: linear-gradient(to right, #4A90E2, #9013FE);
            color: white;
        }

        .card {
            background: rgba(255, 255, 255, 0.9);
            border: none;
        }

        .form-control {
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        .form-control:focus {
            border-color: #4A90E2;
            box-shadow: 0 0 5px rgba(74, 144, 226, 0.5);
        }

        .btn-primary {
            background-color: #4A90E2;
            border: none;
            transition: background-color 0.3s, transform 0.2s;
        }

        .btn-primary:hover {
            background-color: #357ABD;
            transform: scale(1.05);
        }

        a {
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
@endsection
