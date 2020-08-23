
@extends('layouts.app')

@section('content')         
<div class="title m-b-md">
    2ndTreasure
</div> 
<div class="card">
    <div class="card-header">Create a goodiebag for a foodbank</div>
    <div class="card-body">
        <div class="col-md-8">Help those who need it and give a 2ndTreasure goodiebag to a foodbank</div>
        @include('partials.errors')
        <form action="{{route('goodiebag.store')}}" method="POST">
            @csrf
            @foreach($foods as $food)
                <div class="form-group row">
                    <label for="{{($food->id)}}" class="col-md-4 col-form-label text-md-right">{{ __(displayFoodText($food->type)) }}</label>
                    <div class="col-md-6">
                        <input id="food_input" type="text" class="form-control @error($food->id) is-invalid @enderror" name="{{$food->type}}" value="{{ old($food->type) }}" autocomplete="{{foodBackend($food->type)}} " autofocus placeholder="{{displayFoodUnit($food->type)}}">
                        @error($food->type)
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            @endforeach
            <div class="g-recaptcha mb-4" data-sitekey="6LcPL8IZAAAAAPWoYJcwYZsFaUPTZD_bdkwAAy2j"></div>
            <input type="hidden" name="foodbank_id" id='foodbank_id' value="">
            <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-4">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Create goodiebag') }}
                    </button>
                </div>
            </div>
        </form>
        <div id="map" class="map"></div>
        </div>
    </div>
</div>
@endsection
@section('scripts')

    <script>
        // Set the latitude and longitude for maps if user does not give location
        var antLat = {{$lat ?? 51.2194475}};
        var antLng = {{$lng ?? 4.4024643}};
        // Convert php variable to js for map
        var foodbanks = @json($foodbanks);
    </script>
    <script type="text/javascript" src="{{ asset('js/map-welcome.js') }}"></script>
@endsection