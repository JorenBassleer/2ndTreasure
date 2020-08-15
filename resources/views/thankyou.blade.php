@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{$foodbank->foodbank_name}} thanks you for your donation</div>
                <div class="card-body">
                    <div class="text-center">
                        Foodbank info
                    </div>
                    <div class="text-left">
                        Google maps:
                    </div>
                    <div class="text-center m-3">
                        <a href="{{route('foodbank.show',$foodbank->id)}}">Checkout their page</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
