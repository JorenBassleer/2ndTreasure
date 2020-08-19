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
                        You can collect your ... treasure(s) here:
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
