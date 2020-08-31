@extends('layouts.app')

@section('content')
<div class="thankyou-page container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="">
                <h1 class="text-center">{{$goodiebag->foodbank->name}} thanks you for your donation!</h1>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="text-center">
                        <h3>You stopped around {{presentWeightToKg($goodiebag->total_kg, true)}} to going to waste. Good job!</h3>
                    </div>
                    
                    <div class="text-center">
                        <div class="fb-share-button" data-href="https://2ndtreasure.1819.joren.bassleer.nxtmediatech.eu/" data-layout="button" data-size="small">
                            <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2F2ndtreasure.live%2F&message=I%20donated%20{{$goodiebag->total_kg}}kg%20food%20to%20{{$goodiebag->foodbank->name}}&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">Share this to your friends</a>
                        </div>
                    </div>
                    <div class="text-center">
                        You have helped {{pointToComma($goodiebag->treasures)}} many people
                    </div>
                    @auth
                        
                        <div class="text-center-btn">
                            <a href="{{route('dashboard.index')}}" class="button2">Check your dashboard</a>
                        </div>
                    @endauth
                    @guest
                        <div class="text-center">
                            <a href="{{route('dashboard.index')}}" class="btn btn-primary">Check your dashboard</a>
                        </div>
                    @endguest
                    <div class="text-center m-3">
                        <a href="{{route('foodbank.show',$goodiebag->foodbank->id)}}">Checkout their page</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
