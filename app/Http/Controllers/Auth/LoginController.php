<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Exceptions\SocialAuthException;

use App\User;
use App\Mail\SendOtp;
use App\Mail\Welcome;
use Exception;
use Socialite;
use Validator;
use Auth;
use Session;
use Image;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
    use AuthenticatesUsers;
    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }
    public function login(Request $request)
    {
        $user = User::whereEmail($request->email)->withTrashed()->first();

        if ($user and $user->deleted_at == NULL) {
            if ($user && Hash::check($request->password, $user->password)) {
                if ($user->user_role_id == 3 || $user->user_role_id == 5) {
                    if ($user->is_blocked == 0) {
                        if ($user->is_verified == 1) {
                            /*if($user->ip==$request->ip())*/
                            if ($user->ip == 0) {
                                $business = $user->business;
                                if ($business->is_blocked == 0) {
                                    if (Auth::attempt(['email' => $request->email,'password' => $request->password])) {
                                        if (Auth::check()) {
                                            if (Auth::user()->business->is_identity_proof_validate && Auth::user()->business->is_business_proof_validate) {
                                                return redirect()->intended('register-business/'.$user->id);
                                            } else {
                                                return redirect()->intended('upload');
                                            }
                                        } else {
                                            return redirect('login')->with('error', 'Something goes wrong. Please try again!');
                                        }
                                    } else {
                                        return redirect()->back()->withErrors(['password' => 'Credential dos\'nt match!']);
                                    }
                                } else {
                                    return redirect('login')->with('error', 'You cannot login to the dashboard. Your Business has been blocked by the Admin.');
                                }
                            } else {
                                if ($user->security_question_id!=null and $user->security_question_id!="") {
                                    Session::put('is_login', true);
                                    Session::put('email', $user->email);
                                    Session::put('password', $request->password);

                                    return redirect('verifySecurity')->with('success', 'Please answer the following list to verify your email to proceed to logged in!');
                                } else {
                                    return redirect('login')->with('error', 'No security question is added in your account. Please add a security question to proceed.');
                                }
                            }
                        } else {
                            Session::put('is_login', true);
                            Session::put('mobile_number', $user->mobile_number);
                            Session::put('email', $user->email);
                            Session::put('password', $request->password);
                            Session::put('otp', rand(1000,9999));
                            $user->otp = Session::get('otp');
                            $user->save();

                            Mail::to($user->email)->send(new SendOtp($user));

                            if (count(Mail::failures()) > 0 ) {

                               return redirect('emailVerify')->with('warning', 'Mail Cannot be sent! Please try to resend the OTP!');

                               foreach(Mail::failures as $email_address) {
                                   echo " - $email_address <br />";
                                }

                            } else {
                                return redirect('emailVerify')->with('success', 'Please enter the OTP to verify your email to proceed to logged in! OTP has been sent to '.$user->email.'.Please enter the OTP!');
                            }
                        }
                    } else {
                        return redirect('login')->with('error', 'Your Account has been blocked by Admin. Please contact Admin to unblock your account.');
                    }
                } else {
                    return redirect('login')->with('error', 'You are not authorized to access!');
                }
            } else {
                return redirect()->back()->withErrors(['password' => 'Please enter a Valid Password']);
            }
        } elseif ($user and $user->deleted_at != NULL) {
            return redirect('login')->with('error', 'Your account is unavailable. Please create another account using different email id to continue.');
        } else {
            return redirect()->back()->withErrors(['email' => 'Email does not match']);
        }
    }

    /**
     * Redirect the user to the OAuth Provider.
     *
     * @return Response
     */
    public function redirectToProvider($provider)
    {  
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from provider.  Check if the user already exists in our
     * database by looking up their provider_id in the database.
     * If the user exists, log them in. Otherwise, create a new user then log them in. After that 
     * redirect them to the authenticated users homepage.
     *
     * @return Response
     */
    public function handleProviderCallback($provider, Request $request)
    {   
        if (!$request->has('code') || $request->has('denied')) {
            return redirect('/');
        }
        
        try {

            $user = Socialite::driver($provider)->stateless()->user();

        } 
        catch (Exception $e) {
            
            return redirect ('/');
        }

        if($user->email == null)
        {   
            return redirect('message');
        }

        $user = $this->findOrCreateUser($user, $provider);
        
        if ($user->user_role_id == 4) {
            Mail::to($user->email)->send(new Welcome($user));
            Auth::login($user, true);
            return redirect('create-business')->with('alert', 'First Create your business then continue with site');
        } else {
            if ($user and $user->deleted_at == NULL) {
            
                if ($user->user_role_id == 3 || $user->user_role_id == 5) {
                    if ($user->is_blocked == 0 && $user->is_verified == 1) {
                    
                            /*if($user->ip==$request->ip())*/
                           /* if ($user->ip == 0) {*/
                                $business = $user->business;
                                if ($business->is_blocked == 0) {
                                        Auth::login($user, true);
                                        if (Auth::check()) {
                                            if (Auth::user()->business->is_identity_proof_validate && Auth::user()->business->is_business_proof_validate) {
                                                return redirect()->intended('register-business/'.$user->id);
                                            } else {
                                                return redirect()->intended('upload');
                                            }
                                        } else {
                                            return redirect('login')->with('error', 'Something goes wrong. Please try again!');
                                        }
                                    
                                } else {
                                    return redirect('login')->with('error', 'You cannot login to the dashboard. Your Business has been blocked by the Admin.');
                                }
                            /*} else {
                                if ($user->security_question_id!=null and $user->security_question_id!="") {
                                    Session::put('is_login', true);
                                    Session::put('email', $user->email);
                                    Session::put('password', $user->password);

                                    return redirect('verifySecurity')->with('success', 'Please answer the following list to verify your email to proceed to logged in!');
                                } else {
                                    return redirect('login')->with('error', 'No security question is added in your account. Please add a security question to proceed.');
                                }
                            }*/
                        
                    } else {
                        return redirect('login')->with('error', 'Your Account has been blocked by Admin. Please contact Admin to unblock your account.');
                    }
                } else {
                    return redirect('login')->with('error', 'You are not authorized to access!');
                }
            
            } elseif ($user and $user->deleted_at != NULL) {
                return redirect('login')->with('error', 'Your account is unavailable. Please create another account using different email id to continue.');
            } else {
                return redirect()->back()->withErrors(['email' => 'Email does not match']);
            }
        }
        
    }

    /**
     * If a user has registered before using social auth, return the user
     * else, create a new user object.
     * @param  $user Socialite user object
     * @param $provider Social auth provider
     * @return  User
     */
    public function findOrCreateUser($user, $provider)
    {  
        
        if ($provider == "facebook") {
            $authUser = User::where('email', $user->email)->orWhere('facebook_token', $user->id)->withTrashed()->first();
            if (isset($authUser) && $authUser->facebook_token == null) {
                User::whereEmail($user->email)->update(['facebook_token' => $user->id]);
            }
        } 
        if ($provider == "google") {
            $authUser = User::where('email', $user->email)->orWhere('email', 'google_token', $user->id)->withTrashed()->first();
            if (isset($authUser) && $authUser->google_token == null) {
                User::whereEmail($user->email)->update(['google_token' => $user->id]);
            }
        }
    
        if ($authUser) {
            return $authUser;
        } else {

            $input['user_role_id'] = 4;
            $name = explode(' ', $user->name);
            $input['first_name'] = $name[0];
            $input['last_name'] = (isset($name[1])) ? $name[1]:'';
            $input['gender'] = (isset($user->user['gender'])) ? $user->user['gender']:'' ;
            $input['email'] = $user->email;
            $input['is_verified'] = 1; 

            if ($provider == "facebook") {
                $input['facebook_token'] = $user->id;   
            } else {
                $input['google_token'] = $user->id;
            }

            if (isset($user->avatar_original) and ($user->avatar_original!="" or $user->avatar_original!=NULL)) {

                $path = $user->avatar_original;

                $filename = basename($path);

                $img = Image::make($path);

                $img->resize(config('image.large_thumbnail_width'), null, function($constraint) {
                             $constraint->aspectRatio();
                        })->save(config('image.user_image_path').$filename); 
                    
                $img->resize(config('image.large_thumbnail_width'), null, function($constraint) {
                             $constraint->aspectRatio();
                        })->save(config('image.user_image_path').'/thumbnails/large/'.$filename); 

                $img->resize(config('image.medium_thumbnail_width'), null, function($constraint) {
                     $constraint->aspectRatio();
                })->save(config('image.user_image_path').'/thumbnails/medium/'.$filename);
                        
                $img->resize(config('image.small_thumbnail_width'), null, function($constraint) {
                     $constraint->aspectRatio();
                })->save(config('image.user_image_path').'/thumbnails/small/'.$filename);

                $input['image'] = $filename;
            }

        }

        return User::create($input);

    }

    public function providerMessage()
    {
        $message = "We are sorry for those user , who don't have email id, please add email id in your account and come back to us to register.";
        return view('error-page',compact('message'));
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->intended('/');
    }
}
