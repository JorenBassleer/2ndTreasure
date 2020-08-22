<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <!-- Jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/d3js/5.16.0/d3.min.js"></script>
    <!-- Social Media -->
    <meta property="og:url"           content="{{URL::to('/')}}" />
    <meta property="og:type"          content="website" />
    <meta property="og:title"         content="2ndTreasure" />
    <meta property="og:description"   content="Do good with goodiebags" />
    <meta property="og:image"         content="https://www.your-domain.com/path/image.jpg" />
    <!-- Facebook -->
    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v8.0&appId=1742654069206147&autoLogAppEvents=1" nonce="9xE3uijj"></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">


</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <a class="navbar btn btn-success" href="{{route('goodiebag.create')}}">
                    Make a 2ndTreasure goodiebag
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('leaderboard.index')}}">Leaderboards</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('foodbank.index')}}">Foodbanks</a>
                        </li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        @if(!Auth::check())
                            {{-- Qr code link + goodiebag so non users can access --}}
                            @if(Cookie::get('goodiebag_id') != null)
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('show.code', request()->cookie('goodiebag_id')) }}">{{ __('Your ongoing goodiebag') }}</a>
                                </li>
                            @endif
                        @else
                        {{-- Alle Goodiebags met hasReceived == null --}}
                            {{-- Get all goodiebags of user that haven't been delivered --}}
                                {{-- {{auth()->user()->with([
                                    'goodiebags' => function ($q) {
                                        return $q->where('hasReceived', null)->get();
                                    }
                                ])->get()}} --}}
                            @if(count(auth()->user()->with([
                                'goodiebags' => function ($q) {
                                    return $q->where('hasReceived', null)
                                             ->whereNotNull('code')
                                    ->get();
                                }
                                ])) > 0)
                                <div class="dropdown"type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{ __('Your ongoing goodiebags') }}
                                  </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                        @foreach(auth()->user()->with([
                                            'goodiebags' => function ($q) {
                                                return $q->where('hasReceived', null)->first();
                                            }
                                            ])->get() as $key => $onGoingGoodiebag)
                                            {{dd($onGoingGoodiebag->code)}}
                                            <a href="{{route('goodiebag.show', $onGoingGoodiebag->code)}}"><button class="dropdown-item" type="button">Goodiebag number {{$key}}</button></a>
                                        @endforeach
                                    </div>
                                    {{-- <a class="nav-link" href="{{ route('show.code', request()->cookie('goodiebag_id')) }}"></a> --}}
                                </li>
                            @endif 
                        @endif
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('dashboard.index') }}"><i class="fa fa-bar-chart" aria-hidden="true"></i>
                                </a> 
                            </li>  
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ ucfirst(Auth::user()->name) }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>

@yield('scripts')
