@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @include('partials.errors')
            <div class="card">
                <div class="card-header">Confirm the goodiebag you received by entering the code or scanning the QR-code which is displayed on the users device</div>
                <div class="card-body">
                    <form action="{{route('code.confirmed')}}" class="form-control" method="POST">
                        @csrf
                        <div class="form-group row">
                            <label for="code" class="col-form-label">{{__('Enter code: (case sensitive)')}}</label>
                            <input type="text" name="code" id="code">
                            <button type='submit' class="btn btn-primary">{{__('Confirm goodiebag received')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection