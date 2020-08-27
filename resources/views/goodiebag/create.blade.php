
@extends('layouts.app')

@section('content')         
<div class="create-goodie-page container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="text-center">
                <h1 class="mb-3">Create a goodiebag for a foodbank</h1>
                <div class="intro">
                    Select the amounts of food products you would like to donate and select the foodbank on the map that you would like to donate to.
                </div>
            </div>
            <div class="card-deck">
                <div class="card">
                    <div class="card-body">
                        @include('partials.errors')
                        <form action="{{route('goodiebag.store')}}" method="POST" id="goodiebag_form">
                            @csrf
                            <div class="input-form">
                                @foreach($foods as $food)
                                    <div class="input-group plus-minus-input my-3 justify-content-center">
                                        <label id="label-food" for="{{($food->id)}}" class="col-md-3 col-form-label text-md-left">{{ __(displayFoodText($food->type)) }}  {{__(displayFoodUnit($food->type))}}</label>
                                        <div class="input-group-button">
                                            <button type="button" class="btn btn-circle btn-sm" data-quantity="minus" data-field="{{$food->type}}">
                                                <i class="fa fa-minus" aria-hidden="true"></i>
                                            </button>
                                        </div>
                                        @if($food->type != 'meat' && $food->type != 'fish')
                                            <input id="input-food" class="input-group-field rounded input-xs-1 @error($food->type) is-invalid @enderror" type="number" name="{{$food->type}}" value="{{old($food->type) != null ? old($food->type) : 0}}" max="50">
                                        @else
                                            <input id="input-food" class="input-group-field rounded input-xs-1 @error($food->type) is-invalid @enderror" type="number" name="{{$food->type}}" value="{{old($food->type) != null ? old($food->type) : 0}}" max="10000">
                                        @endif
                                        <div id="max-error-msg" class="invalid-feedback" name="{{$food->type}}"></div>
                                        <div class="input-group-button">
                                            <button type="button" class="btn btn-circle btn-sm" data-quantity="plus" data-field="{{$food->type}}">
                                                <i class="fa fa-plus" aria-hidden="true"></i>
                                            </button>
                                        </div>
                                    </div>
                                    {{-- <div class="form-group row">
                                        <div class="col-md-6">
                                            <input id="food_input" type="text" class="form-control @error($food->id) is-invalid @enderror" name="{{$food->type}}" value="{{ old($food->type) }}" autocomplete="{{foodBackend($food->type)}} " autofocus placeholder="{{displayFoodUnit($food->type)}}">
                                            @error($food->type)
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div> --}}
                                @endforeach
                            </div>
                            @if(request()->has('foodbank_id'))
                                <input type="hidden" name="foodbank_id" id='foodbank_id' value="{{request()->foodbank_id}}">
                            @else
                                <input type="hidden" name="foodbank_id" id='foodbank_id' value="{{old('foodbank_id')}}">
                            @endif
                        </form>
                    </div>
                </div>
                <div class="card card-2">
                    <div class="card-body">
                        <div class="col-map rounded">
                            <div id="map-goodiebag" class="map ml-4 rounded img-fluid float-right"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row text-center">
        <div class="col mt-3">
            <div>
                <button type="submit" id="goodiebag-submitbtn" class="button1" onclick="submitForm()">
                    {{ __('Confirm goodiebag') }}
                </button>
            </div>
            </div>  
        </div>
    </div>
</div>
<!-- The Modal -->
<div id="myModal" class="modal">

    <!-- Modal content -->
    <div class="modal-content">
      <span class="close">&times;</span>
      <p class="p-popup" name="popup"></p>
    </div>
  
  </div>
@endsection

@section('scripts')

<script type="text/javascript" src="{{asset('js/goodiebag-create-buttons.js')}}"></script>
<script>
    
    // Set the latitude and longitude for maps if user does not give location
    var antLat = {{$lat ?? 51.2194475}};
    var antLng = {{$lng ?? 4.4024643}};
    // Convert php variable to js for map value
    var foodbanks = @json($foodbanks);
    // Covert json map style for js
    var styledMap = @json($styledMap);
    if ( typeof document.getElementById('foodbank_id').value != 'undefined') {
        var foodbankMarkerId =document.getElementById('foodbank_id').value;
    }
    else {
        var foodbankMarkerId =null;
    }
</script>
<script>
    function submitForm() {
        document.getElementById('goodiebag_form').submit();
    }
</script>
<script type="text/javascript" src="{{ asset('js/map-welcome.js') }}"></script>
@endsection