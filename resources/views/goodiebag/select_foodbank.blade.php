@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @include('partials.errors')
            <div class="card">
                <div class="card-header">In your goodiebag:</div>
                <div class="card-body">
                    @foreach($goodiebag->foods  as $food)
                        <div class="form-group row">
                            <label for="{{($food->id)}}" class="col-md-3 col-form-label text-md-right">{{ __(str_replace('_', ' ' ,$food->type)) }}</label>
                            <div class="col-md-6 form-control">
                                {{ $food->pivot->amount }}
                            </div>
                        </div>
                    @endforeach
                        <form action="{{route('appeal.store')}}" method="POST">
                                @csrf
                                <select name="foodbank_name" class="custom-select custom-select-lg mb-3">
                                    <option selected>Select a foodbank</option>
                                    @foreach ($foodbanks as $foodbank)
                                        <option value="{{$foodbank->foodbank_name}}">{{$foodbank->foodbank_name}}</option>
                                    @endforeach
                                </select>
                                <input type="hidden" name="goodiebag_id" value="{{$goodiebag->id}}">
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Select foodbank') }}
                                    </button>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
