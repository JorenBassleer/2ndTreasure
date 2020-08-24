@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2 class="text-center">Oops! It seems like we broke something</h2>
            <div class="text-center mt-5">
                Fill this form describing how this happened. We thank you a lot for this<br>
                We will try to fix this issue as fast as possible!
            </div>
            <div class="text-center">
                You can also leave a rant if this is really bugging you
            </div>
            <form action="{{route('post.form_error')}}" method="POST" id="foodbank-form">
                @csrf
                <div class="form-row justify-content-center">
                    <div class="col-md-9 mb-4 mt-4">
                        <label for="event">How did this happen:</label>
                        <textarea name="event" row="6" cols="6" class="form-control" id="foodbank_name" required></textarea>
                    </div>
                </div>
                <div class="form-row justify-content-center">        
                    <div class="g-recaptcha mb-4" data-sitekey="6LcPL8IZAAAAAPWoYJcwYZsFaUPTZD_bdkwAAy2j"></div>
                </div>
                <div class="form-row justify-content-center">
                    <div class="text-center">
                        <button class="btn btn-primary" id="form-btn">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection