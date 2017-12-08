<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserNotification extends Model
{
    protected $fillable = ['user_id', 'business_notification_id'];

    public static $updatable = ['user_id' => "", 'business_notification_id' => ""];
}
