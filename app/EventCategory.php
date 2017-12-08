<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventCategory extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = ['title', 'slug', 'description', 'image'];

    public static $updatable = ['title' => "", 'slug' => "", 'description' => "", 'image' => ""];

    public static $validater = array(
    	'title' => 'required|unique:event_categories|max:255',
    	'description' => 'required',
    	'image' => 'required',
    	);

    public static $updateValidater = array(
    	'title' => 'required',
    	'description' => 'required',
    	);

    public function events()
    {
        return $this->hasMany('App\BusinessEvent');
    }
    
    public function getEvents()
    {
        return $this->events()->where('is_blocked', 0)->orderBy('sort_order','asc')->get();
    }

    public function apiGetEventCategory()
    {
    	$categories = $this->where('is_blocked',0)->get();
       	return $categories;
    }
}
