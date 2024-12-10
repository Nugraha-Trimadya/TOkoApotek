<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Apoteker App</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="">
    @stack('style')
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container">
            <a class="navbar-brand" href="#">Apotek App</a>
            @if (Auth::check())
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link active {{ Route::is('home') ? 'active' : '' }}" aria-current="page"
                                href="{{ route('landing_page') }}">Dashboard</a>
                        </li>
                        @if (Auth::user()->role == 'admin')
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle {{ Route::is('obat.tambah_obat') ? 'active' : '' }}"
                                    href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Obat
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item {{ Route::is('obat.data') ? 'active' : '' }}"
                                            href="{{ route('obat.data') }}">Data Obat</a></li>
                                    <li><a class="dropdown-item {{ Route::is('obat.tambah_obat') ? 'active' : '' }}"
                                            href="{{ route('obat.tambah_obat') }}">Tambah</a></li>
                                </ul>
                            </li>
                            {{-- <li class="nav-item">
                                <a class="nav-link active {{ Route::is('landing_page') ? 'active' : '' }}"
                                    aria-current="page" href="{{ route('pembelian.formulir') }}">Pembelian</a>
                            </li> --}}
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="{{ route('user.login') }}">Kelola
                                    Akun</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="{{ route('pembelian.admin') }}">Data Pembelian</a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link active {{ Route::is('landing_page') ? 'active' : '' }}"
                                    aria-current="page" href="{{ route('pembelian.order') }}">Pembelian</a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <a class="nav-link active {{ Route::is('logout.auth') ? 'active' : '' }}"
                                aria-current="page" href="{{ route('logout.auth') }}">logout</a>
                        </li>
                    </ul>
                </div>
                <form class="d-flex me-2" role="Search" action="{{ route('obat.data') }}" method="GET">
                    <input type="text" name="search_obat" class="form-control me-2" placeholder="Search"
                        aria-label="Search">
                    <button class="btn btn-outline-success me-2" type="submit">Search</button>
                </form>
            @endif
        </div>
    </nav>

    <div class="container mt-5">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
    </script>

    @stack('script')
</body>

</html>
