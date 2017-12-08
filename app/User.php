<?php
namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Auth;
use Validator;
use App\UserBusiness;
use App\Helper;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewRegisterBusiness;
use App\Mail\SendOtp;
use App\Mail\Welcome;
use Image;
use DB;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'salutation','first_name','middle_name','last_name', 'gender', 'country_code', 'mobile_number', 'email', 'password', 'event_password', 'user_role_id', 'slug', 'otp', 'image', 'address', 'city', 'state', 'country', 'pin_code', 'currency', 'security_question_id', 'security_question_ans', 'latitude', 'longitude', 'facebook_token', 'google_token','is_verified'];

    /**
    * The attributes that are updatable.
    *
    * @var array
    */
    public static $updatable = [
        'salutation' => "",'first_name' => "",'middle_name' => "",'last_name' => "", 'gender'=>"", 'password' => "", 'event_password' => "", 'slug' => "", 'email' => "", 'otp' => "" , 'country_code' => "" , 'user_role_id' => "" , 'mobile_number' => "", 'image' => "", 'address' => "", 'city' => "", 'state' => "", 'country' => "", 'pin_code' => "", 'currency' => "", 'security_question_id' => "", 'security_question_ans' => "", 'latitude' => "", 'longitude' => "", 'facebook_token' => "", 'google_token' => "", 'is_verified' => ""];

    /**
    * The attributes that should be hidden for arrays.
    *
    * @var array
    */
    protected $hidden = [
    'password', 'remember_token',];

    public static $downloadable = ['first_name' => '', 'middle_name' => '', 'last_name' => '', 'mobile_number' => "", 'country_code' => ''];

    public function role()
    {
        return $this->belongsTo('App\UserRole', 'user_role_id');
    }

    public function account()
    {
        return $this->belongsTo('App\UserAccountDetail','id', 'user_id');
    }

    public function events()
    {
        return $this->hasMany('App\BusinessEvent','user_id');
    }

    public function security_question()
    {
        return $this->belongsTo('App\SecurityQuestion', 'security_question_id');
    }

    public function apiLogin(Request $request)
    {
        $input = $request->input();
        if($input == NULL)
        {
            return json_encode(['status' => 'exception', 'response' => 'All fields are required']);  
        }else
        {
            foreach ($input as $key => $value) {
                if($value==NULL or $value=="")
                {
                    return json_encode(['status' => 'exception', 'response' => ucwords($key).' is mandetory']);
                }
            }
        }

        $user = $this->where('email', $request->input('email'))->whereIn('user_role_id',[3,4,5])->withTrashed()->first();

        if (!$user){
            return response()->json(['status' => 'exception', 'response' => 'Email id not found. Please register to login!!']);
        }elseif($user->deleted_at!=NULL)
        {
            return response()->json(['status' => 'exception', 'response' => 'Your account is unavailable. Please create another account using different email id to continue.']);
        }else{

            $validator = Validator::make($input, [
                'email' => 'required|email',
                'password' => 'required',
            ]);
            
            if($validator->fails()){
                if(count($validator->errors()) <= 1){
                        return response()->json(['status' => 'exception', 'response' => $validator->errors()->first()]);   
                } else{
                    return response()->json(['status' => 'exception', 'response' =>  'All fields are required']);   
                }
            }

            if ($user->is_blocked) {
                // Authentication passed...
                return response()->json(['status' => 'exception', 'response' => 'Your account is blocked by admin.']);
                
            }else if($user && Hash::check($request->input('password'), $user->password))
            {
                if(!$user->is_verified){
                    $user->otp = rand(1000,9999);
                    $user->ip = $request->ip();
                    if($user->save())
                    {
                        Mail::to($user->email)->send(new SendOtp($user));
                        if( count(Mail::failures()) > 0 ) {
                            return response()->json(['status' => 'failure', 'response' => "Mail Cannot be sent! Please try again!!"]);
                        }else
                        {
                            return response()->json(['status' => 'exception', 'response' => "Email is not verified OTP has been send to your email. Please verify OTP to proceed!."]);
                        }
                    }else
                    {
                        return response()->json(['status' => 'failure', 'response' => 'System Error:OTP not generated .Please try later.']);
                    }
                }elseif (Auth::attempt(['email' => $user->email, 'password' => $request->input('password'), 'is_blocked' => 0])) {

                    /*$user->ip = $request->ip();*/
                    $user->ip = 1;
                    $user->save();
                   
                    $checkBusiness = UserBusiness::whereUserId($user->id)->first();

                    $response = Auth::user();

                    if ($checkBusiness)
                    {
                        /*if($checkBusiness->is_blocked==0)
                        {*/
                            $response['business_id'] = $checkBusiness->id;
                            $checkportfolio = UserPortfolio::whereUserId($user->id)->whereBusinessId($checkBusiness->id)->first();
                            if ($checkportfolio)
                                $response['portfolio_id'] = $checkportfolio->id;
                        /*}else
                        {
                            return response()->json(['status' => 'exception', 'response' => 'Your account is blocked by admin.']);
                        }*/
                    }

                    return response()->json(['status' => 'success', 'response' => $response]);

                }else{
                    return response()->json(['status' => 'failure', 'response' => 'Can not login. Please try again later!!!']);
                }
            }else if(!Hash::check($request->input('password'), $user->password))
            {
                return response()->json(['status' => 'exception', 'response' => 'Invalid email id or password']);
            }
            else{
                return response()->json(['status' => 'failure', 'response' => 'Can not login. Please try again later!!!']);
            }
        }
    }

    public function apiSignup(Request $request)
    {
        $input = $request->input();
        if($input == NULL)
        {
            return json_encode(['status' =>'exception', 'response' => 'All fields are required']);  
        }else
        {
            foreach ($input as $key => $value) {
                if($value==NULL or $value=="")
                {
                    return json_encode(['status' =>'exception', 'response' => ucwords($key).' is mandetory']);
                }
            }
        }

        $user = $this->where('email', $request->input('email'))->whereIn('user_role_id',[3,4])->withTrashed()->first();
        
        if (!$user){
            $name = explode(' ', $input['name']);
            if(count($name)>1 and count($name)==2)
            {
                $input['first_name'] = $name[0];
                $input['last_name'] = $name[1];
            }elseif(count($name)>1 and count($name)==3)
            {
                $input['first_name'] = $name[0];
                $input['middle_name'] = $name[1];
                $input['last_name'] = $name[2];
            }elseif(count($name)>1 and count($name)>3)
            {
                $input['first_name'] = $name[0];
                $input['middle_name'] = $name[1];
                $input['last_name'] = $name[2].' '.$name[3];
            }else
            {
                $input['first_name'] = $input['name'];
            }
            $validator = Validator::make($input, [
                'first_name' => 'required',
                'email' => 'required|email|max:255|unique:users',
                'password' => 'required',
            ]);
            
            if($validator->fails()){
                if(count($validator->errors()) <= 1){
                        return response()->json(['status' => 'exception', 'response' => $validator->errors()->first()]);   
                } else{
                    return response()->json(['status' => 'exception', 'response' =>  'All fields are required']);   
                }
            }
            
            $user['first_name'] = $input['first_name'];
            if(isset($input['middle_name']))
            {
                $user['middle_name'] = $input['middle_name'];
            }
            if(isset($input['last_name']))
            {
                $user['last_name'] = $input['last_name'];
            }
            $user['email'] = $request->input('email');
            /*$user['country_code'] = $request->input('countryCode');*/
            $user['password'] = bcrypt($request->input('password'));
            $user['user_role_id'] = 4;
            $user['otp'] = rand(1000,9999);
            /*$user['ip'] = $request->ip();*/
            $user['ip'] = 1;
            
            $user = array_intersect_key($user, User::$updatable);

            $user = $this->create($user);

            $user['slug'] = Helper::slug($user->first_name, $user->id);

            if($user->save()){
                //Mail::to(config('mail.from')['address'])->send(new NewRegisterBusiness($user));
                Mail::to($user->email)->send(new Welcome($user));
                Mail::to($user->email)->send(new SendOtp($user));
                if( count(Mail::failures()) > 0 ) {
                    return response()->json(['status' => 'failure', 'response' => 'Mail Cannot be sent! Please try again!!']);
                }else
                {
                    return response()->json(['status' => 'success','response' =>  'You have been successfully registered. OTP has been send to your email. Please verify OTP to login']);
                }
            } else {
                return response()->json(['status' => 'failure', 'response' => 'System Error:User could not be created .Please try later.']);
            }
        }elseif ($user->deleted_at!=NULL) {
            return response()->json(['status' => 'exception', 'response' => 'Your account is unavailable. Please create another account using different email id to continue.']);
        } else{
            return response()->json(['status' => 'exception', 'response' => 'Email is already registered. Please sign-in to continue!!']);
        }
    }

    public function apiCheckOtp($input)
    {
        if($input == NULL)
        {
            return json_encode(['status' => 'exception', 'response' => 'All fields are required']);  
        }

        $validator = Validator::make($input, [
            'email' => 'required|email|max:255',
            'otp' => 'required',
        ]);
        
        if($validator->fails()){
            if(count($validator->errors()) <= 1){
                    return response()->json(['status' => 'exception', 'response' => $validator->errors()->first()]);   
            } else{
                return response()->json(['status' => 'exception', 'response' =>  'All fields are required']);   
            }
        }

        $check = $this->where('email', $input['email'])->first();
        if($check)
        { 
            $otp = $this->where('email', $input['email'])->where('otp', $input['otp'])->first();

            if($otp)
            {
                $otp->is_verified = 1;
                $otp->save();

                $checkBusiness = UserBusiness::whereUserId($otp->id)->first();
                
                if ($checkBusiness)
                    $otp['businessId'] = $checkBusiness->id;
                
                return response()->json(['status' => 'success', 'response' => $otp]);
            }else
            {
                return response()->json(['status' => 'exception', 'response' => 'Incorrect Otp. Please enter the correct OTP!!']);
            }
        }else {
            return response()->json(['status' => 'failure', 'response' => 'Email does not exist.']);
        }
    }

    public function apiResendOtp($input)
    {
        if($input == NULL)
        {
            return json_encode(['status' => 'exception', 'response' => 'All fields are required']);  
        }

        $validator = Validator::make($input, [
            'email' => 'required|email|max:255',
        ]);
        
        if($validator->fails()){
            if(count($validator->errors()) <= 1){
                    return response()->json(['status' => 'exception', 'response' => $validator->errors()->first()]);   
            } else{
                return response()->json(['status' => 'exception', 'response' =>  'All fields are required']);   
            }
        }

        $check = $this->where('email', $input['email'])->first();
        if($check)
        { 
            $check->otp = rand(1000,9999);
            if($check->save()){
                Mail::to($check->email)->send(new SendOtp($check));
                if( count(Mail::failures()) > 0 ) {
                    return 3;
                }else{
                    return 1;
                }
            }
            else
            {
                return 2;
            }
        }else {
            return 0;
        }
    }

    public function apiPostUserDetails(Request $request)
    {
        $input = $request->input();

        $validator = Validator::make($input, [
                'userId' => 'required',
                'fullName' => 'string',
                'country_code' => 'string',
                'mobile_number' => 'string'
        ]);

        if($validator->fails()){
            if(count($validator->errors()) <= 1){
                    return response()->json(['status' => 'exception','response' => $validator->errors()->first()]);   
            } else{
                return response()->json(['status' => 'exception','response' => 'All fields are required']);   
            }
        }

        $user = $this->where('id',$input['userId'])->first();

        if($user){

            if(isset($input['image']) && !empty($input['image']))
            {
                $data = $input['image'];

                $img = str_replace('data:image/jpeg;base64,', '', $data);
                $img = str_replace(' ', '+', $img);

                $data = base64_decode($img);

                $fileName = md5(uniqid(rand(), true));

                $image = $fileName.'.'.'png';

                $file = config('image.user_image_path').$image;

                $success = file_put_contents($file, $data);
                    
                $command = 'ffmpeg -i '.config('image.user_image_path').$image.' -vf scale='.config('image.small_thumbnail_width').':-1 '.config('image.user_image_path').'thumbnails/small/'.$image;
                shell_exec($command);

                $command = 'ffmpeg -i '.config('image.user_image_path').$image.' -vf scale='.config('image.medium_thumbnail_width').':-1 '.config('image.user_image_path').'thumbnails/medium/'.$image;
                shell_exec($command);

                $command = 'ffmpeg -i '.config('image.user_image_path').$image.' -vf scale='.config('image.large_thumbnail_width').':-1 '.config('image.user_image_path').'thumbnails/large/'.$image;
                shell_exec($command);
            }
            
            $update = array_intersect_key($input, User::$updatable);

            $update['slug'] = Helper::slug($input['fullName'], $input['userId']);

            $name = explode(' ', $input['fullName']);
            if(count($name)>1 and count($name)==2)
            {
                $update['first_name'] = $name[0];
                $update['last_name'] = $name[1];
                $update['middle_name'] = "";
            }elseif(count($name)>1 and count($name)==3)
            {
                $update['first_name'] = $name[0];
                $update['middle_name'] = $name[1];
                $update['last_name'] = $name[2];
            }elseif(count($name)>1 and count($name)>3)
            {
                $update['first_name'] = $name[0];
                $update['middle_name'] = $name[1];
                $update['last_name'] = $name[2].' '.$name[3];
            }else
            {
                $update['first_name'] = $input['fullName'];
            }

            if(isset($input['country_code']))
            {
                $update['country_code'] = $input['country_code'];
            }

            if(isset($input['mobile_number']))
            {
                $update['mobile_number'] = $input['mobile_number'];
                if($user->mobile_number!=$update['mobile_number'])
                {
                    $update['mobile_verified'] = 0;
                }

            }

            /*$user['first_name'] = $input['fullName'];*/
            
            if(isset($image))
                $update['image'] = $image;

            $user = $this->where('id',$input['userId'])->update($update);

            $response = array();

            $response['response'] = "User details updated successfully.";
            $response['imageName'] = (isset($image)) ? $image :'';
          
            if($user)
                return response()->json(['status' => 'success','response' => $response]);
            else
                return response()->json(['status' => 'failure','response' => "System error:User can not updated successfully.Please try again."]);
        }else{
            return response()->json(['status' => 'exception','response' => "User not found!!"]);
        }
    }

    public function apiGetUserDetails(Request $request)
    {
        $input = $request->input();
        $user = $this->where('id',$input['userId'])->first();
        return $user;
    }

    public function business()
    {
        return $this->hasOne('App\UserBusiness');
    }

    public function socialLogin(Request $request)
    {
        $input = $request->input();
        $user = $this->where('email', 'like' ,"".$input['email']."")->withTrashed()->get()->first();
        if($user and $user->deleted_at==NULL)
        {
            if(isset($input['image']) and ($input['image']!="" or $input['image']!=NULL) and ($user->image=="" or $user->image==NULL))
            {
                $data = base64_encode(file_get_contents($input['image']));

                $img = str_replace('data:image/jpeg;base64,', '', $data);
                $img = str_replace(' ', '+', $img);


                $data = base64_decode($img);

                $fileName = md5(uniqid(rand(), true));
                $image = $fileName.'.'.'png';

                $file = config('image.user_image_path').$image;

                $success = file_put_contents($file, $data);

                $img = Image::make($file);
                    
                $img->resize(config('image.large_thumbnail_width'), null, function($constraint) {
                             $constraint->aspectRatio();
                        })->save(config('image.user_image_path').'/thumbnails/large/'.$image); 

                $img->resize(config('image.medium_thumbnail_width'), null, function($constraint) {
                     $constraint->aspectRatio();
                })->save(config('image.user_image_path').'/thumbnails/medium/'.$image);
                        
                $img->resize(config('image.small_thumbnail_width'), null, function($constraint) {
                     $constraint->aspectRatio();
                })->save(config('image.user_image_path').'/thumbnails/small/'.$image);

                $user->image = $image;
            }
            if($input['type']=="google")
            {
                $user->google_token = $input['token'];
            }else
            {
                $user->facebook_token = $input['token'];
            }
            $user->is_verified = 1;
            $user->ip = $request->ip();
            if($user->save())
            {
                $checkBusiness = UserBusiness::whereUserId($user->id)->first();
                if($checkBusiness)
                {
                    $checkportfolio = UserPortfolio::whereUserId($user->id)->whereBusinessId($checkBusiness->id)->first();
                    if ($checkportfolio)
                    {
                        $user['portfolio_id'] = $checkportfolio->id;
                    }
                    $user['business_id'] = $checkBusiness->id;
                }
                return response()->json(['status' => 'success','response' => $user]);
            }else
            {
                return response()->json(['status' => 'exception', 'response' => 'System Error:User could not be updated .Please try later.']);
            }
        }elseif($user and $user->deleted_at!=NULL)
        {
            return response()->json(['status' => 'exception', 'response' => 'Your account is unavailable. Please create another account using different email id to continue.']);
        }else
        {
            $name = explode(' ', $input['name']);
            if(count($name)>1 and count($name)==2)
            {
                $input['first_name'] = $name[0];
                $input['last_name'] = $name[1];
            }elseif(count($name)>1 and count($name)==3)
            {
                $input['first_name'] = $name[0];
                $input['middle_name'] = $name[1];
                $input['last_name'] = $name[2];
            }elseif(count($name)>1 and count($name)>3)
            {
                $input['first_name'] = $name[0];
                $input['middle_name'] = $name[1];
                $input['last_name'] = $name[2].' '.$name[3];
            }else
            {
                $input['first_name'] = $input['name'];
            }
            $input['user_role_id'] = 4;
            if($input['type']=="google")
            {
                $input['google_token'] = $input['token'];
            }else
            {
                $input['facebook_token'] = $input['token'];
            }
            $input['is_verified'] = 1;

            if(isset($input['image']) and ($input['image']!="" or $input['image']!=NULL))
            {
                $data = base64_encode(file_get_contents($input['image']));

                $img = str_replace('data:image/jpeg;base64,', '', $data);
                $img = str_replace(' ', '+', $img);


                $data = base64_decode($img);

                $fileName = md5(uniqid(rand(), true));
                $image = $fileName.'.'.'png';

                $file = config('image.user_image_path').$image;

                $success = file_put_contents($file, $data);

                $img = Image::make($file);
                    
                $img->resize(config('image.large_thumbnail_width'), null, function($constraint) {
                             $constraint->aspectRatio();
                        })->save(config('image.user_image_path').'/thumbnails/large/'.$image); 

                $img->resize(config('image.medium_thumbnail_width'), null, function($constraint) {
                     $constraint->aspectRatio();
                })->save(config('image.user_image_path').'/thumbnails/medium/'.$image);
                        
                $img->resize(config('image.small_thumbnail_width'), null, function($constraint) {
                     $constraint->aspectRatio();
                })->save(config('image.user_image_path').'/thumbnails/small/'.$image);
                $input['image'] = $image;
            }
            $user = array_intersect_key($input, User::$updatable);
            
            $user = $this->create($user);

            $user['slug'] = Helper::slug($user->first_name, $user->id);

            $user->ip = $request->ip();

            if($user->save()){
                //Mail::to(config('mail.from')['address'])->send(new NewRegisterBusiness($user));
                //Mail::to($user->email)->send(new SendOtp($user));
                Mail::to($user->email)->send(new Welcome($user));
                if( count(Mail::failures()) > 0 ) {
                    return response()->json(['status' => 'exception', 'response' => 'Mail Cannot be sent! Please try again!!']);
                }else
                {
                    $user = User::select("*")->whereId($user->id)->first();
                    return response()->json(['status' => 'success','response' => $user]);
                }
            } else {
                return response()->json(['status' => 'failure', 'response' => 'System Error:User could not be created .Please try later.']);
            }
        }
    }
}