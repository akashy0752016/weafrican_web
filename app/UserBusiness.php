<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use App\User;
use App\UserPortfolioImage;
use App\UserSubscriptionPlan;
use App\Mail\NewRegisterBusiness;
use App\Mail\AdminMail;
use Carbon\Carbon;
use Validator;
use Auth;
use DB;
use Image;

class UserBusiness extends Model
{
    protected $fillable = ['user_id', 'business_id', 'bussiness_category_id', 'bussiness_subcategory_id', 'title' ,'keywords', 'about_us', 'website', 'working_hours' , 'is_agree_to_terms', 'identity_proof' , 'business_proof' , 'business_logo', 'banner', 'is_update'];

    public static $updatable = ['user_id' => "", 'business_id' => "" ,'bussiness_category_id' => "", 'bussiness_subcategory_id' => "", 'title' => "", 'keywords' => "", 'about_us' => "", 'website' => "", 'working_hours' => "", 'is_agree_to_terms' => "" ,'identity_proof' => "" ,'business_proof' => "", 'business_logo' => "", 'banner' => "", 'is_update' => ""];

    public static $searchValidator = array(
        'userId' => 'required',
        'city' => 'required',
        'state' => 'required',
        'country' => 'required',
        'index' => 'required',
        'limit' => 'required',
        'term' => 'required',
        'categoryId' => 'numeric',
        'subcategoryID' => 'numeric',
        'timestamp' => 'required',
        'timezone' => 'sometimes|required',
    );

    public function user()
    {
        return $this->belongsTo('App\User')->withTrashed();
    }

    public function category()
    {
        return $this->belongsTo('App\BussinessCategory','bussiness_category_id');
    }

    public function subcategory()
    {
        return $this->belongsTo('App\BussinessCategory','bussiness_subcategory_id');
    }

    public function events()
    {
        return $this->hasMany('App\BusinessEvent','business_id');
    }

    public function products()
    {
        return $this->hasMany('App\BusinessProduct','business_id');
    }

    public function services()
    {
        return $this->hasMany('App\BusinessService','business_id');
    }

    public function videos()
    {
        return $this->hasMany('App\BusinessVideo','business_id');
    }
    
    public function likes()
    {
        return $this->hasMany('App\BusinessLike','business_id');
    }

    public function getLikes()
    {
        return $this->likes()->where('is_like', 1)->count();
    }

    public function getLikesList()
    {
        return $this->likes()->where('is_like', 1)->get();
    }

    public function getDislikes()
    {
        return $this->likes()->where('is_dislike', 1)->count();
    }

    public function followers()
    {
        return $this->hasMany('App\BusinessFollower','business_id');
    }

    public function getFollowers()
    {
        return $this->followers()->count();
    }

    public function ratings()
    {
        return $this->hasMany('App\BusinessRating','business_id');
    }

    public function getRatings()
    {
        return $this->ratings()->avg('rating');
    }

    public function favourites()
    {
        return $this->hasMany('App\BusinessFavourite','business_id');
    }

    public function getFavourites()
    {
        return $this->favourites()->count();
    }

    public function reviews()
    {
        return $this->hasMany('App\BusinessReview','business_id');
    }

    public function getReviews()
    {
        return $this->reviews()->count();
    }

    public function portfolio()
    {
        return $this->hasOne('App\UserPortfolio','business_id');
    }

    public function portfolioImages()
    {
        return $this->hasMany('App\UserPortfolioImage','business_id');
    }

    public function apiGetBusinessesByCategory($input)
    {
        $first_day_this_month = date('Y-m-01');
        $last_day_this_month  = date('Y-m-t');
        $current_day_this_month  = date('Y-m-d');
        $top = 'SELECT id,user_id,first_name,middle_name,address,city,state,country,pin_code,currency,country_code,mobile_number,email,image,latitude,longitude,business_id,bussiness_category_id,bussiness_subcategory_id,title,keywords,about_us,website,working_hours,banner,business_logo,identity_proof,business_proof,is_identity_proof_validate,is_business_proof_validate,is_agree_to_terms,portfolio_id,is_blocked,is_update,created_at,updated_at,deleted_at,ratings,reviews,is_top,is_premium FROM (';
        $subscribed = 'SELECT bb.business_category_id,usp.subscription_plan_id, u.first_name, u.middle_name, u.address, u.city, u.state, u.country, u.pin_code, u.currency, u.country_code, u.mobile_number, u.email, u.image, u.latitude, u.longitude, (CASE WHEN u.user_role_id=5 THEN "1" ELSE "0" END) as is_premium, ub.*, (SELECT id FROM user_portfolios WHERE ub.id = user_portfolios.business_id) AS portfolio_id, (SELECT AVG(rating) FROM business_ratings WHERE business_ratings.business_id = ub.id) AS ratings, (SELECT COUNT(*) FROM business_products WHERE business_products.business_id = ub.id AND business_products.deleted_at IS NULL) AS products,(SELECT COUNT(*) FROM user_portfolio_images WHERE user_portfolio_images.business_id = ub.id) AS portfolios, (SELECT COUNT(*) FROM business_reviews WHERE business_reviews.business_id = ub.id) AS reviews , 1 AS is_top';
        $unsubscribed = 'SELECT u.first_name, u.middle_name, u.address, u.city, u.state, u.country, u.pin_code, u.currency, u.country_code, u.mobile_number, u.email, u.image, u.latitude, u.longitude,(CASE WHEN u.user_role_id=5 THEN "1" ELSE "0" END) as is_premium, ub.*, (SELECT id FROM user_portfolios WHERE ub.id = user_portfolios.business_id) AS portfolio_id, (SELECT AVG(rating) FROM business_ratings WHERE business_ratings.business_id = ub.id) AS ratings, (SELECT COUNT(*) FROM business_products WHERE business_products.business_id = ub.id AND business_products.deleted_at IS NULL) AS products,(SELECT COUNT(*) FROM user_portfolio_images WHERE user_portfolio_images.business_id = ub.id) AS portfolios, (SELECT COUNT(*) FROM business_reviews WHERE business_reviews.business_id = ub.id) AS reviews , 0 AS is_top';
        if (isset($input['latitude']) && isset($input['longitude']) && isset($input['radius'])) {
            $subscribed = $subscribed . ',p.distance_unit * DEGREES( ACOS( COS( RADIANS( p.latpoint ) ) * COS( RADIANS(u.latitude ) ) * COS( RADIANS( p.longpoint ) - RADIANS( u.longitude ) ) + SIN( RADIANS( p.latpoint ) ) * SIN( RADIANS( u.latitude ) ) ) ) AS distance_in_km FROM user_businesses as ub INNER JOIN users AS u ON u.id = ub.user_id LEFT JOIN user_subscription_plans AS usp ON ub.user_id = usp.user_id LEFT JOIN business_banners AS bb ON usp.id=bb.user_subscription_plan_id JOIN (SELECT '.$input['latitude'].' AS latpoint, '.$input['longitude'].' AS longpoint, '.$input['radius'].' AS radius, 111.045 AS distance_unit) AS p ON 1 =1 where u.latitude BETWEEN p.latpoint - ( p.radius / p.distance_unit ) AND p.latpoint + ( p.radius / p.distance_unit ) AND u.longitude BETWEEN p.longpoint - ( p.radius / ( p.distance_unit * COS( RADIANS( p.latpoint ) ) ) ) AND p.longpoint + ( p.radius / ( p.distance_unit * COS( RADIANS( p.latpoint ) ) ) )  AND ((bb.business_category_id = "'.$input['categoryId'].'" and (bb.country = "'.$input['country'].'" AND bb.state = "'.$input['state'].'" AND bb.city = "'.$input['city'].'")) OR (ub.bussiness_category_id = "'.$input['categoryId'].'" AND (u.country = "'.$input['country'].'" AND u.state = "'.$input['state'].'" AND u.city = "'.$input['city'].'")))AND (u.deleted_at IS NULL OR u.deleted_at = "") AND (ub.deleted_at IS NULL OR ub.deleted_at = "") AND ub.is_blocked=0 AND ub.is_identity_proof_validate=1 AND ub.is_business_proof_validate=1';
            $unsubscribed = $unsubscribed . ',p.distance_unit * DEGREES( ACOS( COS( RADIANS( p.latpoint ) ) * COS( RADIANS(u.latitude ) ) * COS( RADIANS( p.longpoint ) - RADIANS( u.longitude ) ) + SIN( RADIANS( p.latpoint ) ) * SIN( RADIANS( u.latitude ) ) ) ) AS distance_in_km FROM user_businesses as ub INNER JOIN users AS u ON u.id = ub.user_id JOIN (SELECT '.$input['latitude'].' AS latpoint, '.$input['longitude'].' AS longpoint, '.$input['radius'].' AS radius, 111.045 AS distance_unit) AS p ON 1 =1 where u.latitude BETWEEN p.latpoint - ( p.radius / p.distance_unit ) AND p.latpoint + ( p.radius / p.distance_unit ) AND u.longitude BETWEEN p.longpoint - ( p.radius / ( p.distance_unit * COS( RADIANS( p.latpoint ) ) ) ) AND p.longpoint + ( p.radius / ( p.distance_unit * COS( RADIANS( p.latpoint ) ) ) ) AND (u.country = "'.$input['country'].'" AND u.state = "'.$input['state'].'" AND u.city = "'.$input['city'].'") AND ub.bussiness_category_id = '.$input['categoryId'].' AND (u.deleted_at IS NULL OR u.deleted_at = "") AND (ub.deleted_at IS NULL OR ub.deleted_at = "") AND ub.is_blocked=0 AND ub.is_identity_proof_validate=1 AND ub.is_business_proof_validate=1';
            if(isset($input['subcategoryId']) and $input['subcategoryId']!="")
            {
                $subscribed = $subscribed . ' AND u.is_blocked = 0 AND usp.is_expired=0 AND usp.subscription_date<="'.$current_day_this_month.'" and usp.expired_date>="'.$current_day_this_month.'" AND usp.status="success" AND usp.subscription_plan_id = 6
                        AND (bb.business_subcategory_id = "'.$input['subcategoryId'].'" OR ub.bussiness_subcategory_id = "'.$input['subcategoryId'].'") ORDER BY usp.transaction_date ASC, distance_in_km ASC';
                $unsubscribed = $unsubscribed . ' AND ub.bussiness_subcategory_id = '.$input['subcategoryId'].' AND u.is_blocked = 0 ORDER BY distance_in_km ASC';
            }else
            {
                $subscribed = $subscribed . ' AND u.is_blocked = 0 AND usp.is_expired=0 AND usp.subscription_date<="'.$current_day_this_month.'" and usp.expired_date>="'.$current_day_this_month.'" AND usp.status="success" AND usp.subscription_plan_id = 6 ORDER BY usp.transaction_date ASC,distance_in_km ASC';
                $unsubscribed = $unsubscribed . ' AND u.is_blocked = 0 ORDER BY distance_in_km ASC';
            }
            $subscribed = 'SELECT id,user_id,first_name,middle_name,address,city,state,country,pin_code,currency,country_code,mobile_number,email,image,latitude,longitude,business_id,bussiness_category_id,bussiness_subcategory_id,title,keywords,about_us,website,working_hours,banner,business_logo,identity_proof,business_proof,is_identity_proof_validate,is_business_proof_validate,is_agree_to_terms,is_blocked,portfolio_id,is_update,created_at,updated_at,deleted_at,ratings,reviews,products,portfolios,is_top, distance_in_km,is_premium FROM (' . $subscribed . ') as subscribed';
            $unsubscribed = 'SELECT id,user_id,first_name,middle_name,address,city,state,country,pin_code,currency,country_code,mobile_number,email,image,latitude,longitude,business_id,bussiness_category_id,bussiness_subcategory_id,title,keywords,about_us,website,working_hours,banner,business_logo,identity_proof,business_proof,is_identity_proof_validate,is_business_proof_validate,is_agree_to_terms,is_blocked,portfolio_id,is_update,created_at,updated_at,deleted_at,ratings,reviews,products,portfolios,is_top, distance_in_km,is_premium FROM (' . $unsubscribed . ') as unsubscribed';
            $query = 'SELECT * FROM (' . $subscribed . ' UNION ' . $unsubscribed . ') as business_list GROUP BY user_id,id ORDER BY is_top DESC LIMIT '.$input['index'].','.$input['limit'].'';
        }else
        {
            $subscribed = $subscribed . ' FROM user_businesses as ub INNER JOIN users AS u ON u.id = ub.user_id LEFT JOIN user_subscription_plans AS usp ON ub.user_id = usp.user_id LEFT JOIN business_banners AS bb ON usp.id=bb.user_subscription_plan_id where (u.deleted_at IS NULL OR u.deleted_at = "") AND (ub.deleted_at IS NULL OR ub.deleted_at = "") AND ub.is_blocked=0 AND ub.is_identity_proof_validate=1 AND ub.is_business_proof_validate=1 AND ((bb.business_category_id = "'.$input['categoryId'].'" and (bb.state = "'.$input['state'].'" AND bb.city = "'.$input['city'].'" AND bb.country = "'.$input['country'].'")) OR( ub.bussiness_category_id = "'.$input['categoryId'].'" and (u.state = "'.$input['state'].'" AND u.city = "'.$input['city'].'" AND u.country = "'.$input['country'].'")))';
            $unsubscribed = $unsubscribed . ' FROM user_businesses as ub INNER JOIN users AS u ON u.id = ub.user_id where u.state = "'.$input['state'].'" AND u.city = "'.$input['city'].'" AND ub.bussiness_category_id = '.$input['categoryId'].' AND (u.deleted_at IS NULL OR u.deleted_at = "") AND (ub.deleted_at IS NULL OR ub.deleted_at = "") AND ub.is_blocked=0 AND ub.is_identity_proof_validate=1 AND ub.is_business_proof_validate=1  ';
            if(isset($input['subcategoryId']) and $input['subcategoryId']!="")
            {
                $subscribed = $subscribed . '  AND u.is_blocked = 0 AND usp.is_expired=0 AND usp.subscription_date<="'.$current_day_this_month.'" and usp.expired_date>="'.$current_day_this_month.'" AND usp.status="success" AND usp.subscription_plan_id = 6 AND (bb.business_subcategory_id = "'.$input['subcategoryId'].'" OR ub.bussiness_subcategory_id = "'.$input['subcategoryId'].'") ORDER BY usp.transaction_date ASC,id';
                $unsubscribed = $unsubscribed . ' AND ub.bussiness_subcategory_id = '.$input['subcategoryId'].' AND u.is_blocked = 0 ORDER BY id';
            }else
            {
                $subscribed = $subscribed . ' AND u.is_blocked = 0 AND usp.is_expired=0 AND usp.subscription_date<="'.$current_day_this_month.'" and usp.expired_date>="'.$current_day_this_month.'" AND usp.status="success" AND usp.subscription_plan_id = 6  ORDER BY usp.transaction_date ASC,id';
                $unsubscribed = $unsubscribed . ' AND u.is_blocked = 0 ORDER BY id';
            }
            $subscribed = 'SELECT id,user_id,first_name,middle_name,address,city,state,country,pin_code,currency,country_code,mobile_number,email,image,latitude,longitude,business_id,bussiness_category_id,bussiness_subcategory_id,title,keywords,about_us,website,working_hours,banner,business_logo,identity_proof,business_proof,is_identity_proof_validate,is_business_proof_validate,is_agree_to_terms,is_blocked,portfolio_id,is_update,created_at,updated_at,deleted_at,ratings,reviews,products,portfolios,is_top,is_premium FROM (' . $subscribed . ') as subscribed';
            $unsubscribed = 'SELECT id,user_id,first_name,middle_name,address,city,state,country,pin_code,currency,country_code,mobile_number,email,image,latitude,longitude,business_id,bussiness_category_id,bussiness_subcategory_id,title,keywords,about_us,website,working_hours,banner,business_logo,identity_proof,business_proof,is_identity_proof_validate,is_business_proof_validate,is_agree_to_terms,is_blocked,portfolio_id,is_update,created_at,updated_at,deleted_at,ratings,reviews,products,portfolios,is_top,is_premium FROM (' . $unsubscribed . ') as unsubscribed';
            $query = 'SELECT * FROM (' . $subscribed . ' UNION ' . $unsubscribed . ') as business_list GROUP BY user_id,id ORDER BY is_top DESC LIMIT '.$input['index'].','.$input['limit'].'';
            
        }
        $response = DB::select($query);
        return $response;
    }

