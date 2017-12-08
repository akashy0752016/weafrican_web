<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\EventTransaction;
use DB;

class EventTicket extends Model
{
	protected $fillable = ['user_id', 'event_id', 'event_transaction_id', 'primary_booking_id', 'sub_booking_id', 'attended_status'];

    public static $updatable = ['user_id' => "", 'event_id' => "", 'event_transaction_id' => "", 'primary_booking_id' => "", 'sub_booking_id' => "", 'attended_status' => ""];
    
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function event()
    {
        return $this->belongsTo('App\BusinessEvent', 'event_id', 'id');
    }

    public function apiEventTicktes($input)
    {
        if(isset($input['referenceId']) and $input['referenceId']!="")
        {
            $eventTransaction = EventTransaction::where('business_event_id', $input['eventId'])->where('reference_id', $input['referenceId'])->first();
            if($eventTransaction)
            {
                $eventTickets = $this->where('event_transaction_id',$eventTransaction->id)->select("*", DB::raw("(SELECT first_name FROM users where users.id=event_tickets.user_id) as username"))->get();
                if($eventTickets->count()>0)
                {
                    return response()->json(['status' => 'success','response' => $eventTickets]);
                }else
                {
                    return response()->json(['status' => 'exception','response' => 'No Tickets found.']);
                }
            }else
            {
                return response()->json(['status' => 'failure','response' => 'Invalid QR Code. Please Try again.']);
            }
        }elseif(isset($input['primaryBookingId']) and $input['primaryBookingId']!="")
        {
            if(strpos($input['primaryBookingId'], "WAS")!==false || strpos($input['primaryBookingId'], "was")!==false)
            {
                $eventTickets = $this->select("*", DB::raw("(SELECT first_name FROM users where users.id=event_tickets.user_id) as username"))->where('event_id', $input['eventId'])->where('sub_booking_id', $input['primaryBookingId'])->get();
            }else
            {
                $eventTickets = $this->select("*", DB::raw("(SELECT first_name FROM users where users.id=event_tickets.user_id) as username"))->where('event_id', $input['eventId'])->where('primary_booking_id', $input['primaryBookingId'])->get();
            }
            if($eventTickets->count()>0)
            {
                return response()->json(['status' => 'success','response' => $eventTickets]);
            }else
            {
                return response()->json(['status' => 'exception','response' => 'No Tickets found.']);
            }
        }else
        {
            return response()->json(['status' => 'exception','response' => 'Primary Booking Id or QR code is required.']);
        }
    }

    public function apiTickteUpdateStatus($input)
    {
        if(isset($input['ticketId']) and $input['ticketId']!="")
        {
            $response = $this->whereIn('id',array_map('intval', explode(',', $input['ticketId'])))->update(['attended_status'=>1]);

            if($response>0)
            {
                $response = $this->apiEventTicktes($input);

                return $response;
            }else
            {
                return response()->json(['status' => 'exception','response' => "Tickets couldnot be updated. Please try again."]);
            }
        }
    }
}
