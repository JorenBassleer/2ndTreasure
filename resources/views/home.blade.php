@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
            @if(!count($foodbanks) > 0)
                <div class="card">
                    <div class="card-body"><h3><a href="{{route('foodbank.create')}}">Do you own a foodbank? Add it to our website</a></h3></div>
                </div>
            @else
            <div class="card">
                <div class="card-header">{{__('Manage your foodbanks')}}</div>
                @foreach($foodbanks as $foodbank)
                    <div class="card-body"><a href="{{route('foodbank.show', $foodbank->id)}}">{{$foodbank->foodbank_name}}</a></div>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</div>

@endsection
