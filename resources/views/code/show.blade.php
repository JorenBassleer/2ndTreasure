@extends('layouts.app')

@section('content')
<div class="code-show container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @include('partials.errors')
            <div class="">
                <h1 class="text-center">{{$goodiebag->hasReceived == null ? $goodiebag->code . ' is your code' : 'Goodiebag delivered! Collect your treasures now'}}</h1>
            </div>
            <div class="card">
                @if($goodiebag->hasReceived == null)
            
                <div class="card-body">
                    <div class="heading-div text-center">
                        <h3>Your goodiebag for <a href="{{route('foodbank.show',$goodiebag->foodbank_id)}}">{{$goodiebag->foodbank->name}}</a></h3>
                        <form action="{{route('goodiebag.destroy', $goodiebag->id)}}" method="POST" id="delete-form" class="m-2">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="delete-btn button2 float-right" onclick="saveForm()">Delete</button>
                        </form>
                    </div>
                    <div class="text-center">
                        Show this to the foodbank to confirm your delivery
                    </div>
                    <div class="text-center mt-3 mb-3">
                        The foodbank is located at {{$goodiebag->foodbank->address}} {{$goodiebag->foodbank->postalcode}} 
                        {{$goodiebag->foodbank->province}}
                    </div>
                    <div class="text-center mt-3 mb-3">
                        You will give <strong>{{pointToComma($goodiebag->treasures)}}</strong> worth of days supplies. Wow!
                    </div>
                    <div class="text-center mt-3 mb-3">
                        <div>Don't forget to bring everything what you placed in your goodiebag:</div>
                        @foreach($goodiebag->foods as $food)
                            <span>{{displayFoodText($food->type)}}: {{displayFoodQuantity($food->pivot->amount, $food->type)}}<br></span>
                        @endforeach
                    </div>
                    <div class="delivered-btn text-center">
                        <a href="{{route('code.check_if_delivered', $goodiebag->id)}}" class="button3">Press if you delivered your goods</a>
                    </div>
                    <div class="text-center mt-3">
                        <span>Let {{$goodiebag->foodbank->name}} scan your qr code to confirm your goodiebag</span>
                    </div>
                    <div class="qr-code-div text-center">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?data={{route('code.qr_confirmed',$goodiebag->code)}}!&size=100x100" alt="Qr-code">
                    </div>
                </div>
                <input type="hidden" class="form-control" name="lat" id="hidden-lat" disabled >
                <input type="hidden" class="form-control" name="lng" id="hidden-lng" disabled >
                <button id="btn-direction" class="" onclick="calcRoute()">Get directions from current location</button>
            </div>
            <div class="card card-2">
                <div class="col-lg-12">
                    <div id="map-code" class="rounded">
                    </div>
                </div> 
            </div>
            @else
                <div class="text-center card-body">
                    You have delivered your goodiebag! Good job!
                </div>
                <div class="button-div text-center m-3">
                        <a href="{{route('dashboard.index')}}" class="button2">Check out your dashboard</a>   
                </div>
                <div class="text-center">
                    You stopped around {{presentWeightToKg($goodiebag->total_kg, 1)}} to going to waste!
                </div>
                <div class="text-center mb-2">
                    <div class="mt-2">This was in your <strong>goodiebag:</strong></div>
                    @foreach($goodiebag->foods as $food)
                        <span>{{displayFoodText($food->type)}}: {{displayFoodQuantity($food->pivot->amount, $food->type)}}<br></span>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
    <div class="confirm modal">
        <div>
            <div>
                <div id="confirmMessage"></div>
                <div>
                    <input id="confirmYes" type="button" value="Yes" />
                    <input id="confirmNo" type="button" value="No" />
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('scripts')
    <script>
        var foodbank = @json($goodiebag->foodbank);
        var styledMap = @json($styledMap);
        var key = @json(config('googlemaps.key'));
    </script>
    <script type="text/javascript" src="{{asset('js/submit-confirm.js')}}"></script>
    <script type="text/javascript" src="{{ asset('js/map-code.js') }}"></script>
@endsection