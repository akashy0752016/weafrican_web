<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class BussinessCategory extends Model
{
	use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = ['parent_id','title', 'slug', 'description', 'image'];

    public static $updatable = ['parent_id' => "", 'title' => "", 'slug' => "", 'description' => "", 'image' => ""];

    public static $validater = array(
    	'title' => 'required|unique:bussiness_categories|max:35',
    	'description' => 'required',
    	'category_image' => 'required',
    	);

    public static $updateValidater = array(
    	'title' => 'required|max:35',
    	'description' => 'required',
    	);

    public function businesses()
    {
        return $this->hasMany('App\UserBusiness');
    }
    
    public function getBusinesses()
    {
        return $this->businesses()->where('is_blocked', 0)->orderBy('sort_order','asc')->get();
    }

    public function parent()
    {
        return $this->belongsTo('App\BussinessCategory','parent_id','id');
    }

    public function apiGetCategory()
    {
        $categories = DB::select("SELECT *,(SELECT if(count(sub.id) >= 1, 1, 0) FROM bussiness_categories as sub WHERE sub.parent_id = parent.id AND sub.is_blocked=0 AND (sub.deleted_at is NULL or sub.deleted_at = '')) as has_subcategory FROM `bussiness_categories` as parent where parent.parent_id = 0 AND (deleted_at is NULL or deleted_at = '') and is_blocked=0");
       	return $categories;
    }

    public function apiGetSubCategory($id)
    {
        $subCategories = $this->where('is_blocked',0)->where('parent_id', $id)->get();
        return $subCategories;
    }    
}
