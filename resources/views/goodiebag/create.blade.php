@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create a goodiebag for a foodbank</div>
                <div class="card-body">
                    <div>Help those who need it and give a 2ndTreasure goodiebag to a foodbank</div>
                    <form action="{{route('goodiebag.store')}}" method="POST">
                        @csrf
                        @foreach($foods as $food)
                            <div class="form-group row">
                                <label for="{{($food->id)}}" class="col-md-4 col-form-label text-md-right">{{ __(str_replace('_', ' ' ,$food->type)) }}</label>
                                <div class="col-md-6">
                                    <input id="food_input" type="text" class="form-control @error($food->id) is-invalid @enderror" name="{{$food->type}}" value="{{ old($food->type) }}" autocomplete="{{foodBackend($food->type)}} " autofocus>
                                    @error($food->type)
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        @endforeach
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Create goodiebag') }}
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
