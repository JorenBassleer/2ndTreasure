@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if(!$isLoggedIn)
                <div class="card">
                    <h2>{{$foodbank->name}}</h2>
                    <div class="card-header">{{__('Contact details')}}</div>

                    <div class="card-body">
                        <ul>
                            <li>{{$foodbank->email}}</li>
                            <li>{{$foodbank->phone}}</li>
                            <li>{{$foodbank->address}} {{$foodbank->city}} {{$foodbank->postalcode}} {{$foodbank->province}}</li>
                        </ul>
                    </div>
                    <div class="card-body">
                        {{$foodbank->details}}
                    </div>
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

                        <div class="card-body">
                            <ul>
                                <li><input type="text" name="foodbank_email" id="" value="{{$foodbank->email}}"></li>
                                <li><input type="text" name="foodbank_phone" id="" value="{{$foodbank->phone}}"></li>
                                <li><input type="text" name="foodbank_address" id="" value="{{$foodbank->address}}"></li>
                                <li><input type="text" name="foodbank_city" id="" value="{{$foodbank->city}}"></li>
                                <li><input type="text" name="foodbank_postalcode" id="" value="{{$foodbank->postalcode}}"></li>
                                <li><input type="text" name="foodbank_province" id="" value="{{$foodbank->province}}"></li>
                                <li><input type="text" name="foodbank_country" id="" value="{{$foodbank->country}}"></li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <input type="textarea" name="details" id="" value="{{$foodbank->foodbank->details}}">
                        </div>
                        <div class="card-footer">
                            <input type="text" name="company_number" id="" value="{{$foodbank->foodbank->company_number}}">
                        </div>
                        <button type="submit" class="btn btn-primary">Update page</button>
                    </div>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection
