<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BusinessReview extends Model
{
	
    protected $fillable = ['user_id', 'business_id', 'review'];

    public static $updatable = ['user_id' => "", 'business_id' => "", 'review' => ""];

    public function apiGetBusinessReview($input)
    {
    	$reviews = $this->where('business_reviews.business_id', $input['businessId'])->where('business_reviews.is_blocked', 0)->join('users','business_reviews.user_id', '=', 'users.id')->orderBy('business_reviews.id', 'DESC')->get();
    	return $reviews;
    }
}