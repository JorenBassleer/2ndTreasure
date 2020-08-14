@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <h2>{{$foodbank->foodbank_name}}</h2>
                <div class="card-header">{{__('Contact details')}}</div>

                <div class="card-body">
                    <ul>
                        <li>{{$foodbank->foodbank_email}}</li>
                        <li>{{$foodbank->foodbank_address}} {{$foodbank->foodbank_city}} {{$foodbank->foodbank_postalcode}} {{$foodbank->foodbank_province}}</li>
                    </ul>
                </div>
                <div class="card-body">
                    {{$foodbank->details}}
                </div>
            </div>
            <h2>The people of {{$foodbank->foodbank_name}}</h2>
        </div>
    </div>
</div>
@endsection
