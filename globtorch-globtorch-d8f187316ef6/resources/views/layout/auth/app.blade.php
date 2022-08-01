<!DOCTYPE html>
<html lang="en">
<head>
	<title>Globtorch</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/jpg" href="{{asset('images/logos.jpg')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('fonts/font-awesome-4.7.0/css/font-awesome.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendor/select2/select2.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/util.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/main.css')}}">
     <link href="{{asset('css/lib/bootstrap/bootstrap.min.css')}}" rel="stylesheet">

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-HGJ5R515CY"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-HGJ5R515CY');
    </script>

    @yield('head_styles')
    @yield('head_scripts')
</head>
<body >
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
                @yield('content')
            </div>
		</div>
    </div>
    @yield('body_styles')
    @yield('body_scripts')
</body>
</html>