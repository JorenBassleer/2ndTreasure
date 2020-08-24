
@extends('layouts.app')

@section('content')         
<div class="create-goodie-page container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="text-center">
                <h1 class="mb-3">Create a goodiebag for a foodbank</h1>
                <div class="intro">
                    Select the amounts of food products you would like to donate on the left and select the foodbank on the map that you would like to donate to on the right.
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
                                        <label id="label-food" for="{{($food->id)}}" class="col-md-3 col-form-label text-md-left">{{ __(displayFoodText($food->type)) }}</label>
                                        <div class="input-group-button">
                                            <button type="button" class="btn btn-circle btn-sm" data-quantity="minus" data-field="{{$food->type}}">
                                                <i class="fa fa-minus" aria-hidden="true"></i>
                                            </button>
                                        </div>
                                        <input id="input-food" class="input-group-field rounded input-xs-1" type="number" name="{{$food->type}}" value="0">
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
                            <div class="text-center">
                                <div class="g-recaptcha mb-4" data-sitekey="6LcPL8IZAAAAAPWoYJcwYZsFaUPTZD_bdkwAAy2j"></div>
                            </div>
                            <input type="hidden" name="foodbank_id" id='foodbank_id' value="">
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
                    {{ __('Create goodiebag') }}
                </button>
            </div>
            
            {{-- <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-4">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Reset Password') }}
                    </button>
                </div> --}}
            </div>  
        </div>
    </div>
</div>
@endsection
<!-- Change the `data-field` of buttons and `name` of input field's for multiple plus minus buttons-->

  
  
@section('scripts')
{{-- Button plus and min --}}
<script>
jQuery(document).ready(function(){
    // This button will increment the value
    $('[data-quantity="plus"]').click(function(e){
        // Stop acting like a button
        e.preventDefault();
        // Get the field name
        fieldName = $(this).attr('data-field');
        // Get its current value
        var currentVal = parseInt($('input[name='+fieldName+']').val());
        // If is not undefined
        if (!isNaN(currentVal)) {
            // Increment
            $('input[name='+fieldName+']').val(currentVal + 1);
        } else {
            // Otherwise put a 0 there
            $('input[name='+fieldName+']').val(0);
        }
    });
    // This button will decrement the value till 0
    $('[data-quantity="minus"]').click(function(e) {
        // Stop acting like a button
        e.preventDefault();
        // Get the field name
        fieldName = $(this).attr('data-field');
        // Get its current value
        var currentVal = parseInt($('input[name='+fieldName+']').val());
        // If it isn't undefined or its greater than 0
        if (!isNaN(currentVal) && currentVal > 0) {
            // Decrement one
            $('input[name='+fieldName+']').val(currentVal - 1);
        } else {
            // Otherwise put a 0 there
            $('input[name='+fieldName+']').val(0);
        }
    });
});
</script>
<script>
    // Set the latitude and longitude for maps if user does not give location
    var antLat = {{$lat ?? 51.2194475}};
    var antLng = {{$lng ?? 4.4024643}};
    // Convert php variable to js for map value
    var foodbanks = @json($foodbanks);
    // Covert json map style for js
    var styledMap = @json($styledMap);
    var key = @json(config('googlemaps.key'));
</script>
<script>
    function submitForm() {
        document.getElementById('goodiebag_form').submit();
    }
</script>
<script type="text/javascript" src="{{ asset('js/map-welcome.js') }}"></script>
@endsection