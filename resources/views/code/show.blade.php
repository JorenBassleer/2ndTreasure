@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @include('partials.errors')
            <div class="card">
                <h1 class="text-center mx-auto"><strong>{{$goodiebag->code}}</strong> is your code</h1>
                    @if($goodiebag->hasReceived == null)
                    <form action="{{route('goodiebag.destroy', $goodiebag->id)}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete goodiebag</button>
                    </form>
                <div class="card-header text-center">
                    <h2>Your goodiebag for {{$goodiebag->foodbank->name}}</h2>
                </div>
                <div class="card-body">
                        <div class="text-center">
                            Show this to the foodbank to confirm your delivery
                        </div>
                        <div>
                            The foodbank is located at {{$goodiebag->foodbank->address}}
                        </div>
                        <div>
                            You will gain {{$goodiebag->treasures}} amount of treasures
                        </div>
                        <div>
                            <div>Don't forget to bring everything what you placed in your goodiebag:</div>
                            @foreach($goodiebag->foods as $food)
                                <span>{{displayFoodText($food->type)}}: {{displayFoodQuantity($food->pivot->amount, $food->type)}}<br></span>
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
                    @else
                        <div class="text-center">
                            You have deliverd your goodiebag! Thank you!
                        </div>
                        <div class="text-center">
                                <a href="{{route('dashboard.index')}}" class="btn btn-primary">Collect your treasures</a>   
                        </div>
                        <div>
                            You stopped around {{presentWeightToKg($goodiebag->total_kg, 1)}} to going to waste!
                        </div>
                        <div>
                            <div>This was in your goodiebag</div>
                            @foreach($goodiebag->foods as $food)
                                <span>{{displayFoodText($food->type)}}: {{displayFoodQuantity($food->pivot->amount, $food->type)}}<br></span>
                            @endforeach
                        </div>
                    @endif
                    
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