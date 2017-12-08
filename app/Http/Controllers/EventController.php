<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BusinessEvent;
use App\EventTicket;
use App\EventSeatingPlan;
use App\SoldEventTicket;
use Session;
use DB;

class EventController extends Controller
{

    public function index()
    {
        $pageTitle = 'Best Africans Events | Event Organizer in Africa | Weafricans';
        $metaDescription = 'Weafricans is one of the best event organizer. We help in Organize events, sell tickets and check in attendeces easily. For events please register on our website weafricans.com';
        $flag = 1;
        return view('events',compact('pageTitle', 'flag', 'metaDescription'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {   
        $eventId = Session::get('eventId');

        if (!$eventId) {
            return redirect()->intended('event-login');
        }

        $event = BusinessEvent::find($eventId);
        $flag=0;
        return view('event.index', compact('event', 'flag'));
    }

    public function searchTicket()
    {
        $eventId = Session::get('eventId');

        if (!$eventId) {
            return redirect()->intended('event-login');
        }
        $flag=0;
        $event = BusinessEvent::find($eventId);
        $tickets = EventTicket::whereEventId($eventId)->get();
        $eventSeatingPlans = EventSeatingPlan::where('is_blocked', 0)->get();
        $soldEventTickets = SoldEventTicket::where('business_event_id',$event->id)->where('business_id',$event->business_id)->get();
        $ticket_details = DB::table('sold_event_tickets as SET')
            ->join('users as U','U.id','SET.user_id')
            ->join('business_events as BE','BE.id','SET.business_event_id')
            ->groupBy('SET.event_transaction_id','SET.user_id','SET.created_at')
            ->select("*","SET.user_id",DB::raw("SUM(SET.total_tickets_price) as totalprice"),DB::raw("SUM(SET.total_tickets_buyed) as total_ticket"),DB::raw("GROUP_CONCAT(SET.event_seating_plan_id SEPARATOR ',') as seating_plans"))
            ->where('business_event_id',$event->id)
            ->get();

        return view('event.search', compact('event', 'tickets', 'eventSeatingPlans', 'soldEventTickets', 'flag'));
    }

    public function getEventTickets(Request $request)
    {  
       $eventId = Session::get('eventId');

        if (!$eventId) {
            return redirect()->intended('event-login');
        }

        $event = BusinessEvent::find($eventId);

        $ticketIds = EventTicket::where('primary_booking_id', 'like', '%'.$request->search.'%')->orWhere('sub_booking_id', 'like', '%'.$request->search.'%')->pluck('id');
       
        $tickets = EventTicket::whereIn('id', $ticketIds)->whereEventId($eventId)->get();
        $flag=0;
        if ($tickets->count() > 0 ) 
            return view('event.tickets', compact('tickets', 'event', 'flag'));
        else 
            return redirect('event/search')->with('error', 'No ticket found!!');
    }

    public function confirmTicket(Request $request)
    {
        $input = $request->input();

        $eventTicket = EventTicket::whereIn('id',$input['chkbox'])->whereAttendedStatus(1)->first();

        if ($eventTicket) {
            $confirm = EventTicket::whereIn('id',$input['chkbox'])->update(['attended_status' => 0]);
            return response()->json(['status' => 'success', 'text' => 'Ticket not confirmed']);
        } else {
            $confirm = EventTicket::whereIn('id',$input['chkbox'])->update(['attended_status' => 1]);
            return response()->json(['status' => 'success', 'text' => 'Ticket confirmed']);
        }
    }
}
