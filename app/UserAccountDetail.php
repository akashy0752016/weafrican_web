<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Validator;

class UserAccountDetail extends Model
{
	/**
    * The attributes that are mass assignable.
    *
    * @var array
    */
	protected $fillable = ['user_id' ,'account_holder_name', 'account_number', 'bank_name', 'business_name', 'subaccount_code', 'is_verified', 'active'];

    public static $updatable = ['user_id' => " " ,'account_holder_name' => "", 'account_number' => "", 'bank_name' => "", 'business_name' => "", 'subaccount_code' => "", 'is_verified' => "", 'active' => ""];
	
    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public static $validater = array(
        'account_holder_name' => 'required|max:255',
        'account_number' => 'required|integer',
        'bank_name' => 'required',
        );
}
