<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use App\User;
use Validator;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Send a reset link to the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getLink(Request $request)
    {
        $input = $request->input();
        $validator = Validator::make($input, [
            'email' => 'required',
        ]);

        if ($validator->fails()) {
            if (count($validator->errors()) <= 1) {
                    return response()->json(['status' => 'exception','response' => $validator->errors()->first()]);   
            } else {
                return response()->json(['status' => 'exception','response' => 'All fields are required']);   
            }
        }

        $user = User::where('email', $request->input('email'))->first();

        if (!$user) {
            return response()->json(['status' => 'failure','response' => 'Please enter a registerd email address.']);
        }

        $this->sendResetLinkEmail($request);

        return response()->json(['status' => 'success', 'response' => "Mail has been sent with password reset link."]);
    }
}
