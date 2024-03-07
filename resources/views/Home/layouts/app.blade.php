<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="author" content="DSAThemes"/>
    <meta name="description" content="Novaro - App Landing Page Template"/>
    <meta name="keywords" content="Responsive, HTML5 template, DSAThemes, Mobile, Application, One Page, Landing, Mobile App">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <!-- SITE TITLE -->
    <title>
        @yield('pageTitle')
    </title>

    <!-- FAVICON AND TOUCH ICONS  -->
    <link rel="shortcut icon" href="{{ url('/') }}/assets/images/icons/favicon.ico" type="image/x-icon">
    <link rel="icon" href="{{ url('/') }}/assets/images/icons/favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ url('/') }}/assets/images/icons/apple-touch-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ url('/') }}/assets/images/icons/apple-touch-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ url('/') }}/assets/images/icons/apple-touch-icon-76x76.png">
    <link rel="apple-touch-icon" href="{{ url('/') }}/assets/images/icons/apple-touch-icon.png">
    <link rel="icon" href="{{ url('/') }}/assets/images/icons/apple-touch-icon.png" type="image/x-icon">

    <!-- GOOGLE FONTS -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@400;500;600;700;800&amp;display=swap" rel="stylesheet">

    <!-- BOOTSTRAP CSS -->
    <link href="{{ url('/') }}/assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- FONT ICONS -->
    <link href="https://use.fontawesome.com/releases/v5.11.0/css/all.css" rel="stylesheet" crossorigin="anonymous">
    <link href="{{ url('/') }}/assets/css/flaticon.css" rel="stylesheet">

    <!-- PLUGINS STYLESHEET -->
    <link href="{{ url('/') }}/assets/css/magnific-popup.css" rel="stylesheet">
    <link href="{{ url('/') }}/assets/css/owl.carousel.min.css" rel="stylesheet">
    <link href="{{ url('/') }}/assets/css/owl.theme.default.min.css" rel="stylesheet">
    <link href="{{ url('/') }}/assets/css/slick.css" rel="stylesheet">
    <link href="{{ url('/') }}/assets/css/slick-theme.css" rel="stylesheet">

    <!-- ON SCROLL ANIMATION -->
    <link href="{{ url('/') }}/assets/css/animate.css" rel="stylesheet">

    <!-- TEMPLATE CSS -->
    <link href="{{ url('/') }}/assets/css/style.css" rel="stylesheet">

    <!-- RESPONSIVE CSS -->
    <link href="{{ url('/') }}/assets/css/responsive.css" rel="stylesheet">

</head>
<body>

<!-- PRELOADER SPINNER
============================================= -->
<div id="loader-wrapper">
    <div id="loading">
				<span class="cssload-loader">
					<span class="cssload-loader-inner"></span>
				</span>
    </div>
</div>

<!-- PAGE CONTENT
============================================= -->
<div id="page" class="page">

    @include('Home.layouts.includes.header')
    @yield('content')
    @include('Home.layouts.includes.footer')

</div>	<!-- END PAGE CONTENT -->

<!-- EXTERNAL SCRIPTS
============================================= -->
<script src="{{ url('/') }}/assets/js/jquery-3.4.1.min.js"></script>
<script src="{{ url('/') }}/assets/js/bootstrap.min.js"></script>
<script src="{{ url('/') }}/assets/js/modernizr.custom.js"></script>
<script src="{{ url('/') }}/assets/js/jquery.easing.js"></script>
<script src="{{ url('/') }}/assets/js/jquery.appear.js"></script>
<script src="{{ url('/') }}/assets/js/jquery.scrollto.js"></script>
<script src="{{ url('/') }}/assets/js/imagesloaded.pkgd.min.js"></script>
<script src="{{ url('/') }}/assets/js/isotope.pkgd.min.js"></script>
<script src="{{ url('/') }}/assets/js/jquery.flexslider.js"></script>
<script src="{{ url('/') }}/assets/js/owl.carousel.min.js"></script>
<script src="{{ url('/') }}/assets/js/slick.min.js"></script>
<script src="{{ url('/') }}/assets/js/jquery.magnific-popup.min.js"></script>
<script src="{{ url('/') }}/assets/js/hero-form.js"></script>
<script src="{{ url('/') }}/assets/js/contact-form.js"></script>
<script src="{{ url('/') }}/assets/js/comment-form.js"></script>
<script src="{{ url('/') }}/assets/js/jquery.validate.min.js"></script>
<script src="{{ url('/') }}/assets/js/jquery.ajaxchimp.min.js"></script>
<script src="{{ url('/') }}/assets/js/wow.js"></script>

<!-- Custom Script -->
<script src="{{ url('/') }}/assets/js/custom.js"></script>

<script>
    new WOW().init();
</script>

<!-- [if lt IE 9]>
<script src="{{ url('/') }}/assets/js/html5shiv.js" type="text/javascript"></script>
<script src="{{ url('/') }}/assets/js/respond.min.js" type="text/javascript"></script>
<![endif] -->

</body>
</html>