    public function apiPostUserBusiness(Request $request)
    {
        $input = $request->input();
        $check = User::where('id', $input['userId'])->whereNotIn('user_role_id', ['1,2'])->first();

        if ($check) {

            $user = $this->where('user_id',$input['userId'])->first();

            $validator = Validator::make($input, [
                    'userId' => 'required',
                    'categoryId' => 'required',
                    'subcategoryId' => 'sometimes|required',
                    'title' => 'required',
                    'keywords' =>'required',
                    'email' => 'required|email|max:255',
                    'pinCode' => 'required|max:10',
                    'country' => 'required|string',
                    'state' => 'required|string',
                    'city' => 'required|string',
                    'currency' => 'required|string',
                    'country_code' => 'required|string',
                    'aboutUs' => 'string',
                    'address' => 'string',
                    'website' => 'string',
                    'workingHours' => 'required|string',
                    'mobileNumber' => 'required|numeric',
                    'latitude' => 'required',
                    'longitude' => 'required',
                    'securityQuestionId' => 'required',
                    'securityQuestionAns' => 'required',
            ]);

            if ($validator->fails()) {
                if (count($validator->errors()) <= 1) {
                        return response()->json(['status' => 'exception','response' => $validator->errors()->first()]);   
                } else {
                    return response()->json(['status' => 'exception','response' => 'All fields are required']);   
                }
            }

            if (!$user) {

                if (isset($input['businessLogo']) && !empty($input['businessLogo'])) {

                    $data = $input['businessLogo'];

                    $img = str_replace('data:image/jpeg;base64,', '', $data);
                    $img = str_replace(' ', '+', $img);

                    $data = base64_decode($img);

                    $fileName = md5(uniqid(rand(), true));

                    $image = $fileName.'.'.'png';

                    $file = config('image.logo_image_path').$image;

                    $success = file_put_contents($file, $data);

                    $img = Image::make($file);
                    
                    $img->resize(config('image.large_thumbnail_width'), null, function($constraint) {
                                 $constraint->aspectRatio();
                            })->save(config('image.logo_image_path').'/thumbnails/large/'.$image); 

                    $img->resize(config('image.medium_thumbnail_width'), null, function($constraint) {
                         $constraint->aspectRatio();
                    })->save(config('image.logo_image_path').'/thumbnails/medium/'.$image);
                            
                    $img->resize(config('image.small_thumbnail_width'), null, function($constraint) {
                         $constraint->aspectRatio();
                    })->save(config('image.logo_image_path').'/thumbnails/small/'.$image);
                }
                
                $input['adderss'] = $input['address'];
                $input['pin_code'] = $input['pinCode'];
                $input['mobile_number'] = $input['mobileNumber'];
                $input['currency'] = $input['currency'];
                $input['security_question_id'] = $input['securityQuestionId'];
                $input['security_question_ans'] = $input['securityQuestionAns'];

                $user = array_intersect_key($input, User::$updatable);
                $user['user_role_id'] = 3;
                $check = User::where('id',$input['userId'])->update($user);
                $user = User::where('id',$input['userId'])->first();
                $business = array_intersect_key($input, UserBusiness::$updatable);

                $business['user_id'] = $input['userId'];
                $business['business_id']= substr($user->first_name,0,3).rand(0,999);
                $business['bussiness_category_id'] = $input['categoryId'];

                if(isset($input['subcategoryId']))
                {
                    $business['bussiness_subcategory_id'] = $input['subcategoryId'];
                }

                $business['pin_code'] = $input['pinCode'];
                $business['mobile_number'] = $input['mobileNumber'];
                $business['working_hours'] = $input['workingHours'];
                $business['is_agree_to_terms'] = 1;
                $business['about_us'] = isset($input['aboutUs']) ? $input['aboutUs'] : '';

                

                if (isset($image)) {
                    $business['business_logo'] = $image;
                }
                try{
                    $business = UserBusiness::create($business);
                    $business->save(); 

                }catch (\Illuminate\Database\QueryException $e) {
                    return response()->json(['status' => 'exception','response' => 'Query Exception occured. Plese Try again ']);
                }catch (PDOException $e) {
                    return response()->json(['status' => 'exception','response' => 'PDOException occur. Plese Try again ']);
                }catch(Exception $e)
                {
                    return response()->json(['status' => 'exception','response' => 'Exception occured. Plese Try again ']);
                }

                if ($business and $check) {
                    Mail::to($user->email)->send(new NewRegisterBusiness($user));
                    Mail::to(config('mail.from')['address'])->send(new AdminMail($user));

                    return response()->json(['status' => 'success','response' => $business]);
                }elseif(!$check){
                    return response()->json(['status' => 'failure','response' => "User can not updated successfully.Please try again"]);
                }else {
                    return response()->json(['status' => 'failure','response' => 'System Error:User could not be created .Please try later.']);
                }

            } else {

                if (isset($input['businessLogo']) && !empty($input['businessLogo'])) {

                    $data = $input['businessLogo'];

                    $img = str_replace('data:image/jpeg;base64,', '', $data);
                    $img = str_replace(' ', '+', $img);

                    $data = base64_decode($img);

                    $fileName = md5(uniqid(rand(), true));

                    $image = $fileName.'.'.'png';

                    $file = config('image.logo_image_path').$image;

                    $success = file_put_contents($file, $data);

                    $img = Image::make($file);
                    
                    $img->resize(config('image.large_thumbnail_width'), null, function($constraint) {
                         $constraint->aspectRatio();
                    })->save(config('image.logo_image_path').'/thumbnails/large/'.$image); 

                    $img->resize(config('image.medium_thumbnail_width'), null, function($constraint) {
                         $constraint->aspectRatio();
                    })->save(config('image.logo_image_path').'/thumbnails/medium/'.$image);
                            
                    $img->resize(config('image.small_thumbnail_width'), null, function($constraint) {
                         $constraint->aspectRatio();
                    })->save(config('image.logo_image_path').'/thumbnails/small/'.$image);
                }

                $input['user_id'] = $input['userId'];
                $input['bussiness_category_id'] = $input['categoryId'];

                if(isset($input['subcategoryId']))
                {
                    $input['bussiness_subcategory_id'] = $input['subcategoryId'];
                }

                $input['pin_code'] = $input['pinCode'];
                $input['mobile_number'] = $input['mobileNumber'];
                $input['working_hours'] = $input['workingHours'];
                $input['about_us'] = $input['aboutUs'];
                $input['currency'] = $input['currency'];
                if(isset($input['securityQuestionId'])){
                    $input['security_question_id'] = $input['securityQuestionId'];
                }
                if(isset($input['securityQuestionAns'])){
                    $input['security_question_ans'] = $input['securityQuestionAns'];
                }

                if (isset($image)) {
                    $input['business_logo'] = $image;
                }
                
                try{
                    $business = array_intersect_key($input, UserBusiness::$updatable);

                    $userbusiness = $this->where('user_id',$input['user_id'])->update($business);

                    $userDetail = array_intersect_key($input, User::$updatable);

                    $userDetail = User::whereId($input['user_id'])->update($userDetail);

                }catch (\Illuminate\Database\QueryException $e) {
                    return response()->json(['status' => 'exception','response' => 'Query Exception occured. Plese Try again ']);
                }catch (PDOException $e) {
                    return response()->json(['status' => 'exception','response' => 'PDOException occur. Plese Try again ']);
                }catch(Exception $e)
                {
                    return response()->json(['status' => 'exception','response' => 'Exception occured. Plese Try again ']);
                } 

                if ($userbusiness and $userDetail)
                    return response()->json(['status' => 'success','response' => "Business updated successfully."]);
                elseif(!$userDetail)
                    return response()->json(['status' => 'failure','response' => "User can not updated .Please try again"]);
                else
                    return response()->json(['status' => 'failure','response' => "Business can not updated .Please try again"]);
            }
        } else {
            return response()->json(['status' => 'exception','response' => "User Does not exist."]);
        }
    }

    public function apiUploadBusinessBanner($input)
    {
        if (isset($input['banner']) && !empty($input['banner'])) {

            $data = $input['banner'];

            $img = str_replace('data:image/jpeg;base64,', '', $data);
            $img = str_replace(' ', '+', $img);

            $data = base64_decode($img);

            $fileName = md5(uniqid(rand(), true));

            $image = $fileName.'.'.'png';

            $file = config('image.banner_image_path').'business/'.$image;

            $success = file_put_contents($file, $data);
                
            $img = Image::make($file);

            $img->resize(config('image.large_thumbnail_width'), null, function($constraint) {
                 $constraint->aspectRatio();
            })->save(config('image.banner_image_path').'business/thumbnails/large/'.$image); 

            $img->resize(config('image.medium_thumbnail_width'), null, function($constraint) {
                 $constraint->aspectRatio();
            })->save(config('image.banner_image_path').'business/thumbnails/medium/'.$image);
                    
            $img->resize(config('image.small_thumbnail_width'), null, function($constraint) {
                 $constraint->aspectRatio();
            })->save(config('image.banner_image_path').'business/thumbnails/small/'.$image);
        }
          
        if ($this->where('id',$input['businessId'])->update(['banner' => $image]))
            return response()->json(['status' => 'success','response' => "Business Banner uploaded successfully."]);
        else
            return response()->json(['status' => 'failure','response' => "Business banner can not uploaded successfully."]);
    }

