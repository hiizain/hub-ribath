@extends('../layouts/app-front')

@section('container')
<div class="container my-5 pt-5">
    <div id="carouselExampleDark" class="carousel carousel-dark slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner h-100">
            <div class="carousel-item mx-3 h-100 active" data-bs-interval="10000">
                <div class="row h-100">
                    <div class="col d-flex align-items-center justify-content-start h-100">
                        <div class="ms-4">
                            <h2>First slide label</h2>
                            <p>Some representative placeholder content for the first slide.</p>
                            <div class="col">
                                <a href="" class="btn btn-primary">Button</a>
                            </div>
                        </div>
                    </div>
                    <div class="col d-flex align-items-center justify-content-end">
                        <img src="/assets/img/logo.png" class="d-block w-100" alt="...">
                    </div>
                </div>
            </div>
            <div class="carousel-item mx-3 h-100" data-bs-interval="2000">
                <div class="row h-100">
                    <div class="col d-flex align-items-center justify-content-start h-100">
                        <div class="ms-4">
                            <h2>Second slide label</h2>
                            <p>Some representative placeholder content for the second slide.</p>
                            <div class="col">
                                <a href="" class="btn btn-primary">Button</a>
                            </div>
                        </div>
                    </div>
                    <div class="col d-flex align-items-center justify-content-end">
                        <img src="/assets/img/logo.png" class="d-block w-100" alt="...">
                    </div>
                </div>
            </div>
            <div class="carousel-item mx-3 h-100">
                <div class="row h-100">
                    <div class="col d-flex align-items-center justify-content-start h-100">
                        <div class="ms-4">
                            <h2>Third slide label</h2>
                            <p>Some representative placeholder content for the third slide.</p>
                            <div class="col">
                                <a href="" class="btn btn-primary">Button</a>
                            </div>
                        </div>
                    </div>
                    <div class="col d-flex align-items-center justify-content-end">
                        <img src="/assets/img/logo.png" class="d-block w-100" alt="...">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- <div class="col-12 jumbotron text-white d-flex align-items-center">
    <div class="container">
        <div class="row jumbotron-content m-0">
            <div class="col jumbotron-text d-flex flex-row align-items-center justify-content-start">
                <div>
                    <h1>Jumbotron Example</h1>
                    <p>Lorem ipsum...</p>
                    <div class="col">
                        <a href="" class="btn btn-primary">Go</a>
                    </div>
                </div>
            </div>
            <div class="col jumbotron-logo d-flex align-items-center justify-content-end">
                <img src="/assets/img/logo.png" alt="logoribath">
            </div>
        </div>
    </div>
</div> --}}
<section class="brand mt-5">
    <div class="container mt-5">
        <div>
            <div class="d-flex justify-content-center">
                <h2>Gabung dengan kami!</h2>
            </div>
            <div class="d-flex justify-content-center">
                <p>Dapatkan benefit tambahan ketika bergabung dengan kami</p>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col d-flex align-items-center justify-content-center">
                <img src="/assets/img/logo.png" class="d-block w-50" alt="...">
            </div>
            <div class="col d-flex align-items-center justify-content-start">
                <div class="ms-4">
                    <h2>Second slide label</h2>
                    <p>Some representative placeholder content for the second slide.</p>
                    <div class="col">
                        <a href="" class="btn btn-primary">Button</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="slice my-5 text-white">
    <div class="container d-flex align-items-center h-100">
        <div class="ms-4">
            <h2>Second slide label</h2>
            <p>Some representative placeholder content for the second slide.</p>
            <div class="col">
                <a href="" class="btn btn-primary">Button</a>
            </div>
        </div>
    </div>
</div>

<section class="testimoni mt-5 pt-5">
    <div class="container">
        <!-- Slider main container -->
        <div class="swiper">
            <!-- Additional required wrapper -->
            <div class="swiper-wrapper mx-5">
                <!-- Slides -->
                <div class="swiper-slide d-flex justify-content-center">
                    <div class="d-flex flex-row align-items-center justify-content-center me-5 pe-5">
                        <div class="col-4 mx-2">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Special title treatment</h5>
                                    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                                    <a href="#" class="btn btn-primary">Go somewhere</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-4 mx-2">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Special title treatment</h5>
                                    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                                    <a href="#" class="btn btn-primary">Go somewhere</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide d-flex justify-content-center">
                    <div class="d-flex flex-row align-items-center justify-content-center me-5 pe-5">
                        <div class="col-4 mx-2">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Special title treatment</h5>
                                    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                                    <a href="#" class="btn btn-primary">Go somewhere</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-4 mx-2">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Special title treatment</h5>
                                    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                                    <a href="#" class="btn btn-primary">Go somewhere</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide d-flex justify-content-center">
                    <div class="d-flex flex-row align-items-center justify-content-center me-5 pe-5">
                        <div class="col-4 mx-2">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Special title treatment</h5>
                                    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                                    <a href="#" class="btn btn-primary">Go somewhere</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-4 mx-2">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Special title treatment</h5>
                                    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                                    <a href="#" class="btn btn-primary">Go somewhere</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- If we need pagination -->
            {{-- <div class="swiper-pagination"></div> --}}
        
            <!-- If we need navigation buttons -->
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
        
            <!-- If we need scrollbar -->
            {{-- <div class="swiper-scrollbar"></div> --}}
        </div>
    </div>
</section>

@endsection    
