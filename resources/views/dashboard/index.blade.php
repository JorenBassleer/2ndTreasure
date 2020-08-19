@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @include('partials.errors')
        <div class="col-md-8">
                @if(isset($userStats))
                    @if($userStats != null)
                        <div class="card-header text-center"><h2>You currently have {{checkIfNull(auth()->user()->treasures) ? '0' : auth()->user()->treasures}} treasures</h2></div>
                        <div class="card-body">
                            <div class="text-center">
                                Your highest place on the leaderboards ever achieved: {{checkIfNull($userStats->highest_place_ever) ? 'Nothing yet, go out there and get number 1' : $userStats->highest_place_ever == null }}
                            </div>
                            <div class="text-center">
                                Your highest place this week: {{checkIfNull($userStats->highest_place_this_week) ? 'You haven\'t reached the leaderboards this week yet' : $userStats->highest_place_this_week}}
                            </div>
                            <div class="text-center m-3">
                                Your highest amount of treasures: {{checkIfNull($userStats->highest_number_of_treasures) ? 'You didn\'t acquire any treasures yet! ' : $userStats->highest_number_of_treasures}}
                            </div>
                            <div class="text-center m-3">
                            Total amount of food donated: {{checkIfNull($userStats->total_amount_of_kg_donated) ? 'You haven\'t donated any food yet' : $userStats->total_amount_of_kg_donated . 'kg wow good job!'}}
                            </div>
                        </div>
                @endif
                @if(isset($foodbankStats))
                    @elseif($foodbankStats != null)
                        <div class="card-header text-center"><h2>You have received {{checkIfNull($foodbankStats->total_amount_of_kg_donated) ? '0' : $foodbankStats->total_amount_of_kg_donated}}kg of food in total</h2></div>
                        <div class="card-body">
                            <div class="text-center">
                                You have generated a total amount of {{checkIfNull($foodbankStats->amount_of_treasures_generated) ? '0' : $foodbankStats->amount_of_treasures_generated == null }}
                            </div>
                            <div class="text-center">
                                Amount of goodiebags received: {{checkIfNull($foodbankStats->amount_of_goodiebags_received) ? 'You haven\'t reached the leaderboards this week yet' : $foodbankStats->amount_of_goodiebags_received}}
                            </div>
                        </div>
                    @endif
                @endif
                    <div>No data yet</div>
                </div>
            </div>  
        </div>
    </div>
</div>
@endsection
