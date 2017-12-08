<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Validator;

class ContactDetail extends Model
{
	
    protected $fillable = ['full_name','phone', 'email', 'subject', 'message'];

    public static $validater = array(
        'full_name' => 'required|max:255',
        'phone' => 'required',
        'email' =>  'required',
        'subject' => 'required',
        'message' => 'required'
        );
}
