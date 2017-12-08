<?php
namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class AppFeedback extends Model
{
	use SoftDeletes;

    protected $fillable = ['user_id','feedback'];

    protected $updatable = ['user_id' => "", 'feedback' => ""];
}
