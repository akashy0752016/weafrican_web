<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SecurityQuestion extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = ['question'];

    public static $updatable = ['question' => ""];

    public static $validater = array(
    	'question' => 'required|unique:security_questions',
    	);

    public static $updateValidater = array(
    	'question' => 'required',
    	);

    public function apiGetSecurityQuestions()
    {
        $response = $this->where('is_blocked',0)->get();
        return $response;
    }
}
