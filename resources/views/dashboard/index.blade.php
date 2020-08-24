@extends('layouts.app')

@section('content')
<div class="container">
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
                                <div class="text-center">Delete your goodiebags or deliver them. Otherwise you will get removed from our platform if you don't deliver your goodiebags</div>
                            </div>
                        @endif
                        <div class="card-header text-center"><h2>You currently have {{checkIfNull(auth()->user()->treasures) ? '0' : auth()->user()->treasures}} treasures</h2></div>
                        <div class="card-body">
                            {{-- {{dd($userStats->highest_place_ever)}}  --}}
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
                                <label for="code" class="col-form-label">{{__('Enter code: (case sensitive)')}}</label>
                                <input type="text" class="form-control" name="code" id="code">
                                <button type='submit' class="btn btn-primary mt-3">{{__('Confirm goodiebag received')}}</button>
                            </div>
                        </form>
                    </div>
                    @if($foodbankStats)
                        <div class="card-header text-center"><h2>You have received {{presentWeightToKg($foodbankStats->total_amount_of_kg_received, true)}} of food in total</h2></div>
                        <div class="card-body">
                            <div class="text-center">
                                You have generated a total amount of {{pointToComma($foodbankStats->total_amount_of_treasures_generated)}} treasures
                            </div>
                            <div class="text-center">
                                Amount of goodiebags received: {{$foodbankStats->total_amount_of_goodiebags_received}}
                            </div>
                        </div>
                        <div class="container mt-5">
                            <div class="text-center mb-2"><h3>Goodiebags you have received</h3></div>
                            <div class="text-center mb-4"> Help us by giving feedback of the users</div>
                            <div class="row mb-4">
                                <div class="col-1">
                                    <strong>#</strong>
                                </div>
                                <div class="col-3">
                                    <strong>Food in goodiebag (kg)</strong> 
                                </div>
                                <div class="col-4">
                                    <strong>User info</strong>
                                </div>
                                <div class="col-2 col-sm-6 rating-title">
                                    <strong>Give rating</strong>
                                </div>
                            </div>
                            @foreach ($pastRecentGoodiebags as $key => $recentGoodiebag)
                                <div class="row mb-2">
                                    <div class="col-1">
                                        {{$key +1}}
                                    </div>
                                    <div class="col-3">
                                        {{presentWeightToKg($recentGoodiebag->total_kg, true)}}
                                    </div>
                                    <div class="col-4 col-sm-6">
                                        @if($recentGoodiebag->user != null)
                                            Name: {{$recentGoodiebag->user->name}} <br>
                                            Email: <a href="mailto:{{$recentGoodiebag->user->email}}">{{$recentGoodiebag->user->email}}</a> <br>
                                            Phone: <a href="tel:{{$recentGoodiebag->user->phone}}">{{$recentGoodiebag->user->phone}}</a> <br>
                                        @else
                                            User didn't create an account (yet)
                                        @endif
                                    </div>
                                    <div class="col-2">
                                        <div class="rating" data-id={{$recentGoodiebag->id}}>
                                            <form action=" ">
                                                <div class="rating">
                                                    <span value="1">☆</span><span value="2">☆</span><span value="3">☆</span><span value="4">☆</span><span value="5">☆</span>
                                                </div>
                                            </form>
                                        </div>
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
{{-- <script>
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
</script> --}}

<script type="text/javascript">
    // For adding the token to axios header (add this only one time).
    var token = document.head.querySelector('meta[name="csrf-token"]');
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;

    (function(){
            const classname = document.querySelectorAll('.rating')

            Array.from(classname).forEach(function(element) {
                element.addEventListener('change', function() {
                    const id = element.getAttribute('data-id')
                    axios.patch(`goodiebag/${id}`, {
                        quantity: this.value
                    })
                    .then(function (response) {
                        // console.log(response);
                        
                    })
                    .catch(function (error) {
                        // console.log(error);
                        
                    });
                })
            })
        })();
</script>
@endsection
