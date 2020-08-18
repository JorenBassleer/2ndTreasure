@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center"><h2>{{$goodiebag->code}} is your code</h2></div>
                <div class="card-body">
                    <div class="text-center">
                        Show this to the foodbank to confirm your delivery
                    </div>
                    <div class="text-left">
                        Google maps:
                    </div>
                    <div>
                        You will need to be ... at ...
                    </div>
                    <div>
                        You will gain xx amount of coins
                    </div>
                    <div class="text-center m-3">
                        <a href="{{route('foodbank.show',$goodiebag->foodbank->id)}}">Checkout their page</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection