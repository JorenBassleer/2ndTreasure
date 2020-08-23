@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
        <h2 class="text-center">Foodbank application</h2>

            @include('partials.errors')
            <form action="{{route('post.form_foodbank')}}" method="POST" id="foodbank-form">
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
@section('scripts')
    <script>
        var button = document.getElementById('form-btn');
        button.addEventListener('click', function() {
            var response = grecaptcha.getResponse();

            //reCaptcha not verified
            if(response.length == 0) {
                console.log('hehe');
            }
            //reCaptch verified
            else {
                console.log('on');
            }
            const captchaResponse = response;
            var bodyFormData = new FormData();
            bodyFormData.append('foodbank_name', document.getElementById('foodbank_name').value);
            bodyFormData.append('foodbank_email', document.getElementById('foodbank_email').value);
            bodyFormData.append('foodbank_address', document.getElementById('foodbank_address').value);
            bodyFormData.append('foodbank_postalcode', document.getElementById('foodbank_postalcode').value);
            bodyFormData.append('foodbank_city', document.getElementById('foodbank_city').value);
            bodyFormData.append('foodbank_province', document.getElementById('foodbank_province').value);
            bodyFormData.append('foodbank_country', document.getElementById('foodbank_country').value);
            bodyFormData.append('foodbank_phone', document.getElementById('foodbank_phone').value);
            bodyFormData.append('g-recaptcha-response', response);
            axios.post(`foodbank/form`, {
                data: bodyFormData,
                headers: {'Content-Type': 'multipart/form-data' }
            })
            .then(function (response) {
                // console.log(response);
                window.location.href="{{ route('show.form_foodbank') }}"
            })
            .catch(function (error) {
                // console.log(error);
                window.location.href="{{ route('show.form_foodbank') }}"
            });
        })
    </script>
@endsection