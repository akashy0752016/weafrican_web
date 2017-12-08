<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;

use App\BusinessEvent;
use App\EventSeatingPlan;
use App\SoldEventTicket;
use Auth;
use DB;

class AdminBusinessEventsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index()
    {
        $pageTitle = 'Business Event- Admin';
        $events = BusinessEvent::select('business_events.*','user_businesses.id as businessId', 'user_businesses.business_id', 'user_businesses.title as business_name')->leftJoin('user_businesses','business_events.user_id' , '=', 'user_businesses.user_id')->get();
        return view('admin.events.index', compact('pageTitle', 'events'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Respons
e     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $event = BusinessEvent::find($id);
        if($event)
        {
            $pageTitle = $event->name;
            $eventSeatingPlans = EventSeatingPlan::where('is_blocked', 0)->get();
            $soldEventTickets = SoldEventTicket::where(array('business_id'=>$event->business_id,'business_event_id'=>$event->id))->get();
            $ticket_details = DB::table('sold_event_tickets as SET')
                ->join('users as U','U.id','SET.user_id')
                ->join('business_events as BE','BE.id','SET.business_event_id')
                ->groupBy('SET.event_transaction_id','SET.user_id','SET.created_at')
                ->select("*","SET.user_id",DB::raw("SUM(SET.total_tickets_price) as totalprice"),DB::raw("SUM(SET.total_tickets_buyed) as total_ticket"),DB::raw("GROUP_CONCAT(SET.event_seating_plan_id SEPARATOR ',') as seating_plans"))
                ->where('BE.id',"=",$id)
                ->get();
            return view('admin.events.view', compact('pageTitle', 'event', 'eventSeatingPlans', 'soldEventTickets', 'ticket_details'));
        }else
        {
            return back()->with('error', 'Business Event dose not exits');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
     
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       
    }

    /**
     * Block the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function block($id)
    {
        $event = BusinessEvent::find($id);
        $event->is_blocked = !$event->is_blocked;
        $event->save();

        if ($event->is_blocked) { 
            return back()->with('success', 'Business Event blocked successfully');
        } else {
            return back()->with('success', 'Business Event unblocked successfully');
        }   
    }

    public function destroy($id)
    {
        $event = BusinessEvent::findOrFail($id);

        if($event->delete()){
            $response = array(
                'status' => 'success',
                'message' => 'Business Event deleted  successfully',
            );
        } else {
            $response = array(
                'status' => 'error',
                'message' => 'Business Event can not be deleted.Please try again',
            );
        }

        return json_encode($response);
    }
}