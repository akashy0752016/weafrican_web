<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use App\UserBusiness;
use Validator;

class UserPortfolio extends Model
{
    protected $fillable = ['user_id', 'business_id', 'maritial_status', 'occupation', 'acedimic_status' ,'key_skills', 'experience_years', 'experience_months', 'height_feets', 'height_inches' , 'hair_type', 'skin_color' , 'hair_color' , 'professional_training', 'institute_name'];

    public static $updatable = ['user_id' => "", 'business_id' => "", 'maritial_status' => "", 'occupation' => "", 'acedimic_status' => "",'key_skills' => "", 'experience_years' => "", 'experience_months' => "", 'height_feets' => "", 'height_inches' => "", 'hair_type' => "", 'skin_color' => "", 'hair_color' => "", 'professional_training' => "", 'institute_name' => ""];

    public function portfolio_images()
    {
        return $this->hasMany('App\UserPortfolioImage','user_portfolio_id');
    }

    public function images()
    {
        return explode('|', $this->image);
    }

    public function apiGetUserPortfolio($input)
    {
    	$portfolio = $this->wherebusinessId($input['businessId'])->first();
    	return $portfolio;
    }

    public function postUserBusinessPortfolio(Request $request)
    {
        $input = $request->input();
        $check = UserBusiness::where('id', $input['businessId'])->where('user_id',$input['userId'])->first();
        if($check->exists)
        {
            $portfolio = $this->where('user_id',$input['userId'])->where('business_id',$input['businessId'])->first();
            $validator = Validator::make($input, [
                    'userId' => 'required',
                    'businessId' => 'required',
                    'maritial_status' => 'required',
                    'occupation' => 'required|string',
                    'acedimic_status' =>'required',
                    'key_skills' => 'required|string',
                    'experience_years' => 'sometimes|required',
                    'experience_months' => 'sometimes|required',
                    'height_feets' => 'sometimes|required',
                    'height_inches' => 'sometimes|required',
                    'hair_type' => 'sometimes|required',
                    'hair_color' => 'sometimes|required',
                    'skin_color' => 'sometimes|required',
                    'professional_training' => 'sometimes|required|integer',
                    'institute_name' => 'sometimes|string|required_if:professional_training,==,1',
            ]);

            if ($validator->fails()) {
                if (count($validator->errors()) <= 1) {
                        return response()->json(['status' => 'exception','response' => $validator->errors()->first()]);   
                } else {
                    return response()->json(['status' => 'exception','response' => 'All fields are required']);   
                }
            }

            $input['user_id'] = $input['userId'];
            $input['business_id'] = $input['businessId'];

            if($portfolio)
            {
                $portfolio = array_intersect_key($input, UserPortfolio::$updatable);
                $portfolio = $this->where('user_id',$input['user_id'])->where('business_id',$input['business_id'])->update($portfolio);

                if ($portfolio)
                    return response()->json(['status' => 'success','response' => "Business Portfolio updated successfully."]);
                else
                    return response()->json(['status' => 'failure','response' => "Business portfolio can not updated successfully.Please try again"]);

            }else
            {
                $portfolio = array_intersect_key($input, UserPortfolio::$updatable);

                $portfolio = UserPortfolio::create($portfolio);
                $portfolio->save(); 

                if ($portfolio) {
                    return response()->json(['status' => 'success','response' => $portfolio]);
                }else {
                    return response()->json(['status' => 'failure','response' => 'System Error:User Business portfolio could not be created .Please try later.']);
                }
            }

        }else
        {
            return response()->json(['status' => 'exception','response' => "User Business Does not exist."]);
        }

    }
}
