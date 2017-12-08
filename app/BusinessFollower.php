<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BusinessFollower extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function business()
    {
        return $this->belongsTo('App\UserBusiness', 'business_id');
    }
}
