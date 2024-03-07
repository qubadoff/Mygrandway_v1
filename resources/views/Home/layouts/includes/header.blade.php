<!-- HEADER ============================================= -->
<header id="header" class="header">
    <nav class="navbar fixed-top navbar-expand-lg tra-menu navbar-light hover-menu">
        <div class="container">
            <!-- LOGO IMAGE -->
            <a href="{{ route('home.index') }}" class="navbar-brand logo-black">
                <img src="{{ url('/') }}/assets/images/logo/logo.png" width="150" height="50" alt="header-logo">
            </a>
            <a href="{{ route('home.index') }}" class="navbar-brand logo-white">
                <img src="{{ url('/') }}/assets/images/logo/logo.png" width="150" height="50" alt="header-logo">
            </a>
            <!-- Responsive Menu Button -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-bar-icon"><i class="fas fa-bars"></i></span>
            </button>
            <!-- Navigation Menu -->
            <div id="navbarSupportedContent" class="collapse navbar-collapse">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item nl-simple"><a href="{{ route('home.index') }}" class="nav-link">{{__("Home")}}</a></li>
                    <li class="nav-item nl-simple"><a href="{{ route('home.contact') }}" class="nav-link">{{__("Contact us")}}</a></li>
                </ul>
                <!-- Header Button -->
                <span class="navbar-text">
                    <a href="{{ route('home.index') }}" class="btn btn-blue tra-black-hover">{{__("Dashboard")}}</a>
                </span>
            </div>	<!-- End Navigation Menu -->
        </div>	  <!-- End container -->
    </nav>	   <!-- End navbar -->
</header>	<!-- END HEADER -->
