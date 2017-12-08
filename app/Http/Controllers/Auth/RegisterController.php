<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Helper;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'full_name' => 'required|max:255',
            'country_code' => 'required|min:0|max:99',
            'phone_number' => 'required|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'full_name' => $data['full_name'],
            'slug' => Helper::slug('full_name'),
            'country_code' => $data['country_code'],
            'phone_number' => $data['phone_number'],
            'password' => bcrypt($data['password']),
            'user_role_id' => 3,
        ]);

        $user->slug = Helper::slug($user->full_name, $user->id);
        $user->save();

        return $user;
    }
    
    //Show view page of register
    public function register()
    {
        $flag = 1;
        return view('register',compact('flag'));
    }
}
