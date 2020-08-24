@extends('layouts.app')

@section('content')
<div class="landing-page container">
    <div class="row justify-content-center">
        <div class="home-boxes">
            <div class="left">
                <h3>How does <br> 2ndTreasure work?</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. 
                    Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. 
                    Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
                <div class="donate-btn">
                    <a class="button1" href="">Donate food!</a>
                </div>
            </div>
            <div class="right">
                <img class="illustration1" src="{{asset('images/boxtransparent.png')}}" alt="">
            </div>
        </div>

        <div class="home-boxes-2">
            <div class="left">
                <img class="illustration2" src="{{asset('images/illustration2.png')}}" alt="">
            </div>
            <div class="right">
                
                <h3>Register your<br> foodbank</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. 
                    Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. 
                    Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
                <div class="register-btn">
                    <a class="button1" href="{{route('foodbank.show_form')}}">Register!</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection