@extends('layouts.app')

@section('content')
<div class="foodbanks-page container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="text-center">
                <h1 class="mb-3">All the registered foodbanks</h1>
            </div>
            <div class="card-deck">
                @foreach($foodbanks as $foodbank)
                    <div class="card">
                        <a href="{{route('foodbank.show', $foodbank->id)}}" style="color: black;">
                        <div class="m-2">
                            <div class="card-body">
                                <h3 class="card-title">{{$foodbank->name}}</h3>
                                {{-- <p class="card-text">{{$foodbank->foodbank->details}}</p> --}}
                                <small class="text-muted">Last updated 3 mins ago</small>
                            </div>
                        </div>
                        </a>
                    </div>
                @endforeach
            </div>
            <div class="my-3 links">
                {{$foodbanks->links()}}
            </div>
        </div>
    </div>
</div>
@endsection