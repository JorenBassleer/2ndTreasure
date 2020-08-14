@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Add foodbank</div>

                <div class="card-body">
                    <form action="{{route('foodbank.store')}}" method="POST">
                        @csrf
                        <div class="form-group row">
                            <label for="foodbank_name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="foodbank_name" type="text" class="form-control @error('foodbank_name') is-invalid @enderror" name="foodbank_name" value="{{ old('foodbank_name') }}" required autocomplete="foodbank_name" autofocus>

                                @error('foodbank_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="foodbank_email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="foodbank_email" type="email" class="form-control @error('foodbank_email') is-invalid @enderror" name="foodbank_email" value="{{ old('foodbank_email') }}" required autocomplete="foodbank_email">

                                @error('foodbank_email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="foodbank_address" class="col-md-4 col-form-label text-md-right">{{ __('Address') }}</label>

                            <div class="col-md-6">
                                <input id="foodbank_address" type="foodbank_address" class="form-control @error('foodbank_address') is-invalid @enderror" name="foodbank_address" value="{{ old('foodbank_address') }}" required autocomplete="foodbank_address">

                                @error('foodbank_address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="foodbank_city" class="col-md-4 col-form-label text-md-right">{{ __('City') }}</label>

                            <div class="col-md-6">
                                <input id="foodbank_city" type="foodbank_city" class="form-control @error('foodbank_city') is-invalid @enderror" name="foodbank_city" value="{{ old('foodbank_city') }}" required autocomplete="foodbank_city">

                                @error('foodbank_city')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="foodbank_postalcode" class="col-md-4 col-form-label text-md-right">{{ __('Postalcode') }}</label>

                            <div class="col-md-6">
                                <input id="foodbank_postalcode" type="foodbank_postalcode" class="form-control @error('foodbank_postalcode') is-invalid @enderror" name="foodbank_postalcode" value="{{ old('foodbank_postalcode') }}" required autocomplete="foodbank_postalcode">

                                @error('foodbank_postalcode')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="foodbank_province" class="col-md-4 col-form-label text-md-right">{{ __('Province') }}</label>

                            <div class="col-md-6">
                                <input id="foodbank_province" type="foodbank_province" class="form-control @error('foodbank_province') is-invalid @enderror" name="foodbank_province" value="{{ old('foodbank_province') }}" required autocomplete="foodbank_province">

                                @error('foodbank_province')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="foodbank_phone" class="col-md-4 col-form-label text-md-right">{{ __('Phone') }}</label>

                            <div class="col-md-6">
                                <input id="foodbank_phone" type="foodbank_phone" class="form-control @error('foodbank_phone') is-invalid @enderror" name="foodbank_phone" value="{{ old('foodbank_phone') }}" required autocomplete="foodbank_phone">

                                @error('foodbank_phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="company_number" class="col-md-4 col-form-label text-md-right">{{ __('Company Number') }}</label>

                            <div class="col-md-6">
                                <input id="company_number" type="company_number" class="form-control @error('company_number') is-invalid @enderror" name="company_number" value="{{ old('company_number') }}" required autocomplete="company_number">

                                @error('company_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="details" class="col-md-4 col-form-label text-md-right">{{ __('Details') }}</label>

                            <div class="col-md-6">
                                <input id="details" type="textarea" class="form-control @error('details') is-invalid @enderror" name="details" value="{{ old('details') }}" required autocomplete="details">

                                @error('details')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Add foodbank') }}
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
