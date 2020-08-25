@extends('layouts.app')

@section('content')
<div class="landing-page container">
    <div class="row justify-content-center">
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
                <p>You own a foodbank or know someone who owns one? Awesome! Fill out small a form and you will hear from us in less than 24 hours.</p>
                <div class="register-btn">
                    <a class="button1" href="{{route('foodbank.show_form')}}">Sign up!</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection