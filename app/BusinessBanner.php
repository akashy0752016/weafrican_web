<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Helper;
use DB;
use Image;

class BusinessBanner extends Model
{
    protected $fillable = ['user_id', 'business_id', 'user_subscription_plan_id', 'business_category_id', 'business_subcategory_id', 'country', 'state', 'city','image', 'latitude', 'longitude', 'is_selected', 'is_blocked'];

    public static $updatable = ['user_id' => "", 'business_id' => "", 'user_subscription_plan_id' => "", 'business_category_id' => '', 'business_subcategory_id' => '', 'country' => "", 'state' => "", 'city' => "", 'image' => "", 'latitude' => "", 'longitude' => "", 'is_selected' => "", 'is_blocked' => ""];


    public function business()
    {
    	return $this->belongsTo('App\UserBusiness','user_id','user_id');
    }

    public function userSubscriptionPlan()
    {
        return $this->belongsTo('App\UserSubscriptionPlan','user_subscription_plan_id','id');
    }

    public function category()
    {
        return $this->belongsTo('App\BussinessCategory','business_category_id','id');
    }

    public function subcategory()
    {
        return $this->belongsTo('App\BussinessCategory','business_subcategory_id','id');
    }

    public function user()
    {
        return $this->belongsTo('App\User','user_id','id');
    }

    public function updateBusinessBanner($input)
    {
        $businessBanner = $this->whereId($input['bannerId'])->where('user_subscription_plan_id', $input['user_subscription_plan_id'])->first();
        if($businessBanner)
        {
            if(isset($input['categoryId']) and $input['categoryId']!="")
            {
                $input['business_category_id'] = $input['categoryId'];
                if(isset($input['subcategoryId']) and $input['subcategoryId']!="")
                {
                    $input['business_subcategory_id'] = $input['subcategoryId'];
                }else
                {
                    $input['business_subcategory_id'] = NULL;
                }
            }
            
            if($input['is_selected']==0)
            {
                if (isset($input['image']) && !empty($input['image'])) {
                    $data = $input['image'];

                    $img = str_replace('data:image/jpeg;base64,', '', $data);
                    $img = str_replace(' ', '+', $img);

                    $data = base64_decode($img);

                    $fileName = md5(uniqid(rand(), true));

                    $image = $fileName.'.'.'png';

                    $file = config('image.banner_image_path').'/business/'.$image;

                    $success = file_put_contents($file, $data);

                    $img = Image::make($file);
                    
                    $img->resize(config('image.large_thumbnail_width'), null, function($constraint) {
                                 $constraint->aspectRatio();
                            })->save(config('image.banner_image_path').'/business/thumbnails/large/'.$image); 

                    $img->resize(config('image.medium_thumbnail_width'), null, function($constraint) {
                         $constraint->aspectRatio();
                    })->save(config('image.banner_image_path').'/business/thumbnails/medium/'.$image);
                            
                    $img->resize(config('image.small_thumbnail_width'), null, function($constraint) {
                         $constraint->aspectRatio();
                    })->save(config('image.banner_image_path').'/business/thumbnails/small/'.$image);
                    $input['image'] = $image;

                    if($businessBanner->image!="")
                    {
                        Helper::removeImages(config('image.banner_image_path').'/business/',$businessBanner->image);
                    }
                }
                
            }else
            {
                if($businessBanner->image!="")
                {
                    Helper::removeImages(config('image.banner_image_path').'/business/',$businessBanner->image);
                }
                $input['image'] = NULL;
            }
            $input = array_intersect_key($input, BusinessBanner::$updatable);
            $businessBanner->update($input);
            if($businessBanner->save())
            {
                return response()->json(['status' => 'success', 'response' => 'Business Banner updated successfully.']);
            }else
            {
                return response()->json(['status' => 'exception', 'response' => 'Business Banner connot be updated. Please try again.']);
            }
        }else
        {
            return response()->json(['status' => 'failure', 'response' => 'Business Banner does not exist.']);
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
                    return response()->json(['status' => 'success', 'response' => 'Business Banner blocked successfully.']);
                }else
                {
                    return response()->json(['status' => 'success', 'response' => 'Business Banner unblocked successfully.']);
                }
            }else
            {
                return response()->json(['status' => 'exception', 'response' => 'Business Banner connot be updated. Please try again.']);
            }
        }else
        {
            return response()->json(['status' => 'failure', 'response' => 'Business Banner does not exist.']);
        }
    }
}
