
@extends('layouts.app')

@section('content')         
<div class="title m-b-md">
    2ndTreasure
</div> 
<div class="card">
    <div class="card-header">Create a goodiebag for a foodbank</div>
    <div class="card-body">
        <div class="col-md-8">Help those who need it and give a 2ndTreasure goodiebag to a foodbank</div>
        <form action="{{route('goodiebag.store')}}" method="POST">
            @csrf
            @foreach($foods as $food)
                <div class="form-group row">
                    <label for="{{($food->id)}}" class="col-md-4 col-form-label text-md-right">{{ __(str_replace('_', ' ' ,$food->type)) }}</label>
                    <div class="col-md-6">
                        <input id="food_input" type="text" class="form-control @error($food->id) is-invalid @enderror" name="{{$food->type}}" value="{{ old($food->type) }}" autocomplete="{{foodBackend($food->type)}} " autofocus>
                        @error($food->type)
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            @endforeach
            <div>
                <label for="foodbank_id">Select foodbank</label>
                <select name="foodbank_id" id="foodbank_id">
                    @foreach($foodbanks as $foodbank)
                        <option name="foodbank_id" value="{{$foodbank->id}}">{{$foodbank->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-4">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Create goodiebag') }}
                    </button>
                </div>
            </div>
        </form>
        <style>
            #map {
            display: block;
            float: right;
            height: 400px;
            width: 50%;
            }
        </style>
        <div id="map" class="map"></div>
        </div>
        <a href="{{route('foodbank.create')}}">Add your own foodbank</a>
    </div>
</div>
<script>

var script = document.createElement('script');
script.src = 'https://maps.googleapis.com/maps/api/js?key=AIzaSyAXVSQngRh511t5sFYqGlveekKmHBda-ow&callback=initMap';
script.defer = true;
document.head.appendChild(script);
window.initMap = function() {
    let map, infoWindow;
    map = new google.maps.Map(document.getElementById("map"), {
        center: { lat: {{$lat}}, lng: {{$lng}} },
        zoom: 13,
        mapTypeControlOptions: {
        mapTypeIds: []
        }, // here´s the array of controls
        disableDefaultUI: true, // a way to quickly hide all controls
        mapTypeControl: true,
        scaleControl: true,
        zoomControl: true,
        zoomControlOptions: {
        style: google.maps.ZoomControlStyle.LARGE 
        },
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });
    infoWindow = new google.maps.InfoWindow;
    setMarkers(map);

    // Try HTML5 geolocation.
if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
    var pos = {
        lat: position.coords.latitude,
        lng: position.coords.longitude
    };

    infoWindow.setPosition(pos);
    infoWindow.setContent('You are here');
    infoWindow.open(map);
    map.setCenter(pos);
    }, function() {
    handleLocationError(true, infoWindow, map.getCenter());
    });
} else {
    // Browser doesn't support Geolocation
    handleLocationError(false, infoWindow, map.getCenter());
}
};


function handleLocationError(browserHasGeolocation, infoWindow, pos) {
infoWindow.setPosition(pos);
infoWindow.setContent(browserHasGeolocation ?
                        'Error: The Geolocation service failed.' :
                        'Error: Your browser doesn\'t support geolocation.');
infoWindow.open(map);
}


function setMarkers(map){
    var foodbanks = @json($foodbanks);
    for (var i = 0; i < foodbanks.length; i++) {
        var foodbank = foodbanks[i];
        var foodbankLoc = {lat: Number(foodbank.lat), lng: Number(foodbank.lng)}
        const contentString =
            '<div id="content">' +
            '<div id="siteNotice">' +
            "</div>" +
            '<h2 id="firstHeading" class="firstHeading">'+foodbank.name+'</h2>' +
            '<div id="bodyContent">' +
            "<p>" + foodbank.name + " " + foodbank.details + "</p>" +
            '<a href="http://127.0.0.1:8000/foodbank/'+ foodbank.id +'">Link</a>' +
            "</div>" +
            "</div>";
        const infowindow = new google.maps.InfoWindow({
            content: contentString
        });
        const marker = new google.maps.Marker({
            position: foodbankLoc,
            map,
            title: foodbank.name,
        });
        marker.addListener("click", () => {
            infowindow.open(map, marker);
        });
    }    
}

    </script>
@endsection
   