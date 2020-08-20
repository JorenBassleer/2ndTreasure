@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @include('partials.errors')
            <div>
                <div>
                    <table>
                        <thead>
                            <p class="h2">Leaderboard this week</p>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Kg of food donated</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($this_week as $key => $row)
                                <tr>
                                    <th scope="row">{{$key + 1 }}</th>
                                    <td>{{$row->user->name}}</td>
                                    <td>{{$row->amount_of_kg}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div>
                    <table>
                        <thead>
                            <p class="h2">Leaderboard of all time</p>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Kg of food donated</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($all_time as $key => $row)
                                <tr>
                                    <th scope="row">{{$key + 1 }}</th>
                                    <td>{{$row->user->name}}</td>
                                    <td>{{$row->amount_of_kg}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{$this_week->links()}}
</div>
@endsection
