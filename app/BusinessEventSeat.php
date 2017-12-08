<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\EventSeatingPlan;

class BusinessEventSeat extends Model
{

	protected $table = 'business_event_seats';

	protected $fillable = ['user_id', 'business_id', 'business_event_id', 'name', 'event_seating_plan_id', 'total_seat_available', 'seat_buyed', 'per_ticket_price', 'seating_plan_alias' ];

    public static $updatable = ['user_id' => "", 'business_id' => "", 'business_event_id' => "", 'name' => "" , 'event_seating_plan_id' => "", 'total_seat_available' => "", 'seat_buyed' => "", 'per_ticket_price' => "", 'seating_plan_alias' => "" ];
}
