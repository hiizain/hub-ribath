@extends('../layouts/app-front')

@section('container')
<section class="vh-100 container mt-4 d-flex align-items-center justify-content-lg-center">
    <div class="shadow rounded-5 p-4 bg-white">
        <div class="container-fluid h-custom">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-md-9 col-lg-6 col-xl-5">
                    <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.webp"
                    class="img-fluid" alt="Sample image">
                </div>
                <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1 py-5">
                    <form action="{{ route('register') }}" method="post">
                        @csrf
                        <div class="d-flex flex-row align-items-center justify-content-center justify-content-lg-center mb-4">
                            <h1 class="mb-0 me-3">Register</h1>
                        </div>
                        <div class="row mb-3">
                            <div class="form-group">
                                <h5 class="fw-normal">Email</h5>
                                <input class="form-control" type="email" name="email" placeholder="Email">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="form-group">
                                <h5 class="fw-normal">Password</h5>
                                <input class="form-control" type="password" name="password" placeholder="Password">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="form-group">
                                <h5 class="fw-normal">Konfirmasi Password</h5>
                                <input class="form-control" type="password" name="password_confirm" placeholder="Masukkan Ulang Password">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                <button class="col-12 btn btn-primary">Register</button>
                                <div class="row">
                                    <a href="{{ route('login') }}" class="mt-2 pt-1 mb-0">Have an account? Login now</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection    
