@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card-deck">
                @foreach($foodbanks as $foodbank)
                    <a href="{{route('foodbank.show', $foodbank->id)}}" style="color: black;">
                    <div class="card">
                        <img class="card-img-top" src=".../100px180/" alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title">{{$foodbank->name}}</h5>
                            <p class="card-text">{{$foodbank->foodbank->details}}</p>
                        </div>
                        <div class="card-footer">
                            <small class="text-muted">Last updated 3 mins ago</small>
                        </div>
                    </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection