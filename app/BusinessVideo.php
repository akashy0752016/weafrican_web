<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Validator;

class BusinessVideo extends Model
{
    protected $fillable = ['user_id', 'business_id', 'title', 'description', 'type', 'url', 'thumbnail_image', 'embed_url'];

    public static $updatable = ['user_id' => "", 'business_id' => "" ,'title' => "", 'description' => "", 'type' => "", 'url' => "", 'thumbnail_image' => "", 'embed_url' => ""];

    public static $updateValidater = array(
    	'title' => 'required|max:40',
    	'description' => 'required|max:100',
    	'url' => 'required|url'
    );
}
