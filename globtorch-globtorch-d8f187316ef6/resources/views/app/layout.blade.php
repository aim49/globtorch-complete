<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        @yield('scripts')
        <script src="{!!url('/js/jquery-3.3.1.min.js')!!}"></script>
        
        @yield('styles')
        <link rel="stylesheet" href="{{asset('css/app.css')}}">

        <title>Globtorch</title>

        <style>
            .center{
                text-align: center;
            }
        </style>

        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-HGJ5R515CY"></script>
        <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-HGJ5R515CY');
        </script>
    </head>
    <body>
        <div class="container">
            <div>
                <h1 class="center">Globtorch</h1>
            </div>
            <div>
                @yield('content')
            </div>
        </div>
        
        @yield('body_script')
    </body>
</html>