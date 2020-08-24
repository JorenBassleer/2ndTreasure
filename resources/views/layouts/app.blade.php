<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', '2ndTreasure') }}</title>

    <!-- Jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/d3js/5.16.0/d3.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <!-- Social Media -->
    <meta property="og:url"           content="{{URL::to('/')}}" />
    <meta property="og:type"          content="website" />
    <meta property="og:title"         content="2ndTreasure" />
    <meta property="og:description"   content="Do good with goodiebags" />
    <meta property="og:image"         content="https://www.your-domain.com/path/image.jpg" />
    <!-- Facebook -->
    <!-- <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v8.0&appId=1742654069206147&autoLogAppEvents=1" nonce="9xE3uijj"></script> -->
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Google recaptcha -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>


</head>
<body>
    <div id="app">
        <div class="thePage">
            <header>
                @section('header')
                    @include('partials.header')
                @show
            </header>

            <main class="py-4">
                @yield('content')
            </main>

            <footer>
                @section('footer')
                    @include('partials.footer')
                @show
            </footer>
        </div>
    </div>
</body>
</html>

@yield('scripts')