    public function apiPostUploadDocuments($input)
    {
        /*$im = imagecreatefromstring($data); 
        $im1 = imagecreatefromstring($data1); */

        if(isset($input['businessProof']) and $input['businessProof']!="")
        {
            $data = $input['businessProof'];
            $data = base64_decode($data);
            $file = md5(uniqid(rand(), true));
            $input['business_proof'] = $file.'.'.$input['business_proof_ext'];

            if (file_put_contents(config('image.document_path') .'/'. $input['business_proof'], $data) == false) {
                return response()->json(['status' => 'exception','response' => "Business Proof Document could not be uploaded successfully."]);
            }
        }

        if(isset($input['identityProof']) and $input['identityProof']!="")
        {
            $data1 = $input['identityProof'];
            $data1 = base64_decode($data1); 
            $file = md5(uniqid(rand(), true));
            $input['identity_proof'] = $file.'.'.$input['identity_proof_ext'];

            if (file_put_contents(config('image.document_path') .'/'. $input['identity_proof'], $data1) == false) {
                return response()->json(['status' => 'exception','response' => "Identity Proof Document could not be uploaded successfully."]);
            }
        }

        /*if ($im !== false && $im1 !== false) {
            $file = md5(uniqid(rand(), true));
            $image = $file.'.'.'png';
            imagepng($im, config('image.document_path').$image);
            $input['business_proof'] =  $image; 
            $file1 = md5(uniqid(rand(), true));
            $image1 = $file1.'.'.'png';
            imagepng($im1, config('image.document_path').$image1);
            $input['identity_proof'] =  $image1; 
            imagedestroy($im); 
            imagedestroy($im1); 

        } else { 
            return response()->json(['status' => 'failure','response' => "An error occurred.Could not save image"]);
        }*/
        $business = array_intersect_key($input, UserBusiness::$updatable);

        $userbusiness = $this->where('id',$input['businessId'])->update($business);
      
        if ($userbusiness)
            return response()->json(['status' => 'success','response' => "Business Document uploaded successfully."]);
        else
            return response()->json(['status' => 'success','response' => "Business Document can not uploaded successfully."]);
    }

