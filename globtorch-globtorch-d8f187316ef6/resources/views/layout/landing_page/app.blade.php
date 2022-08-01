<!DOCTYPE html>
<!--[if lt IE 7 ]> <html class="ie6"> <![endif]-->
<!--[if IE 7 ]>    <html class="ie7"> <![endif]-->
<!--[if IE 8 ]>    <html class="ie8"> <![endif]-->
<!--[if IE 9 ]>    <html class="ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html class=""><!--<![endif]-->
<head>
	<meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
	<title>Globtorch</title>
	<!-- Standard Favicon -->
	<link rel="icon" type="image/x-icon" href="{{asset('images//logo.ico')}}"/>
	
	<!-- For iPhone 4 Retina display: -->
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="images//apple-touch-icon-114x114-precomposed.png">
	<!-- For iPad: -->
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="images//apple-touch-icon-72x72-precomposed.png">
	<!-- For iPhone: -->
	<link rel="apple-touch-icon-precomposed" href="images//apple-touch-icon-57x57-precomposed.png">
	
	<!-- Library - Bootstrap v3.3.5 -->
	<link href="{{ URL::to('landing_page/libraries/lib.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ URL::to('landing_page/libraries/Stroke-Gap-Icon/stroke-gap-icon.css') }}" rel="stylesheet" type="text/css">
	
	<!-- Fonts -->
	<link href='https://fonts.googleapis.com/css?family=Roboto:400,900,300,300italic,500,700' rel='stylesheet' type='text/css'>	
	<link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,700' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Niconne' rel='stylesheet' type='text/css'>
	<script src="https://kit.fontawesome.com/6222c6606d.js" crossorigin="anonymous"></script>
	
	<!-- Custom - Common CSS -->
	<link href="{{ URL::to('landing_page/css/plugins.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ URL::to('landing_page/css/navigation-menu.css') }}" rel="stylesheet" type="text/css">
	
	<!-- Custom - Theme CSS -->		
	<link href="{{ URL::to('landing_page/style.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ URL::to('landing_page/css/shortcode.css') }}" rel="stylesheet" type="text/css">
	
	<!--[if lt IE 9]>
		<script src="{{ URL::to('landing_page/js/html5/respond.min.js') }}"></script>
	<![endif]-->
	
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=G-HGJ5R515CY"></script>
	<script>
	window.dataLayer = window.dataLayer || [];
	function gtag(){dataLayer.push(arguments);}
	gtag('js', new Date());

	gtag('config', 'G-HGJ5R515CY');
	</script>
</head>

<body data-offset="200" data-spy="scroll" data-target=".ow-navigation">
	<div class="super_container">
		@include('layout.landing_page.header')
		@yield('content')
		@include('layout.landing_page.footer')
	</div>
	<script src="{{ URL::to('landing_page/js/jquery.min.js') }}"></script>
    <script src="{{ URL::to('landing_page/libraries/lib.js') }}"></script>
    <script src="{{ URL::to('landing_page/js/functions.js') }}"></script>
	<!-- Library - Google Map API -->
	<script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
	<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/5c715051a726ff2eea59186d/default';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->
</body>
	
	
</html>