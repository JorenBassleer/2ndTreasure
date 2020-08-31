@extends('layouts.app')

@section('content')
<div class="dashboard-index container">
    <div class="row justify-content-center">
        <div class="col-md-10 dashboard-content">
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
                        <div class="text-center">
                            <a href="{{route('leaderboard.index')}}">Look at the leaderboards</a>
                            <div class="card my-3">
                                <div class="card-header">
                                    Amount of food donated last weeks
                                </div>
                                <div class="card-body">
                                    <canvas id="food-donated"></canvas>
                                </div>
                            </div>
                            <div class="card my-3">
                                <div class="card-header">
                                    Amount of people helped last weeks
                                </div>
                                <div class="card-body">
                                    <canvas id="people-helped"></canvas>
                                </div>
                            </div>
                        </div>
                    @else
                        <div>You currently have no stats yet. Once your account has enough activity and stats we will display them here</div>
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
                                <button type='submit' class="button1 mt-4">{{__('Confirm goodiebag received')}}</button>
                            </div>
                        </form>
                    </div>
                    @if($foodbankStats)
                        <div class="text-center">
                            <div class="card my-3">
                                <div class="card-header">
                                    Amount of food received last weeks
                                </div>
                                <div class="card-body">
                                    <canvas id="food-received" ></canvas>
                                </div>
                            </div>
                            <div class="card my-3">
                                <div class="card-header">
                                    Amount of food people helped
                                </div>
                                <div class="card-body">
                                    <canvas id="people-helped" ></canvas>
                                </div>
                            </div>
                            <div class="card my-3">
                                <div class="card-header">
                                    Amount of food goodiebags received
                                </div>
                                <div class="card-body">
                                    <canvas id="goodiebags-received" ></canvas>
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
                        </div>
                        <div class="float-right">
                            {{$pastRecentGoodiebags->links()}}
                        </div>
                    @else
                        <div>No data yet. Once users have donated goodiebags to you over a time of 4 weeks you can track your stats here</div>
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
    var isFoodbank = @json($isFoodbank);
    // Charts for foodbank
    if(isFoodbank == 1) {
        var food = document.getElementById('food-received').getContext('2d');
        var people = document.getElementById('people-helped').getContext('2d');
        var goodiebags = document.getElementById('goodiebags-received').getContext('2d');
        var stats = @json($stats);
        var chart = new Chart(food, {
            // The type of chart we want to create
            type: 'line',

            // The data for our dataset
            data: {
                labels: [@json($fourWeeksAgo), @json($threeWeeksAgo), @json($twoWeeksAgo), @json($oneWeeksAgo)],
                datasets: [{
                    label: 'Kg food received',
                    backgroundColor: 'rgb(0,168,150)',
                    borderColor: 'rgb(0,0,0)',
                    data: [stats[0].amount_of_kg_received, stats[1].amount_of_kg_received, stats[2].amount_of_kg_received, stats[3].amount_of_kg_received],
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
                    label: 'People helped',
                    backgroundColor: 'rgb(0,168,150)',
                    borderColor: 'rgb(0,0,0)',
                    data: [Math.round(stats[0].amount_of_treasures_generated), Math.round(stats[1].amount_of_treasures_generated), Math.round(stats[2].amount_of_treasures_generated), Math.round(stats[3].amount_of_treasures_generated)]
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
                    backgroundColor: 'rgb(0,168,150)',
                    borderColor: 'rgb(0,0,0)',
                    data: [stats[0].amount_of_goodiebags_received, stats[1].amount_of_goodiebags_received, stats[2].amount_of_goodiebags_received, stats[3].amount_of_goodiebags_received]
                }]
            },

            // Configuration options go here
            options: {}
        });
    }
    else {
        var food = document.getElementById('food-donated').getContext('2d');
        var people = document.getElementById('people-helped').getContext('2d');
        var stats = @json($stats);
        var chart = new Chart(food, {
            // The type of chart we want to create
            type: 'line',

            // The data for our dataset
            data: {
                labels: [@json($fourWeeksAgo), @json($threeWeeksAgo), @json($twoWeeksAgo), @json($oneWeeksAgo)],
                datasets: [{
                    label: 'Kg food donated',
                    backgroundColor: 'rgb(0,168,150)',
                    borderColor: 'rgb(0,0,0)',
                    data: [stats[0].amount_of_kg_donated, stats[1].amount_of_kg_donated, stats[2].amount_of_kg_donated, stats[3].amount_of_kg_donated],
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
                    label: 'People helped',
                    backgroundColor: 'rgb(0,168,150)',
                    borderColor: 'rgb(0,0,0)',
                    data: [Math.round(stats[0].number_of_treasures), Math.round(stats[1].number_of_treasures), Math.round(stats[2].number_of_treasures), Math.round(stats[3].number_of_treasures)]
                }]
            },

            // Configuration options go here
            options: {}
        });
    }
});
</script>
@endsection
