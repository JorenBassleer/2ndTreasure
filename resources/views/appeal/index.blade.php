@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <h2>Personal</h2>
        <table class="table">
            <thead>
                <th scope="col">#</th>
                <th scope="col"></th>
                <th scope="col">To</th>
                <th scope="col">Status</th>
            </thead>
            <tbody>
                {{-- {{dd($user_appeals)}} --}}
                @foreach($user_appeals as $user_appeal)
                    <tr>
                        <th>{{$user_appeal->id}}</th>
                        <th><a href="{{route('appeal.show',$user_appeal->id)}}">View Goodiebag</a></th>
                        <th>{{$user_appeal->foodbank->foodbank_name}}</th>
                        <th {{changeColorToStatus($user_appeal->status->status)}}>{{$user_appeal->status->status}}</th>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @if(count($foodbanks) > 0)
            @foreach($foodbanks as $foodbank)
                <div><h2>{{$foodbank->foodbank_name}}</h2></div>
                @if(!count($foodbank->appeals) > 0)
                    <div class="row">There are no appeals for this foodbank yet</div>
                @else
                <table class="table">
                        <thead>
                            <th scope="col">#</th>
                            <th scope="col"></th>
                            <th scope="col">From</th>
                            <th scope="col">Status</th>
                        </thead>
                        <tbody>
                            @foreach($foodbank->appeals as $appeals)
                                <tr>
                                    <th>{{$appeals->id}}</th>
                                    <th><a href="{{route('appeal.show',$appeals->id)}}">View Goodiebag</a></th>
                                    <th>{{$appeals->user->first_name}} {{$appeals->user->last_name}}</th>
                                    <th {{changeColorToStatus($appeals->status->status)}}>{{$appeals->status->status}}</th>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            @endforeach
        @endif
        </div>
    </div>
</div>

@endsection