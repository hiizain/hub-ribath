<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <!-- Bootstrap CSS -->
    <link href="/libs/bootstrap5/css/bootstrap.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="/libs/fontawesome/css/all.min.css" rel="stylesheet">

    <!-- Font Poppins -->
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>

    <!-- Datatable -->
    <link href="/libs/datatables/datatables-bs4/css/dataTables.bootstrap4.css" rel="stylesheet">

    <!-- Swiper -->
    <link href="/libs/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- DatePicker -->
    <link rel="stylesheet" href="/libs/daterangepicker/daterangepicker.css">

    <!-- Sweet Alert -->
    <link rel="stylesheet" href="/libs/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">

    <!-- Timeline -->
    <link rel="stylesheet" href="/libs/timeline-squarechip/css/timeline.min.css">

    <!-- Main CSS -->
    <link href="/assets/css/main.css" rel="stylesheet">

    <!-- Jquery -->
    <script src="/libs/jquery/jquery-3.3.1.min.js"></script>

    <!-- General JS Scripts -->
    <script src="/libs/daterangepicker/moment.min.js"></script>
    <script src="/libs/daterangepicker/daterangepicker.js"></script>
</head>

<body>
    <nav class="navbar fixed-top navbar-expand-lg">
        <div class="container">
            <div class="d-flex flex-left">
                <a class="navbar-brand" href="#">Ribath.Hub</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
            <div class="d-flex flex-right">
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link active" href="#">Home</a>
                        </li>
                        {{-- <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Program
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <li><a class="dropdown-item" href="#">Program Dibuka</a></li>
                                <li><a class="dropdown-item" href="{{ route('program.index') }}">Semua Program</a></li>
                                <li><a class="dropdown-item" href="#">Program Diikuti</a></li>
                            </ul>
                        </li> --}}
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('program.index') }}">Program</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink"
                                role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Layanan
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <li><a class="dropdown-item" href="{{ route('layanan.sewa') }}">Sewa Alat Media</a></li>
                                <li><a class="dropdown-item" href="{{ route('layanan.safari') }}">Booking Safari
                                        Maulid</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Hubungi Kami</a>
                        </li>
                        @if (Auth::check())
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink"
                                    role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Nama
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    <li><a class="dropdown-item" href="{{ route('user.dashboard') }}">Dashboard</a></li>
                                    <li><a class="dropdown-item" href="{{ route('program.index') }}">Profil</a></li>
                                    <li><a class="dropdown-item" href="{{ route('logout') }}">Logout</a></li>
                                    {{-- <li><a class="dropdown-item" href="#">TPA</a></li> --}}
                                </ul>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">Login</a>
                            </li>
                        @endif
                        {{-- <li class="nav-item">
                            <a class="nav-link" href="#">Pricing</a>
                        </li> --}}

                        {{-- <li class="nav-item">
                            <button type="button" class="btn btn-login" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                Login
                            </button>
                        </li> --}}
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    {{-- <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-center">
                    <div class="col-12 d-flex flex-row">
                        <div class="col-6 d-flex justify-content-center">
                            <a href="">Login</a>
                        </div>
                        <div class="col-6 d-flex justify-content-center">
                            <a href="">Register</a>
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <form action="">
                        <div class="mb-3">
                            <label for="email" class="col-form-label">Email:</label>
                            <input type="email" name="email" class="form-control" id="email">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="col-form-label">Password:</label>
                            <input type="password" name="password" class="form-control" id="password">
                        </div>
                        <button class="mt-4 btn btn-primary form-control" type="submit">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div> --}}

    <div class="bg-light">
        @yield('container')
    </div>



    <!-- Main JS -->
    {{-- <script src="/assets/js/main.js"></script> --}}

    <!-- Swiper JS -->
    <script src="/libs/swiper/swiper-bundle.min.js"></script>

    <!-- Timeline -->
    <script src="/libs/timeline-squarechip/js/timeline.min.js"></script>

    <!-- Sweet Alert -->
    <script src="/libs/sweetalert2/sweetalert2.min.js"></script>

    <!-- Bootstrap Bundle with Popper -->
    <script src="/libs/bootstrap5/js/bootstrap.bundle.js"></script>

    <!-- Datatable -->
    <script src="/libs/datatables/datatables.min.js"></script>
    <script src="/libs/datatables/datatables-bs4/js/dataTables.bootstrap4.js"></script>

    <script>
        const swiper = new Swiper('.swiper', {
            // Optional parameters
            direction: 'horizontal',
            loop: true,

            // If we need pagination
            // pagination: {
            //     el: '.swiper-pagination',
            // },

            // Navigation arrows
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },

            // And if we need scrollbar
            // scrollbar: {
            //     el: '.swiper-scrollbar',
            // },
        });
    </script>
</body>

</html>
