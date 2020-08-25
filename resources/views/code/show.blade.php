@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @include('partials.errors')
                <div class="my-4">
                    <h1 class="text-center">{{$goodiebag->hasReceived == null ? $goodiebag->code . ' is your code' : 'Goodiebag delivered! Collect your treasures now'}}</h1>
                </div>
                <div class="card">
                    @if($goodiebag->hasReceived == null)
                <div class="card-header text-center">
                    <form action="{{route('goodiebag.destroy', $goodiebag->id)}}" method="POST" id="delete-form" class="m-2">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-danger float-right" onclick="saveForm()">Delete</button>
                    </form>
                    <h2>Your goodiebag for <a href="{{route('foodbank.show',$goodiebag->foodbank_id)}}">{{$goodiebag->foodbank->name}}</a></h2>
                </div>
                <div class="card-body">
                        <div class="text-center">
                            Show this to the foodbank to confirm your delivery
                        </div>
                        <div class="mt-3 mb-3">
                            The foodbank is located at {{$goodiebag->foodbank->address}} {{$goodiebag->foodbank->postalcode}} 
                            {{$goodiebag->foodbank->province}}
                        </div>
                        <div class="mt-3 mb-3">
                            You will gain <strong>{{pointToComma($goodiebag->treasures)}}</strong> amount of treasures
                        </div>
                        <div class="mt-3 mb-3">
                            <div>Don't forget to bring everything what you placed in your goodiebag:</div>
                            @foreach($goodiebag->foods as $food)
                                <span>{{displayFoodText($food->type)}}: {{displayFoodQuantity($food->pivot->amount, $food->type)}}<br></span>
                            @endforeach
                        </div>
                        <div class="text-center">
                            <a href="{{route('code.check_if_delivered', $goodiebag->id)}}" class="btn btn-primary">Click if you delivered your goods</a>
                        </div>
                        <div class="text-center mt-3 mb-3">
                            <span>Let {{$goodiebag->foodbank->name}} scan your qr code to confirm your goodiebag</span>
                        </div>
                        <div class="text-center">
                            <img src="https://api.qrserver.com/v1/create-qr-code/?data={{route('code.qr_confirmed',$goodiebag->code)}}!&size=100x100" alt="Qr-code">
                        </div>
                    </div>
                        <input type="hidden" class="form-control" name="lat" id="hidden-lat" disabled >
                        <input type="hidden" class="form-control" name="lng" id="hidden-lng" disabled >
                        <button id="btn-direction" class="btn btn-primary" onclick="calcRoute()">Get directions from current location</button>
                    </div>
                        <div class="col-lg-12">
                            <div id="map-code" class="rounded">
                            </div>
                        </div> 
                    @else
                        <div class="card-header">
                            You have deliverd your goodiebag! Thank you!
                        </div>
                        <div class="text-center m-3">
                                <a href="{{route('dashboard.index')}}" class="btn btn-primary">Collect your treasures</a>   
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
</div>
<div class="confirm">
    <div></div>
    <div>
      <div id="confirmMessage"></div>
      <div>
        <input id="confirmYes" type="button" value="Yes" />
        <input id="confirmNo" type="button" value="No" />
      </div>
    </div>
  </div>
@endsection
@section('scripts')
    <script>
        var foodbank = @json($goodiebag->foodbank);
        var styledMap = @json($styledMap);
    </script>
    <script type="text/javascript" src="{{asset('js/submit-confirm.js')}}"></script>
    <script type="text/javascript" src="{{ asset('js/map-code.js') }}"></script>
@endsection