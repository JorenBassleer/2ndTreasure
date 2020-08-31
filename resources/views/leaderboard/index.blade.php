@extends('layouts.app')

@section('content')
<div class="container leaderboard-page">
    <div class="row justify-content-center">
        <div class="col-md-10">
            @include('partials.errors')
            <h2 class="title title-week">Leaderboard this week</h2>
                <div class="row mt-3">
                   <div class="col-2">
                       <strong>#</strong>
                    </div>
                    <div class="col-8">
                        <strong>Name</strong>
                     </div>
                     <div class="col-2">
                        <strong>Donated</strong>
                     </div>
                </div>
                @foreach($this_week as $key => $row)
                    <div class="row">
                        <div class="col-2">{{$key + 1 }}</div>
                        <div class="col-8">{{$row->user->name}}</div>
                        <div class="col-2">{{presentWeightToKg($row->amount_of_kg, 1)}}</div>
                    </div>
                @endforeach
                <h2 class="title title-all-time">Leaderboard of all time</h2>
                <div class="row mt-3">
                    <div class="col-2">
                        <strong>#</strong>
                     </div>
                     <div class="col-8">
                         <strong>Name</strong>
                      </div>
                      <div class="col-2">
                         <strong>Donated</strong>
                      </div>
                 </div>
                @foreach($all_time as $key => $row)
                    <div class="row">
                        <div class="col-2">{{$key + 1 }}</div>
                        <div class="col-8">{{$row->user->name}}</div>
                        <div class="col-2">{{presentWeightToKg($row->amount_of_kg, 1)}}</div>
                    </div>
                @endforeach  
            </div>
        </div>
    </div>
    {{$this_week->links()}}
</div>
@endsection
