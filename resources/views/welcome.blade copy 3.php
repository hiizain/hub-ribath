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

    <!-- Datatable -->
	<link href="/libs/datatables/datatables-bs4/css/dataTables.bootstrap4.css" rel="stylesheet">

    <!-- Main CSS -->
    <link href="/assets/css/main.css" rel="stylesheet">

    <!-- Jquery -->
    <script src="/libs/jquery/jquery-3.3.1.min.js"></script>
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
                    <a class="d-flex align-items-center toggled-brand">
                        <i class="fa-solid fa-gears"></i>
                        <p class="ms-2 my-0 p-0">Dashboard</p>
                    </a>
                </li>
                <li class="sidebar-brand">
                    <a class="d-flex align-items-center collapsed toggled-brand" data-bs-toggle="collapse" data-bs-target="#home-collapse" aria-expanded="false">
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
            </ul>
        </div>

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="row m-3">
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
                </div>
                {{-- <div class="row">
                    <div class="col-12">
                        <div class="row">
                            <h4 class="p-0 m-0">
                                Data Table
                            </h4>
                        </div>
                        <div class="row">
                            <table class="table table-sm">
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
                    </div>
                </div> --}}
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
</body>
</html>