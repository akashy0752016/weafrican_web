<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubscriptionPlan extends Model
{
	use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = ['title', 'price', 'keywords_limit', 'validity_period'];

    public static $updatable = ['title' => "", 'price' => "" ,'keywords_limit' => "", 'validity_period' => ""];

    public static $validater = array(
    	'price' => 'required|numeric',
        'keywords_limit' => 'numeric|min:1', 
        'validity_period' => 'required|numeric',  
    	);

    public static $updateValidater = array(
    	'price' => 'required|numeric',  
        'keywords_limit' => 'numeric|min:1', 
        'validity_period' => 'required|numeric',    
    	);

    public function apiGetSubscriptionPlans()
    {
        $plans = SubscriptionPlan::where('is_blocked',0)->get();
        return $plans;
    }

    public function apiGetPlansByType($type)
    {
        $plans = SubscriptionPlan::where('is_blocked',0)->where('type',$type)->get();
        return $plans;
    }
}