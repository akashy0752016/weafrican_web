<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserSubscriptionPlan extends Model
{
	protected $fillable = [
        'user_id','subscription_plan_id','first_name','last_name', 'email', 'amount', 'currency', 'reference_id', 'transaction_date', 'status', 'ip_address', 'subscription_date', 'expired_date', 'is_expired', 'authorization_code', 'transaction_message', 'is_premium', 'is_auto_renew', 'user_amount', 'user_currency'];
    
    public static $updatable = ['user_id' => "", 'subscription_plan_id' => "", 'first_name' => "", 'last_name' => "", 'email' => "", 'amount' => "", 'currency' => "", 'reference_id' => "", 'transaction_date' => "", 'status' => "", 'ip_address' => "", 'subscription_date' => "", 'expired_date' => "", 'is_expired' => "", 'authorization_code' => "", 'transaction_message' => "", 'is_premium' => "", 'is_auto_renew' => "" , 'user_amount' => "", 'user_currency' => ""];

    public function subscription()
    {
        return $this->belongsTo('App\SubscriptionPlan','subscription_plan_id','id');
    }

    public function user()
    {
        return $this->belongsTo('App\User','user_id','id');
    }

    public function business()
    {
        return $this->hasOne('App\UserBusiness','user_id','user_id');
    }
}

