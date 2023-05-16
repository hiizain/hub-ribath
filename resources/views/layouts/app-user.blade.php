<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Document</title>

    <!-- Bootstrap CSS -->
    <link href="/libs/bootstrap5/css/bootstrap.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="/libs/fontawesome/css/all.min.css" rel="stylesheet">

    <!-- Datatable -->
	<link href="/libs/datatables/datatables-bs4/css/dataTables.bootstrap4.css" rel="stylesheet">

    <!-- Select2 -->
	<link rel="stylesheet" href="/libs/select2/select2.min.css">
	<link rel="stylesheet" href="/libs/select2-bootstrap4-theme/select2-bootstrap4.min.css">

    <!-- Sweet Alert -->
	<link rel="stylesheet" href="/libs/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">

    <!-- DatePicker -->
    <link rel="stylesheet" href="/libs/daterangepicker/daterangepicker.css">

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
    <div class="wrapper toggled" id="wrapper">
        <div class="sidebar-wrapper" id="sidebar-wrapper">
            <div class="head-sidebar d-flex flex-row p-3 mt-3">
                <div class="sidebar-logo col-10">
                    <a href="#" class="d-flex align-items-center logo">
                        <img src="" alt="">
                        <span class="fs-5 fw-semibold">Apps</span>
                    </a>
                </div>
                <div class="sidebar-icon col-2">
                    <a class="sidebar-icon-link" id="menu-toggle" href=""><i class="fa-solid fa-bars"></i></a>
                </div>
            </div>
            <div class="m-2">
                <hr class="text-white">
            </div>
            <ul class="sidebar-nav ps-0 my-2">
                <li class="sidebar-brand active">
                    <a class="d-flex align-items-center">
                        <i class="fa-solid fa-gears"></i>
                        <p class="ms-2 my-0 p-0">Dashboard</p>
                    </a>
                </li>
                {{-- <li class="sidebar-brand">
                    <a href="{{ route('user.program.index') }}" class="d-flex align-items-center">
                        <i class="fa-solid fa-gears"></i>
                        <p class="ms-2 my-0 p-0">Program</p>
                    </a>
                </li> --}}
                <li class="sidebar-brand">
                    <a class="d-flex align-items-center collapsed" id="dropdown-menu" data-bs-toggle="collapse" data-bs-target="#program-collapse" aria-expanded="false">
                        <i class="fa-solid fa-house"></i>
                        <p class="ms-2 my-0 p-0">Program</p>
                    </a>
                    <div class="collapse p-0" id="program-collapse" style="">
                        <ul class="sidebar-nav-dropdown fw-normal small">
                            <li><a href="{{ route('back.program.index') }}" class="d-flex nav-link">Program</a></li>
                            <li><a href="{{ route('back.program.seleksi') }}" class="d-flex nav-link">Seleksi Program</a></li>
                        </ul>
                    </div>
                </li>
                <li class="sidebar-brand">
                    <a class="d-flex align-items-center collapsed" data-bs-toggle="collapse" data-bs-target="#home-collapse" aria-expanded="false">
                        <i class="fa-solid fa-house"></i>
                        <p class="ms-2 my-0 p-0">Home</p>
                    </a>
                    <div class="collapse p-0" id="home-collapse" style="">
                        <ul class="sidebar-nav-dropdown fw-normal small">
                            <li><a href="#" class="d-flex nav-link">Overview</a></li>
                            <li><a href="#" class="d-flex nav-link">Updates</a></li>
                            <li><a href="#" class="d-flex nav-link">Reports</a></li>
                        </ul>
                    </div>
                </li>
                <hr>
                <li class="sidebar-brand">
                    <a href="{{ route('logout') }}" class="d-flex align-items-center">
                        <i class="fa-solid fa-gears"></i>
                        <p class="ms-2 my-0 p-0">Logout</p>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="container-fluid">

                <div>
                    <div class="container">
                        @yield('container')
                        {{-- <div class="row m-3">
                            <div class="col-12 p-0">
                                <h4 class="p-0 m-0">
                                    Data Table
                                </h4>
                            </div>
                            <div class="col-12 p-0">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">First</th>
                                            <th scope="col">Last</th>
                                            <th scope="col">Handle</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th scope="row">1</th>
                                            <td>Mark</td>
                                            <td>Otto</td>
                                            <td>@mdo</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">2</th>
                                            <td>Jacob</td>
                                            <td>Thornton</td>
                                            <td>@fat</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">3</th>
                                            <td colspan="2">Larry the Bird</td>
                                            <td>@twitter</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div> --}}
                    </div>
                </div>
                <!-- Footer -->
                <footer class="sticky-footer">
                    <div class="container my-auto">
                        <div class="copyright text-center my-auto">
                            <span>Copyright &copy; Ribath-HUB 2023</span>
                        </div>
                    </div>
                </footer>
                <!-- End of Footer -->
            </div>
        </div>
        <!-- /#page-content-wrapper -->
    </div>
    
    <!-- Main JS -->
    <script src="/assets/js/main.js"></script>

    <!-- Bootstrap Bundle with Popper -->
    <script src="/libs/bootstrap5/js/bootstrap.bundle.js"></script>

    <!-- Datatable -->
    <script src="/libs/datatables/datatables.min.js"></script>
    <script src="/libs/datatables/datatables-bs4/js/dataTables.bootstrap4.js"></script>

    <!-- Select2 -->
    <script src="/libs/select2/select2.min.js"></script>

    <!-- Timeline -->
    <script src="/libs/timeline-squarechip/js/timeline.min.js"></script>

    <!-- Sweet Alert -->
    <script src="/libs/sweetalert2/sweetalert2.min.js"></script>
</body>
</html>