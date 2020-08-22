@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @include('partials.errors')
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
                        The foodbank is located at {{$goodiebag->foodbank->address}}
                    </div>
                    <div>
                        You will gain {{$goodiebag->treasures}} amount of treasures
                    </div>
                    <div>
                        <div>Don't forget to bring:</div>
                        @foreach($goodiebag->foods as $food)
                            <span>{{$food->pivot->amount}} {{$food->type}}</span>
                        @endforeach
                    </div>
                    <div class="text-center">
                        <a href="{{route('code.check_if_delivered', $goodiebag->id)}}" class="btn btn-primary">Click if you delivered your goods</a>
                    </div>
                    <div class="text-center m-3">
                        <a href="{{route('foodbank.show',$goodiebag->foodbank_id)}}">Checkout their page</a>
                    </div>
                    <div class="text-center">
                        <span>Let {{$goodiebag->foodbank->name}} scan your qr code to confirm your goodiebag</span>
                        <img src="http://api.qrserver.com/v1/create-qr-code/?data={{route('code.qr_confirmed',$goodiebag->code)}}!&size=100x100" alt="Qr-code">
                    </div>
                </div>
                <input type="hidden" class="form-control" name="lat" id="hidden-lat" disabled >
                <input type="hidden" class="form-control" name="lng" id="hidden-lng" disabled >
                <button id="btn-direction" class="btn btn-primary" onclick="calcRoute()">Get directions from current location</button>
            </div>
            <div class="col-lg-12">
                <div id="map-code">
    
                </div>
            </div>  
        </div>
    </div>
</div>
@endsection
@section('scripts')
    <script>
        var foodbank = @json($goodiebag->foodbank);
    </script>
    <script type="text/javascript" src="{{ asset('js/map-code.js') }}"></script>
@endsection