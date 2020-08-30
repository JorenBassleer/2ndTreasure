@extends('layouts.app')

@section('content')
<div class="landing-page container">
    <div class="row justify-content-center">
        <div class="animated-txt">
            <h1 class="ms-header__title">
              Do good with a
              <div class="ms-slider">
                <ul class="ms-slider__words">
                  <li class="ms-slider__word">goodiebag</li>
                  <li class="ms-slider__word">foodiebag</li>
                  <li class="ms-slider__word">goodiebag</li>
                </ul>
              </div>
            </h1>
        </div>
        <div class="home-boxes">
            <div class="left">
                <h3>How does <br> 2ndTreasure work?</h3>
                <p>You have spare food or food you want to give away? Make a goodiebag and donate it to a foodbank. 
                    You receive from this our currency treasures. The amount of treasures you receive is based on the amount of people you helped with your goodiebag. 
                    Go out there and help those who need it</p>
                <div class="donate-btn">
                    <a class="button1" href="{{route('goodiebag.create')}}">Donate food!</a>
                </div>
            </div>
            <div id="right-first" class="right">
                <img id="first-illustation" class="illustration1" src="{{asset('images/boxtransparent.png')}}" alt="">
            </div>
        </div>

        <div class="home-boxes-2">
            <div class="left">
                <img class="illustration2" src="{{asset('images/illustration2.png')}}" alt="">
            </div>
            <div class="right">
                
                <h3>Register your<br> foodbank</h3>
                <p>You own a foodbank or know someone who owns one? Awesome! Fill out small a form and you will hear from us in less than 24 hours.</p>
                <div class="register-btn">
                    <a class="button1" href="{{route('foodbank.show_form')}}">Sign up!</a>
                </div>
            </div>
        </div>
        <div class="home-boxes">
            <div class="left">
                <h3>Track your stats</h3>
                <p>We track the goodiebags you donate to the foodbanks<br>
                After you spend 4 weeks and donate enough goodiebags you will be able to see your progress in the dashboard</p>
                <div class="donate-btn">
                    <a class="button1" href="{{route('register')}}">Register here!</a>
                </div>
            </div>
            <div class="right">
                <img class="illustration1" src="{{asset('images/boxtransparent.png')}}" alt="">
            </div>
        </div>
        <div class="counter-title">
            <h3>Feel good stats</h3>
        </div>
        <div class="counters">
            <div class="">
                <i class=""></i>
                <div id="kg-donated" class="counter" data-target="{{$kg_donated}}">0</div>
                <h3>Total kg donated</h3>
            </div>
            <div class="">
                <i class=""></i>
                <div id="goodiebags-created" class="counter" data-target="{{$goodiebags_created}}">0</div>
                <h3>Goodiebags created</h3>
            </div>
            <div class="">
                <i class=""></i>
                <div id="people-helped" class="counter" data-target="{{$people_helped}}">0</div>
                <h3>Amount of people helped</h3>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
    <script type="text/javascript" src="{{asset('js/counters.js')}}"></script>
    <script>
        document.cookie = "text=test";
    </script>
@endsection