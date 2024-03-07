<!-- Navbar -->
<div class="sticky-top">
    <header class="navbar navbar-expand-md sticky-top d-print-none" >
        <div class="container-xl">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu" aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
                <a href="{{ route('business.dashboard') }}">
                    <img src="{{ url('/') }}/logo.svg" width="110" height="32" alt="Tabler" class="navbar-brand-image">
                </a>
            </h1>
            <div class="navbar-nav flex-row order-md-last">
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
                        <span class="avatar avatar-sm" style="background-image: url(/business/static/brands/android.svg)"></span>
                        <div class="d-none d-xl-block ps-2">
                            <div>
                                {{ \Illuminate\Support\Facades\Auth::guard('business')->user()->name }}
                            </div>
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                        <a href="{{ route('business.settings') }}" class="dropdown-item">Settings</a>
                        <div class="dropdown-divider"></div>
                        <a href="{{ route('business.logout') }}" class="dropdown-item">Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <header class="navbar-expand-md">
        <div class="collapse navbar-collapse" id="navbar-menu">
            <div class="navbar">
                <div class="container-xl">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('business.dashboard') }}" >
                    <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/home -->
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l-2 0l9 -9l9 9l-2 0" /><path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" /><path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" /></svg>
                    </span><span class="nav-link-title">Home</span>
                            </a>
                        </li>

{{--                        <li class="nav-item dropdown">--}}
{{--                            <a class="nav-link dropdown-toggle" href="#navbar-help" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false" >--}}
{{--                                <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/lifebuoy -->--}}
{{--                                  <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" /><path d="M15 15l3.35 3.35" /><path d="M9 15l-3.35 3.35" /><path d="M5.65 5.65l3.35 3.35" /><path d="M18.35 5.65l-3.35 3.35" /></svg>--}}
{{--                                </span>--}}
{{--                                <span class="nav-link-title">--}}
{{--                                    Pages--}}
{{--                                </span>--}}
{{--                            </a>--}}
{{--                            <div class="dropdown-menu">--}}
{{--                                <a class="dropdown-item" href="#" target="_blank" rel="noopener">--}}
{{--                                    Page 1--}}
{{--                                </a>--}}
{{--                                <a class="dropdown-item" href="#">--}}
{{--                                    Page 2--}}
{{--                                </a>--}}
{{--                                <a class="dropdown-item" href="#" target="_blank" rel="noopener">--}}
{{--                                    Page 3--}}
{{--                                </a>--}}
{{--                            </div>--}}
{{--                        </li>--}}
                    </ul>
                </div>
            </div>
        </div>
    </header>
</div>
