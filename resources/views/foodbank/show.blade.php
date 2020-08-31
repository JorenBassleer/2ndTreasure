@extends('layouts.app')

@section('content')
<div class="foodbank-id container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if(!$isLoggedIn)
                <div class="card">
                    <div class="m-2 card-body">
                        <h1>{{$foodbank->name}}</h1>
                        <h3 class="header">{{__('Contact details')}}</h3>
                        <div class="details-div">
                            <div class="details-list">
                                <ul>
                                    <li><a href="mailto:{{$foodbank->email}}">{{$foodbank->email}}</li></a>
                                    <li><a href="tel:{{$foodbank->phone}}">{{$foodbank->phone}}</li></a>
                                    <li><a href="{{$foodbank->website}}">{{$foodbank->website}}</li></a>
                                    <li>{{$foodbank->address}} {{$foodbank->city}} {{$foodbank->postalcode}} {{$foodbank->province}}</li>
                                    <li class="my-2"><strong>Opening hours: </strong>{{$foodbank->foodbank->opening_hours}}</li>
                                </ul>
                                {{$foodbank->foodbank->details}}
                            </div>
                            <div class="donate-to-this">
                                <a class="button2" href="{{route('goodiebag.create', ['foodbank_id' => $foodbank->id])}}">Donate to this foodbank</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="map-code" class="rounded">

                </div>
            @else
                @include('partials.errors')
                {{-- Foodbank is logged in and can update info --}}
                <form action="{{route('foodbank.update', $foodbank->id)}}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card form-group">
                        <h2><input type="text" name="foodbank_name" id="" value="{{$foodbank->name}}"></h2>
                        <div class="card-header">{{__('Contact details')}}</div>

                        <div class="card-body foodbank-edit">
                            <ul>
                                <li>
                                    <label for="foodbank_email">Email:</label>
                                    <input type="text" name="foodbank_email" id="" value="{{$foodbank->email}}">
                                </li>
                                <li>
                                    <label for="foodbank_phone">Phone number:</label>
                                    <input type="text" name="foodbank_phone" id="" value="{{$foodbank->phone}}">
                                </li>
                                <li>
                                    <label for="foodbank_address">Address:</label>
                                    <input type="text" name="foodbank_address" id="" value="{{$foodbank->address}}">
                                </li>
                                <li>
                                    <label for="foodbank_city">City:</label>
                                    <input type="text" name="foodbank_city" id="" value="{{$foodbank->city}}">
                                </li>
                                <li>
                                    <label for="foodbank_postalcode">Postal code:</label>
                                    <input type="text" name="foodbank_postalcode" id="" value="{{$foodbank->postalcode}}">
                                </li>
                                <li>
                                    <label for="foodbank_province">Province: </label>
                                    <input type="text" name="foodbank_province" id="" value="{{$foodbank->province}}">
                                </li>
                                <li>
                                    <label for="foodbank_country">Country: </label>
                                    <input type="text" name="foodbank_country" id="" value="{{$foodbank->country}}">
                                </li>
                            </ul>
                            <ul>
                                <li>
                                    <label for="opening_hours">Opening hours:</label>
                                    <textarea name="opening_hours" id="" >{{$foodbank->foodbank->opening_hours}}</textarea>
                                </li>
                                <li>
                                    <label for="company_number">Company number:</label>
                                    <input type="text" name="company_number" id="" value="{{$foodbank->foodbank->company_number}}">
                                </li>
                                <li>
                                    <label for="details">Details: </label>
                                    <textarea name="details" id="" >{{$foodbank->foodbank->details}}</textarea>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                        </div>
                        <div class="card-footer">
                        </div>
                        <button type="submit" class="button3">Update page</button>
                    </div>
                </form>
            @endif
        </div>
    </div>
</div>

@endsection
@section('scripts')
<script>
    var foodbank = @json($foodbank);
    var styledMap = @json($styledMap);
    var foodbankLoc = {lat: Number(foodbank.lat), lng: Number(foodbank.lng)};
</script>
<script type="text/javascript" src="{{ asset('js/map-foodbank.js') }}"></script>
@endsection