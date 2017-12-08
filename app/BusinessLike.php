<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BusinessLike extends Model
{
    protected $fillable = ['user_id', 'business_id', 'is_like', 'is_dislike'];

    public static $updatable = ['user_id' => "", 'business_id' => "", 'is_like' => "", 'is_dislike' => ""];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
