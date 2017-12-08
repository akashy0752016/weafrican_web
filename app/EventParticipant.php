<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventParticipant extends Model
{
    protected $fillable = ['user_id', 'event_id', ];

    public static $updatable = ['user_id' => "", 'event_id' => ""];

}