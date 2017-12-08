<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventTransaction extends Model
{
    protected $fillable = [
        'user_id', 'business_event_id', 'total_seats_buyed', 'amount', 'currency', 'reference_id', 'transaction_date', 'status', 'ip_address','user_amount', 'user_currency'];
    
    public static $updatable = ['user_id' => "", 'business_event_id' => "", 'total_seats_buyed' => "", 'amount' => "", 'currency' => "", 'reference_id' => "", 'transaction_date' =>"", 'status' => "", 'ip_address' => "", 'user_amount' => "", 'user_currency' => ""];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function event()
    {
        return $this->belongsTo('App\BusinessEvent', 'business_event_id', 'id');
    }

    public function eventTickets()
    {
    	return $this->hasMany('App\EventTicket');
    }

    public function getPrimaryBookingId()
    {
        return $this->hasMany('App\EventTicket')->first();
    }

    public function soldEventTickets()
    {
        return $this->hasMany('App\SoldEventTicket');
    }
}
