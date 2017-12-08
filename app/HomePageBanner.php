<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Helper;
use DB;
use Image;

class HomePageBanner extends Model
{
    protected $fillable = ['user_id', 'business_id', 'user_subscription_plan_id', 'country', 'state', 'city','image', 'latitude', 'longitude', 'is_selected', 'business_event_id', 'is_blocked'];

    public static $updatable = ['user_id' => "", 'user_subscription_plan_id' => "", 'country' => "", 'state' => "", 'city' => "", 'image' => "", 'latitude' => "", 'longitude' => "", 'is_selected' => '', 'business_event_id' => '', 'is_blocked' => '', 'business_id' => ""];


    public function business()
    {
    	return $this->belongsTo('App\UserBusiness','user_id','user_id');
    }

    public function userSubscriptionPlan()
    {
        return $this->belongsTo('App\UserSubscriptionPlan','user_subscription_plan_id','id');
    }

    public function businessEvent()
    {
        return $this->belongsTo('App\BusinessEvent','business_event_id','id');
    }

    public function user()
    {
        return $this->belongsTo('App\User','user_id','id');
    }

    public function updateHomePageBanner($input)
    {
        $homePageBanner = $this->whereId($input['bannerId'])->where('user_subscription_plan_id', $input['user_subscription_plan_id'])->first();
        if($homePageBanner)
        {
            if($input['is_selected']==0)
            {
                if (isset($input['image']) && !empty($input['image'])) {
                    $data = $input['image'];

                    $img = str_replace('data:image/jpeg;base64,', '', $data);
                    $img = str_replace(' ', '+', $img);

                    $data = base64_decode($img);

                    $fileName = md5(uniqid(rand(), true));

                    $image = $fileName.'.'.'png';

                    $file = config('image.banner_image_path').'/home/'.$image;

                    $success = file_put_contents($file, $data);

                    $img = Image::make($file);
                    
                    $img->resize(config('image.large_thumbnail_width'), null, function($constraint) {
                                 $constraint->aspectRatio();
                            })->save(config('image.banner_image_path').'/home/thumbnails/large/'.$image); 

                    $img->resize(config('image.medium_thumbnail_width'), null, function($constraint) {
                         $constraint->aspectRatio();
                    })->save(config('image.banner_image_path').'/home/thumbnails/medium/'.$image);
                            
                    $img->resize(config('image.small_thumbnail_width'), null, function($constraint) {
                         $constraint->aspectRatio();
                    })->save(config('image.banner_image_path').'/home/thumbnails/small/'.$image);
                    
                    $input['image'] = $image;
                    $input['business_event_id'] = NULL;

                    if($homePageBanner->image!="")
                    {
                        Helper::removeImages(config('image.banner_image_path').'/home/',$homePageBanner->image);
                    }
                }
                
            }elseif($input['is_selected']==2)
            {
                if($homePageBanner->image!="")
                {
                    Helper::removeImages(config('image.banner_image_path').'/home/',$homePageBanner->image);
                }
                $input['image'] = NULL;
                $input['business_event_id'] = $input['businessEventId'];
            }else
            {
                if($homePageBanner->image!="")
                {
                    Helper::removeImages(config('image.banner_image_path').'/home/',$homePageBanner->image);
                }
                $input['image'] = NULL;
                $input['business_event_id'] = NULL;
            }
            $input = array_intersect_key($input, HomePageBanner::$updatable);
            $homePageBanner->update($input);
            if($homePageBanner->save())
            {
                return response()->json(['status' => 'success', 'response' => 'Sponsor Banner updated successfully.']);
            }else
            {
                return response()->json(['status' => 'exception', 'response' => 'Sponsor Banner connot be updated. Please try again.']);
            }
        }else
        {
            return response()->json(['status' => 'failure', 'response' => 'Sponsor Banner does not exist.']);
        }
    }

    public function block($input)
    {
        $banner = $this->where('user_id', $input['userId'])->whereId($input['bannerId'])->first();
        if($banner)
        {
            $banner->is_blocked = !$banner->is_blocked;
            if($banner->save())
            {
                if ($banner->is_blocked)
                {
                    return response()->json(['status' => 'success', 'response' => 'Sponsor Banner blocked successfully.']);
                }else
                {
                    return response()->json(['status' => 'success', 'response' => 'Sponsor Banner unblocked successfully.']);
                }
            }else
            {
                return response()->json(['status' => 'exception', 'response' => 'Sponsor Banner connot be updated. Please try again.']);
            }
        }else
        {
            return response()->json(['status' => 'failure', 'response' => 'Sponsor Banner does not exist.']);
        }
    }
}
