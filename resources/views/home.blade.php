@extends('layouts.layout')

@section('content')
    @if (Session::get('failed'))
        <div class="alert alert-danger text-center">
            {{ Session::get('failed') }}
        </div>
    @endif
    <div class="jumbotron py-4 px-5 text-center">
        <h1 class="display-4 font-weight-bold">Selamat Datang {{ Auth::user()->name }} di Aplikasi Apotek!</h1>
        <img src="path/ke/gambar.jpg" alt="Gambar Apotek" class="img-fluid my-4 rounded" style="max-width: 70%; height: auto;">
        <hr class="my-4 bg-light" style="height: 2px;">
        <p class="lead">Aplikasi ini digunakan untuk mengelola data obat, penyetokan, juga pembelian (kasir).</p>
    </div>

    <style>
        body {
            background: linear-gradient(to right, #4A90E2, #9013FE);
            color: white;
            ;
            /* Light background for contrast */
        }


        .display-4 {
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
            /* Text shadow for readability */
        }

        .lead {
            font-size: 1.25rem;
            /* Larger font for the lead paragraph */
            margin-bottom: 2rem;
            /* Bottom margin for spacing */
        }

        .btn {
            margin: 0 10px;
            /* Spacing between buttons */
        }
    </style>
@endsection
