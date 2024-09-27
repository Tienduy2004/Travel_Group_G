<div class="container-fluid bg-light pt-3 d-none d-lg-block">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 text-center text-lg-left mb-2 mb-lg-0">
                <div class="d-inline-flex align-items-center">
                    <p><i class="fa fa-envelope mr-2"></i>info@example.com</p>
                    <p class="text-body px-3">|</p>
                    <p><i class="fa fa-phone-alt mr-2"></i>+012 345 6789</p>
                </div>
            </div>
            <div class="col-lg-6 text-center text-lg-right">
                <div class="d-inline-flex align-items-center">
                    <a class="text-primary px-3" href="">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a class="text-primary px-3" href="">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a class="text-primary px-3" href="">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    <a class="text-primary px-3" href="">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a class="text-primary pl-3" href="">
                        <i class="fab fa-youtube"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Topbar End -->


    <!-- Navbar Start -->
    <div class="container-fluid position-relative nav-bar p-0">
        <div class="container-lg position-relative p-0 px-lg-3" style="z-index: 9;">
            <nav class="navbar navbar-expand-lg bg-light navbar-light shadow-lg py-3 py-lg-0 pl-3 pl-lg-5">
                <a href="" class="navbar-brand">
                    <h1 class="m-0 text-primary"><span class="text-dark">TRAVEL</span>ER</h1>
                </a>
                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-between px-3" id="navbarCollapse">
                    <div class="navbar-nav ml-auto py-0">
                        <a href="{{route('home')}}" class="nav-item nav-link {{ Request::is('/') ? 'active' : '' }}">Home</a>
                        <a href="{{route('about')}}" class="nav-item nav-link {{ Request::is('about') ? 'active' : '' }}">About</a>
                        <a href="{{route('service')}}" class="nav-item nav-link {{ Request::is('service') ? 'active' : '' }}">Services</a>
                        <a href="{{route('tour')}}" class="nav-item nav-link {{ Request::is('tour') ? 'active' : '' }}">Tour Packages</a>
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle {{ Request::is('blog', 'single', 'destination', 'guide', 'testimonial') ? 'active' : '' }}" data-toggle="dropdown">Pages</a>
                            <div class="dropdown-menu border-0 rounded-0 m-0">
                                <a href="{{ route('blog') }}" class="dropdown-item {{ Request::is('blog') ? 'active' : '' }}">Blog Grid</a>
                                <a href="{{ route('single') }}" class="dropdown-item {{ Request::is('single') ? 'active' : '' }}">Blog Detail</a>
                                <a href="{{ route('destination') }}" class="dropdown-item {{ Request::is('destination') ? 'active' : '' }}">Destination</a>
                                <a href="{{ route('guide') }}" class="dropdown-item {{ Request::is('guide') ? 'active' : '' }}">Travel Guides</a>
                                <a href="{{ route('testimonial') }}" class="dropdown-item {{ Request::is('testimonial') ? 'active' : '' }}">Testimonial</a>
                            </div>
                        </div>
                        <a href="{{route('contact')}}" class="nav-item nav-link {{ Request::is('contact') ? 'active' : '' }}">Contact</a>
                    </div>
                </div>
            </nav>
        </div>
    </div>
    <!-- Navbar End -->