    public function apiGetUserBusinessDetails($input)
    {
        $businessData = array();
        $business = $this->select("user_businesses.*",DB::raw('concat(users.first_name," ",users.middle_name," ",users.last_name) AS contactPerson'),DB::raw("(SELECT id FROM user_portfolios where user_businesses.id=user_portfolios.business_id) as portfolio_id"),"users.email","users.address","users.city","users.state","users.country","users.pin_code","users.country_code","users.currency","users.mobile_number","users.latitude","users.longitude","users.security_question_id","users.security_question_ans", DB::raw("(SELECT title FROM bussiness_categories WHERE bussiness_categories.id = user_businesses.bussiness_category_id) as category_title"), DB::raw("(SELECT title FROM bussiness_categories WHERE bussiness_categories.id = user_businesses.bussiness_subcategory_id) as subcategory_title"),DB::raw("(SELECT question FROM security_questions WHERE users.security_question_id=security_questions.id ) as security_question"))
            ->where('user_businesses.id', $input['businessId'])
            ->where('user_businesses.is_blocked', 0)
            ->join('users', 'user_businesses.user_id', '=', 'users.id')
            ->first();
        if($business)
        {
            $businessData['businessDetails'] = $business;
            $businessData['portfolio_details'] = UserPortfolio::where('business_id',$business->id)->first();
            $businessData['portfolio_images'] = UserPortfolioImage::where('business_id',$business->id)->get();
            $businessData['favourites'] = $business->getFavourites();
            $businessData['likes'] = $business->getLikes();
            $businessData['dislikes'] = $business->getDislikes();
            $businessData['rating'] = $business->getRatings();
            $businessData['reviews'] = $business->getReviews();
            $businessData['followers'] = $business->getFollowers();
            $user = User::find($business->user_id);
            $businessData['is_premium'] = (isset($user) && $user->user_role_id == 5) ? 1:0;
            $category = BussinessCategory::where('id',$business->bussiness_category_id)->first();
            if($category)
            {
                $businessData['category'] = $category->title;
            }
            $subcategory = BussinessCategory::where('id',$business->bussiness_subcategory_id)->first();
            if($subcategory)
            {
                $businessData['subcategory'] = $subcategory->title;
            }
            $is_subscribed = UserSubscriptionPlan::where('is_expired','=',0)->where('expired_date','>=', Carbon::now())->where('user_id',$business->user_id)->count();
            if($is_subscribed>0)
            {
                $businessData['is_subscribed'] = 1;
            }else
            {
                $businessData['is_subscribed'] = 0;
            }
            return $businessData;
        }else
        {
            return NULL;
        }
    }

    public function apiGetBusinessStates($input)
    {
        $states = User::where('country', $input['countryName'])->where('user_role_id', 3)->distinct()->pluck('state');
        return $states;
    }
}
