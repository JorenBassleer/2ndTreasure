@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{$goodiebag->foodbank->name}} thanks you for your donation</div>
                <div class="card-body">
                    <div class="text-center">
                        Foodbank info
                    </div>
                    <div class="text-center">
                        You can collect your {{$goodiebag->treasures}} treasure(s) here:
                    </div>
                    <div class="text-center">
                        You stopped around {{$goodiebag->total_kg}}kg to going to waste! Good job.
                    </div>
                    
                    <div>
                        Share this to your friends: <div class="fb-share-button" data-href="https://2ndtreasure.1819.joren.bassleer.nxtmediatech.eu/" data-layout="button" data-size="small"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2F2ndtreasure.1819.joren.bassleer.nxtmediatech.eu%2F&message=I%20donated%20{{$goodiebag->total_kg}}kg%20food%20to%20{{$goodiebag->foodbank->name}}&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">Share</a></div>
                    </div>
                    @auth
                        <div>
                            The treasures have been added to your account!
                        </div>
                        <a href="{{route('dashboard.index')}}" class="btn btn-primary">Check your balance:</a>
                    @endauth
                    @guest
                        <div class="text-center">
                            <a href="{{route('dashboard.index')}}" class="btn btn-primary">Collect your treasure(s)</a>
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
