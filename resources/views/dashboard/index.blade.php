@extends('layouts.app')

@section('content')
<div class="dashboard-index container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            @include('partials.errors')
            <div class="text-center mb-4">
                <h1>Your dashboard</h1>
            </div>
                @if(isset($userStats))
                    @if($userStats)
                        @if(auth()->user()->isFlagged)
                            <div class="alert alert-danger">
                                <div class="text-center"><h1>You have been flagged as a bad user</h1></div>
                                <div class="text-center">Delete your goodiebags or deliver them. Otherwise you will get removed from our platform</div>
                            </div>
                        @endif
                        <div class="card-header text-center"><h2>You currently have {{checkIfNull(auth()->user()->treasures) ? '0' : auth()->user()->treasures}} treasures</h2></div>
                        <div class="card-body">
                            <div class="text-center">
                                Your highest place on the leaderboards ever achieved: {{checkIfNull($userStats->highest_place_ever) ? 'Nothing yet, go out there and get number 1' : $userStats->highest_place_ever}}
                            </div>
                            <div class="text-center mt-3">
                                <a href="{{route('leaderboard.index')}}"><span class="mx-3"><i class="fa fa-trophy"></i></span>Check out the leaderboards</a>
                            </div>
                            <div class="text-center m-3">
                                Your highest amount of treasures: {{checkIfNull($userStats->highest_number_of_treasures) ? 'You didn\'t acquire any treasures yet! ' : $userStats->highest_number_of_treasures}}
                            </div>
                            <div class="text-center m-3">
                                Total amount of food donated: {{checkIfNull(presentWeightToKg($userStats->total_amount_of_kg_donated, true)) ? 'You haven\'t donated any food yet' : $userStats->total_amount_of_kg_donated . 'kg wow good job!'}}
                            </div>
                             <div> {{-- {{route('code.qr_confirmed',$goodiebag->code)}} --}}
                              <div class="fb-share-button" data-layout="button" data-size="small"><a target="_blank" class="fb-xfbml-parse-ignore"> Share these stats: </a></div>
                            </div>
                        </div>
                    @else
                        <div>You have a total amount of {{$treasures}} treasures</div>
                    @endif
                @endif
                @if(isset($foodbankStats))
                {{-- Form to validate code --}}
                    <div>Confirm the goodiebag you received by entering the code or scanning the QR-code which is displayed on the users device</div>
                    <div class="mb-5">
                        <form action="{{route('code.confirmed')}}" method="POST">
                            @csrf
                            <div class="row w-50 p-3">
                                <label for="code" class="col-form-label">{{__('Enter code: ')}}</label>
                                <input type="text" class="form-control" name="code" id="code">
                                <button type='submit' class="btn btn-primary mt-3">{{__('Confirm goodiebag received')}}</button>
                            </div>
                        </form>
                    </div>
                    @if($foodbankStats)
                        <div class="text-center">
                            <div class="card">
                                <div class="card-header">
                                    Amount of food received last weeks
                                </div>
                                <div class="card-body">
                                    <canvas id="food-received" width="400" height="150"></canvas>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    Amount of food people helped
                                </div>
                                <div class="card-body">
                                    <canvas id="people-helped" width="400" height="150"></canvas>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    Amount of food goodiebags received
                                </div>
                                <div class="card-body">
                                    <canvas id="goodiebags-received" width="400" height="150"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="container mt-5">
                            <div class="text-center mb-2"><h3>Goodiebags you have received in the last 7 days</h3></div>
                            <div class="row mb-4">
                                <div class="col-1">
                                    <strong>#</strong>
                                </div>
                                <div class="col-5">
                                    <strong>Food in goodiebag (kg)</strong> 
                                </div>
                                <div class="col-6">
                                    <strong>User info</strong>
                                </div>
                            </div>
                            @foreach ($pastRecentGoodiebags as $key => $recentGoodiebag)
                                <div class="row mb-2">
                                    <div class="col-1">
                                        {{$key +1}}
                                    </div>
                                    <div class="col-5">
                                        {{presentWeightToKg($recentGoodiebag->total_kg, true)}}
                                    </div>
                                    <div class="col-6">
                                        @if($recentGoodiebag->user != null)
                                            Name: {{$recentGoodiebag->user->name}} <br>
                                            Email: <a href="mailto:{{$recentGoodiebag->user->email}}">{{$recentGoodiebag->user->email}}</a> <br>
                                            Phone: <a href="tel:{{$recentGoodiebag->user->phone}}">{{$recentGoodiebag->user->phone}}</a> <br>
                                        @else
                                            User didn't create an account (yet)
                                        @endif
                                    </div>
                                </div>
                                <hr>
                            @endforeach
                            {{-- {{ \Carbon\Carbon::parse($recentGoodiebag->updated_at)->format('H:i d/m/Y')}} --}}
                        </div>
                        <div class="float-right">
                            {{$pastRecentGoodiebags->links()}}
                        </div>
                    @else
                        <div>No data yet</div>
                    @endif
                @endif
            </div>  
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<script type="text/javascript">

$(document).ready(function() {
    var food = document.getElementById('food-received').getContext('2d');
    var people = document.getElementById('people-helped').getContext('2d');
    var goodiebags = document.getElementById('goodiebags-received').getContext('2d');
    var stats = @json($stats);
    console.log(stats[0].total_amounnt_of_kg_received);

    var chart = new Chart(food, {
        // The type of chart we want to create
        type: 'line',

        // The data for our dataset
        data: {
            labels: [@json($fourWeeksAgo), @json($threeWeeksAgo), @json($twoWeeksAgo), @json($oneWeeksAgo)],
            datasets: [{
                label: 'My First dataset',
                backgroundColor: 'rgb(255, 99, 132)',
                borderColor: 'rgb(255, 99, 132)',
                data: [stats[0].total_amount_of_kg_received, stats[1].total_amount_of_kg_received, stats[2].total_amount_of_kg_received, stats[3].total_amount_of_kg_received],
            }]
        },

        // Configuration options go here
        options: {}
    });
    var chart2 = new Chart(people, {
        // The type of chart we want to create
        type: 'line',

        // The data for our dataset
        data: {
            labels: [@json($fourWeeksAgo), @json($threeWeeksAgo), @json($twoWeeksAgo), @json($oneWeeksAgo)],
            datasets: [{
                label: 'My First dataset',
                backgroundColor: 'rgb(255, 99, 132)',
                borderColor: 'rgb(255, 99, 132)',
                data: [Math.round(stats[0].total_amount_of_treasures_generated), Math.round(stats[1].total_amount_of_treasures_generated), Math.round(stats[2].total_amount_of_treasures_generated), Math.round(stats[3].total_amount_of_treasures_generated)]
            }]
        },

        // Configuration options go here
        options: {}
    });
    var chart3 = new Chart(goodiebags, {
        // The type of chart we want to create
        type: 'line',

        // The data for our dataset
        data: {
            labels: [@json($fourWeeksAgo), @json($threeWeeksAgo), @json($twoWeeksAgo), @json($oneWeeksAgo)],
            datasets: [{
                label: 'My First dataset',
                backgroundColor: 'rgb(255, 99, 132)',
                borderColor: 'rgb(255, 99, 132)',
                data: [stats[0].total_amount_of_goodiebags_received, stats[1].total_amount_of_goodiebags_received, stats[2].total_amount_of_goodiebags_received, stats[3].total_amount_of_goodiebags_received]
            }]
        },

        // Configuration options go here
        options: {}
    });
});
</script>
@endsection
