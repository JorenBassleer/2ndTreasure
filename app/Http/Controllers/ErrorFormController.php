<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Traits\CaptchaTrait;
use Illuminate\Support\Facades\Mail;
use App\Mail\ErrorUserInputMail;

class ErrorFormController extends Controller
{
    use CaptchaTrait;
    public function postForm(Request $request)
    {
        $validator = $this->validateForm($request);
        if(!$validator->passes()) {
            return redirect()->back()
            ->withErrors(['errors'=>$validator->errors()->all()])->withInput();
        }
        // Validate captcha
        $result = $this->checkCaptcha($request['g-recaptcha-response']);
        if(!$result['success']) {
            return back()->withErrors('Captcha failed');
        }

        // Send mail
        try {
            Mail::to('jorenbassleer1997@gmail.com')
            ->send(new ErrorUserInputMail($request->event));
        } catch(Exception $e) {
            return back()->withErrors($e);
        }
        return redirect()->route('landing')->with('success_message', 'Your message has been send to us, thank you');

    }

    protected function validateForm(Request $request) {
        $validator = Validator::make($request->all(), [
            'event' => 'string|required',
            'g-recaptcha-response' => 'required', 
        ],
        // Message if foodbank_id wasn't submitted
        [
            'g-recaptcha-response.required' => 'Captcha failed',
        ]);

        return $validator;
    }
}
