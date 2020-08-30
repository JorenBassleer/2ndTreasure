@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
        <h2 class="text-center">Foodbank application</h2>

            @include('partials.errors')
            <form action="{{route('foodbank.post_form')}}" method="POST" id="foodbank-form">
                @csrf
                <div class="form-row">
                    <div class="col-md-6 mb-4">
                        <label for="name">Name of your foodbank</label>
                        <input name="foodbank_name" type="name" class="form-control" id="foodbank_name" aria-describedby="emailHelp" placeholder="Enter name" required>
                    </div>        
                    <div class="col-md-6 mb-4">
                        <label for="email">Email address</label>
                        <input name="foodbank_email" type="email" class="form-control" id="foodbank_email" aria-describedby="emailHelp" placeholder="Enter email" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-6 mb-4">
                        <label for="address">Address</label>
                        <input name="foodbank_address" type="text" class="form-control" id="foodbank_address" placeholder="Address" required>
                    </div>
                    <div class="col-md-6 mb-4">
                        <label for="postalcode">Postalcode</label>
                        <input name="foodbank_postalcode" type="text" class="form-control" id="foodbank_postalcode" placeholder="Postalcode"required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-4 mb-4">
                        <label for="city">City</label>
                        <input name="foodbank_city" type="text" class="form-control" id="foodbank_city" placeholder="City:"required>
                    </div>
                    <div class="col-md-4 mb-4">
                        <label for="province">Province</label>
                        <input name="foodbank_province" type="text" class="form-control" id="foodbank_province" placeholder="Province:"required>
                    </div>
                    <div class="col-md-4 mb-4">
                        <label for="country">Country</label>
                        <input name="foodbank_country" type="text" class="form-control" id="foodbank_country" placeholder="Country:"required>
                    </div>
                </div>
                  <div class="form-group">
                    <label for="phone">Phone number:</label>
                    <input name="foodbank_phone" type="tel" class="form-control" id="foodbank_phone" placeholder="Phone number"required>
                  </div>
                  <div class="g-recaptcha mb-4" data-sitekey="6LcPL8IZAAAAAPWoYJcwYZsFaUPTZD_bdkwAAy2j"></div>
                  <div class="text-center">
                    <button class="btn btn-primary" id="form-btn">Submit</button>
                  </div>
            </form>
        </div>
    </div>
</div>
@endsection