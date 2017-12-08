<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Validator;

class UserPost extends Model
{
    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
	protected $fillable = ['user_id' ,'business_id', 'post', 'upload_type', 'images', 'video_url', 'video_description', 'video_embed_url', 'video_thumbnail',];

    public static $updatable = ['user_id' => " " ,'business_id' => "", 'post' => "", 'upload_type' => "", 'images' => "", 'video_url' => "", 'video_description' => "", 'video_embed_url' => "", 'video_thumbnail' => ""];
	
    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public static $validater = array(
        'post' => 'required|max:250',
        'upload_type' => 'required',
        'video_url' => 'sometimes|required',
        'video_description' => 'sometimes|required|max:250',
    );
}
