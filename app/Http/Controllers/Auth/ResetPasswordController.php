<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use App\User;
use Validator;
use Illuminate\Http\Request;
use DB;
use Hash;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

     /**
     * Where to redirect users after password reset.
     *
     * @var string
     */
    protected $redirectTo = 'logout';


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function reset(Request $request) {
        $input = $request->input();
        $validator = Validator::make($input, [
            'email' => 'required',
            'password' => 'required',
            'password_confirmation' => 'required',
            'token' => 'required'
        ]);

        if ($validator->fails()) {
            if (count($validator->errors()) <= 1) {
                    return response()->json(['status' => 'exception','response' => $validator->errors()->first()]);   
            } else {
                return response()->json(['status' => 'exception','response' => 'All fields are required']);   
            }
        }
        $pass_reset = DB::table('password_resets')->where('email',$input['email'])->where('token', $input['token'])->first();
        if($pass_reset)
        {
            $user = User::where('email', $input['email'])->first();
            if($user)
            {
                $user->password = Hash::make($input['password']);
                if($user->save())
                {
                    DB::table('password_resets')->where('email',$input['email'])->delete();
                    return redirect('login')->with('success', 'User Password Updated Success Fully');
                }else
                {
                    DB::table('password_resets')->where('email',$input['email'])->delete();
                    return back()->with('error', 'User password could not be updated. Please try again.');
                }
            }else
            {
                DB::table('password_resets')->where('email',$input['email'])->delete();
                return back()->with('error', 'Email Id is not registerd.');
            }
        }else
        {
            return back()->with('error', 'Your token has been expired or Email is invalid.');
        }
    }
}
