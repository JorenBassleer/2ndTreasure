@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="text-center">
                <h2 class="mb-3">All the registered foodbanks</h2>
            </div>
            <div class="card-deck">
                @foreach($foodbanks as $foodbank)
                    <a href="{{route('foodbank.show', $foodbank->id)}}" style="color: black;">
                    <div class="card m-2">
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