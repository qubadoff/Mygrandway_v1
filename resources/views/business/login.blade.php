<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>
        Mygrandway Business
    </title>
    <!-- CSS files -->
    <link href="{{ url('/') }}/business/dist/css/tabler.min.css?1684106062" rel="stylesheet"/>
    <link href="{{ url('/') }}/business/dist/css/tabler-flags.min.css?1684106062" rel="stylesheet"/>
    <link href="{{ url('/') }}/business/dist/css/tabler-payments.min.css?1684106062" rel="stylesheet"/>
    <link href="{{ url('/') }}/business/dist/css/tabler-vendors.min.css?1684106062" rel="stylesheet"/>
    <link href="{{ url('/') }}/business/dist/css/demo.min.css?1684106062" rel="stylesheet"/>
    <style>
        @import url('https://rsms.me/inter/inter.css');
        :root {
            --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
        }
        body {
            font-feature-settings: "cv03", "cv04", "cv11";
        }
    </style>
</head>
<body  class=" d-flex flex-column">
<script src="{{ url('/') }}/business/dist/js/demo-theme.min.js?1684106062"></script>
<div class="page page-center">
    <div class="container container-tight py-4">
        <div class="text-center mb-4">
            <a href="{{ route('business.dashboard') }}" class="navbar-brand navbar-brand-autodark"><img src="/logo.svg" height="36" alt=""></a>
        </div>
        @if(Session::has('error'))
            <div class="alert alert-danger">
                {{ Session::get('error') }}
                @php
                    Session::forget('error');
                @endphp
            </div>
        @endif
        <div class="card card-md">
            <div class="card-body">
                <h2 class="h2 text-center mb-4">
                    Sign in your Business Panel
                </h2>
                <form action="{{ route('business.loginPost') }}" method="POST" autocomplete="off" novalidate>
                    @csrf
                    @method('POST')
                    <div class="mb-3">
                        <label class="form-label">Email address</label>
                        <input type="email" name="email" class="form-control" placeholder="your@email.com" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">
                            Password
{{--                            <span class="form-label-description">--}}
{{--                                <a href="#">I forgot password</a>--}}
{{--                            </span>--}}
                        </label>
                        <div class="input-group input-group-flat">
                            <input type="password" name="password" class="form-control"  placeholder="Your password" required>
                            <span class="input-group-text">
                            </span>
                        </div>
                    </div>

                    <div class="form-footer">
                        <button type="submit" name="submit" class="btn btn-primary w-100">Sign in</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="text-center text-muted mt-3">
            Developed by <a href="https://burncode.org" target="_blank" tabindex="-1">
                Burncode Systems
            </a>
        </div>
    </div>
</div>
<!-- Libs JS -->
<!-- Tabler Core -->
<script src="{{ url('/') }}/business/dist/js/tabler.min.js?1684106062" defer></script>
<script src="{{ url('/') }}/business/dist/js/demo.min.js?1684106062" defer></script>
</body>
</html>
