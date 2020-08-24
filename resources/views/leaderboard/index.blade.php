@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            @include('partials.errors')
            <div class="display-4">Leaderboard this week</div>
                <div class="row mt-3">
                   <div class="col">
                       <strong>#</strong>
                    </div>
                    <div class="col">
                        <strong>Name</strong>
                     </div>
                     <div class="col">
                        <strong>Donated</strong>
                     </div>
                </div>
                @foreach($this_week as $key => $row)
                    <div class="row">
                        <div class="col">{{$key + 1 }}</div>
                        <div class="col">{{$row->user->name}}</div>
                        <div class="col">{{presentWeightToKg($row->amount_of_kg, 1)}}</div>
                    </div>
                @endforeach
                <div class="display-4">Leaderboard of all time</div>
                <div class="row mt-3">
                    <div class="col">
                        <strong>#</strong>
                     </div>
                     <div class="col">
                         <strong>Name</strong>
                      </div>
                      <div class="col">
                         <strong>Donated</strong>
                      </div>
                 </div>
                @foreach($all_time as $key => $row)
                    <div class="row">
                        <div class="col">{{$key + 1 }}</div>
                        <div class="col">{{$row->user->name}}</div>
                        <div class="col">{{presentWeightToKg($row->amount_of_kg, 1)}}</div>
                    </div>
                @endforeach  
            </div>
        </div>
    </div>
    {{$this_week->links()}}
</div>
@endsection
