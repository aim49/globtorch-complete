<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Adding CSRF token for form submission through javascript -->
    <meta name="csrf-token" content="{{ Session::token() }}"> 

    <!-- Favicon icon -->
    <link rel="icon" type="image/jpg" href="{{ asset('images/logos.jpg') }}"/>
    <title>Globtorch</title>
    <!-- Bootstrap Core CSS -->
    <link href="{{ URL::to('css/lib/bootstrap/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ URL::to('css/lib/calendar2/semantic.ui.min.css') }}" rel="stylesheet"/>
    <link href="{{ URL::to('css/lib/calendar2/pignose.calendar.min.css') }}" rel="stylesheet"/>
    <link href="{{ URL::to('css/lib/owl.carousel.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::to('css/lib/owl.theme.default.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::to('css/helper.css') }}" rel="stylesheet"/>
    <link href="{{ URL::to('css/style.css') }}" rel="stylesheet"/>
    <link href="{{ URL::to('css/shortcode.css') }}" rel="stylesheet"/>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesnt work if you view the page via file:** -->
    <!--[if lt IE 9]>
        <script src="https:**oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https:**oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
   <![endif]-->
 
   <script src="https://kit.fontawesome.com/6222c6606d.js" crossorigin="anonymous"></script>
    <link href="{{ URL::to('css/styles.css') }}" rel="stylesheet">

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-HGJ5R515CY"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-HGJ5R515CY');
    </script>
    <style>
        .notification:hover {
            background: red;
        }

        .notification .badge {
            position: absolute;
            top: 0px;
            right: 0px;
            padding: 5px 5px;
            border-radius: 50%;
            background: red;
            color: white;
        }
    </style>
</head>
