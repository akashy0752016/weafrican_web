<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SoldEventTicket extends Model
{
    protected $fillable = [
        'user_id', 'business_id', 'business_event_id', 'event_seating_plan_id', 'event_transaction_id', 'per_ticket_price', 'total_tickets_buyed', 'total_tickets_price', 'user_per_ticket_price', 'user_total_tickets_buyed'];
    
    public static $updatable = ['user_id' => "", 'business_id' => "", 'business_event_id' => "", 'event_seating_plan_id' => "", 'event_transaction_id' => "", 'per_ticket_price' => "", 'total_tickets_buyed' => "", 'total_tickets_price' => "", 'user_per_ticket_price' => "", 'user_total_tickets_price' => ""];

    public function eventSeatingPlan()
    {
        return $this->belongsTo('App\EventSeatingPlan', 'event_seating_plan_id', 'id');
    }

    public function businessEventSeats()
    {
    	return $this->belongsTo('App\BusinessEventSeat', 'event_seating_plan_id', 'event_seating_plan_id');
    }
}
