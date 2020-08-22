@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @include('partials.errors')
        <div class="col-md-8">
                @if(isset($userStats))
                    @if($userStats->count() != 0)
                        <div class="card-header text-center"><h2>You currently have {{checkIfNull(auth()->user()->treasures) ? '0' : auth()->user()->treasures}} treasures</h2></div>
                        <div class="card-body">
                            {{-- {{dd($userStats->highest_place_ever)}}  --}}
                            <div class="text-center">
                                Your highest place on the leaderboards ever achieved: {{checkIfNull($userStats->highest_place_ever) ? 'Nothing yet, go out there and get number 1' : $userStats->highest_place_ever}}
                            </div>
                            <div class="text-center m-3">
                                Your highest amount of treasures: {{checkIfNull($userStats->highest_number_of_treasures) ? 'You didn\'t acquire any treasures yet! ' : $userStats->highest_number_of_treasures}}
                            </div>
                            <div class="text-center m-3">
                            Total amount of food donated: {{checkIfNull($userStats->total_amount_of_kg_donated) ? 'You haven\'t donated any food yet' : $userStats->total_amount_of_kg_donated . 'kg wow good job!'}}
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
                    @if($foodbankStats->count() != 0)
                        <div class="card-header text-center"><h2>You have received {{checkIfNull($foodbankStats->total_amount_of_kg_donated) ? '0' : $foodbankStats->total_amount_of_kg_donated}}kg of food in total</h2></div>
                        <div class="card-body">
                            <div class="text-center">
                                You have generated a total amount of {{checkIfNull($foodbankStats->amount_of_treasures_generated) ? '0' : $foodbankStats->amount_of_treasures_generated == null }}
                            </div>
                            <div class="text-center">
                                Amount of goodiebags received: {{checkIfNull($foodbankStats->amount_of_goodiebags_received) ? 'You haven\'t reached the leaderboards this week yet' : $foodbankStats->amount_of_goodiebags_received}}
                            </div>
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
@section('script')
<script>
    window.fbAsyncInit = function() {
        FB.init({appId: '1742654069206147', status: true, cookie: true,
        xfbml: true});
    };
    (function() {
        var e = document.createElement('script'); e.async = true;
        e.src = document.location.protocol +
        '//connect.facebook.net/en_US/all.js';
        document.getElementById('fb-root').appendChild(e);
    }());
</script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#fb-share-button').click(function(e){
                e.preventDefault();
                FB.ui(
                {
                    method: 'feed',
                    name: 'This is the content of the "name" field.',
                    link: 'http://www.groupstudy.in/articlePost.php?id=A_111213073144',
                    picture: 'http://www.groupstudy.in/img/logo3.jpeg',
                    caption: 'Top 3 reasons why you should care about your finance',
                    description: "What happens when you don't take care of your finances? Just look at our country -- you spend irresponsibly, get in debt up to your eyeballs, and stress about how you're going to make ends meet. The difference is that you don't have a glut of taxpayers…",
                    message: ""
                });
            });
        });
        </script>
@endsection
