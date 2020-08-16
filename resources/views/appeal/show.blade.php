@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @include('partials.errors')
        <div class="col-md-8">
            @if($isFoodbankOwner)
                <div class="card">
                    <h2>{{$appeal->user->first_name}} {{$appeal->user->last_name}} has a package for you</h2>
                    <div class="card-header">{{__('Contact details')}}</div>
                    <div class="card-body">
                        <ul>
                            <li>{{$appeal->user->email}}</li>
                            <li>{{$appeal->user->address}} {{$appeal->user->city}} {{$appeal->user->postalcode}} {{$appeal->user->province}}</li>
                            <li>{{$appeal->user->phone}}</li>
                        </ul>
                    </div>
                    <div class="card-header">Goodiebag contents</div>
                    <div class="card-body">
                        <ul>
                            @foreach($appeal->goodiebag->foods as $food)
                                <li>{{$food->type}}: {{$food->pivot->amount}}</li>
                            @endforeach
                        </ul>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                            <form action="{{route('appeal.changeStatus', $appeal->id)}}" method="POST">
                                @csrf
                                <input type="hidden" name="status" value="1">
                                <button type="submit" class="btn btn-success">Accept Goodiebag</button>
                            </form>
                            <form action="{{route('appeal.changeStatus', $appeal->id)}}" method="POST">
                                @csrf
                                <input type="hidden" name="status" value="3">
                                <button type="submit" class="btn btn-danger">Deny Goodiebag</button>
                            </form>
                        </div>
                    </div>
                </div>
            @else
            @endif
        </div>
    </div>
</div>
@endsection
