<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests;
use App\EventCategory;
use App\BusinessEvent;
use App\BusinessEventSeat;
use App\EventBanner;
use App\UserBusiness;
use App\BusinessNotification;
use App\EventSeatingPlan;
use App\SoldEventTicket;
use App\EventTicket;
use App\User;
use App\Helper;
use Validator;
use Auth;
use DB;

class BusinessEventsController extends Controller
{
     /**
     * Author:Divya
     * Create a controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
        $this->businessNotification = new BusinessNotification();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageTitle = "Business Event";
        $events = BusinessEvent::whereUserId(Auth::id())->orderBy('created_at','DESC')->withCount('participations')->paginate(10);
        $flag=0;
        return view('business-event.index', compact('pageTitle', 'events', 'flag'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pageTitle = "Business Event -Create";
        $business = UserBusiness::where('user_id', Auth::id())->first();
        $categories = EventCategory::where('is_blocked', 0)->get();
        $seatingplans = EventSeatingPlan::where('is_blocked', 0)->get();
        $flag = 0;

        if(Auth::user()->event_password != null && Auth::user()->event_password != "")
            return view('business-event.create', compact('pageTitle', 'business', 'categories','seatingplans', 'flag'));
        else
            return view('business-event.password', compact('flag'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), BusinessEvent::$validater );

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $input = $request->input();

        if ($request->hasFile('banner') ){
            if ($request->file('banner')->isValid())
            {
                $file = $key = md5(uniqid(rand(), true));
                $ext = $request->file('banner')->
                    getClientOriginalExtension();
                $image = $file.'.'.$ext; 
                
                $fileName = $request->file('banner')->move(config('image.banner_image_path').'event/', $image);

                $command = 'ffmpeg -i '.config('image.banner_image_path').'event/'.$image.' -vf scale='.config('image.small_thumbnail_width').':-1 '.config('image.banner_image_path').'event/thumbnails/small/'.$image;
                shell_exec($command); 

                $command = 'ffmpeg -i '.config('image.banner_image_path').'/event/'.$image.' -vf scale='.config('image.medium_thumbnail_width').':-1 '.config('image.product_image_path').'event/thumbnails/medium/'.$image;
                shell_exec($command);

                $command = 'ffmpeg -i '.config('image.banner_image_path').'event/'.$image.' -vf scale='.config('image.large_thumbnail_width').':-1 '.config('image.product_image_path').'event/thumbnails/large/'.$image;
                shell_exec($command);
            }
        }
        
        $business = UserBusiness::whereUserId(Auth::id())->first();

        $event = array_intersect_key($request->input(), BusinessEvent::$updatable);

        $event['user_id'] = Auth::id();
        $event['business_id'] = $business->id;
        $event['event_category_id'] =$input['event_category_id'];
        $event['description'] = $input['description'];
        $event['start_date_time'] = date('Y-m-d H:i:s', strtotime($input['start_date_time']));
        $event['end_date_time'] = date('Y-m-d H:i:s', strtotime($input['end_date_time']));
        $event['banner'] = $image;
        $event['address'] = $input['house'] . ',' . $input['address'];
         
        $event = BusinessEvent::create($event);

        $event->save();

        $seating_plan['user_id'] = Auth::id();
        $seating_plan['business_id'] = $business->id;
        $seating_plan['business_event_id'] = $event->id;
        if(isset($input['seating_plan']))
        {
            foreach ($input['seating_plan'] as $key => $value) {
                if(isset($value) and $value!="" and $value!=0)
                {
                    $seating_plan['event_seating_plan_id'] = $key;
                    $seating_plan['total_seat_available'] = $value;
                    $seating_plan['per_ticket_price'] = $input['seating_plan_price'][$key];
                    $seating_plan['seating_plan_alias'] = $input['seating_plan_alias'][$key];
                    $business_event_seats = array_intersect_key($seating_plan, BusinessEventSeat::$updatable);
                    $business_event_seats = BusinessEventSeat::create($business_event_seats);
                    $business_event_seats->save();
                }
            }
        }
        
        $event->slug = Helper::slug($event->name, $event->id);
        $event->event_log_id = 'EVE' . str_pad($event->id, 4, '0', STR_PAD_LEFT);
        $event->save();
        
        $source = 'event';
        $this->businessNotification->saveNotification($business->id, $source);

        return redirect('business-event')->with('success', 'Your event is successfully created & Active. Its auto publish and currently displaying in the selected category');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $event = BusinessEvent::whereId($id)->first();
        $pageTitle = "Business Event - ".$event->name;
        $eventSeatingPlans = EventSeatingPlan::where('is_blocked', 0)->get();
        $soldEventTickets = SoldEventTicket::where('business_event_id',$event->id)->where('business_id',$event->business_id)->get();
        $ticket_details = DB::table('sold_event_tickets as SET')
            ->join('users as U','U.id','SET.user_id')
            ->join('business_events as BE','BE.id','SET.business_event_id')
            ->groupBy('SET.event_transaction_id','SET.user_id','SET.created_at')
            ->select("*","SET.user_id",DB::raw("SUM(SET.total_tickets_price) as totalprice"),DB::raw("SUM(SET.total_tickets_buyed) as total_ticket"),DB::raw("GROUP_CONCAT(SET.event_seating_plan_id SEPARATOR ',') as seating_plans"))
            ->where('business_event_id',$event->id)
            ->get();
            //var_dump($ticket_details);dd();
        $flag=0;
        return view('business-event.view', compact('pageTitle', 'event', 'eventSeatingPlans','soldEventTickets', 'ticket_details', 'flag'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pageTitle = "Business Product-Edit";
        $event = BusinessEvent::find($id);
        $categories = EventCategory::where('is_blocked',0)->get();
        $seatingplans = EventSeatingPlan::get();
        $flag=0;
        $business_event_seats = BusinessEventSeat::where('business_event_id',$id)->get();
        return view('business-event.edit',compact('pageTitle','event', 'categories','seatingplans','business_event_seats', 'flag'));
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
        $validator = Validator::make($request->all(),BusinessEvent::$updateValidater);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $input = $request->input();

        if ($request->hasFile('banner') ){
            if ($request->file('banner')->isValid())
            {
                $file = $key = md5(uniqid(rand(), true));
                $ext = $request->file('banner')->
                    getClientOriginalExtension();
                $image = $file.'.'.$ext; 
                
                $fileName = $request->file('banner')->move(config('image.banner_image_path').'event/', $image);

                $command = 'ffmpeg -i '.config('image.banner_image_path').'event/'.$image.' -vf scale='.config('image.small_thumbnail_width').':-1 '.config('image.banner_image_path').'event/thumbnails/small/'.$image;
                shell_exec($command); 
                
                $command = 'ffmpeg -i '.config('image.banner_image_path').'event/'.$image.' -vf scale='.config('image.medium_thumbnail_width').':-1 '.config('image.banner_image_path').'event/thumbnails/medium/'.$image;
                shell_exec($command);

                $command = 'ffmpeg -i '.config('image.banner_image_path').'event/'.$image.' -vf scale='.config('image.large_thumbnail_width').':-1 '.config('image.banner_image_path').'event/thumbnails/large/'.$image;
                shell_exec($command);
            }
        }
        $input['address'] = $input['house'] . ',' . $input['address'];
        $input = array_intersect_key($input, BusinessEvent::$updatable);
        
        $input['start_date_time'] = date('Y-m-d H:i:s', strtotime($input['start_date_time']));
        $input['end_date_time'] = date('Y-m-d H:i:s', strtotime($input['end_date_time']));
        

        if(isset($fileName)) {
            $input['banner'] =  $image;
            $event = BusinessEvent::where('id',$id)->update($input);
        } else {
            $event = BusinessEvent::where('id',$id)->update($input);
        }
        $seating_plan_price = $request->input('seating_plan_price');
        $event = BusinessEvent::where('id',$id)->first();
        $seating_plan['user_id'] = Auth::id();
        $seating_plan['business_id'] = $event->business_id;
        $seating_plan['business_event_id'] = $event->id;
        $search = $seating_plan;
        if($request->input('seating_plan')!="")
        {
            foreach ($request->input('seating_plan_alias') as $key => $value) {
                $search['event_seating_plan_id'] = $seating_plan['event_seating_plan_id'] =  $key;
                if(isset($request->input('seating_plan')[$key]) and $request->input('seating_plan')[$key]!="" and $request->input('seating_plan')[$key]!=0)
                {
                    $seating_plan['total_seat_available'] = $request->input('seating_plan')[$key];
                    $seating_plan['per_ticket_price'] = $seating_plan_price[$key];
                    $seating_plan['seating_plan_alias'] = $request->input('seating_plan_alias')[$key];
                    if($value!="" and $value!=null)
                    {
                        $row = BusinessEventSeat::where($search)->first();
                        $event_seats = array_intersect_key($seating_plan, BusinessEventSeat::$updatable);
                        if($row)
                        {
                            $event_seats = BusinessEventSeat::where('id',$row->id)->update($event_seats);
                            
                        }else
                        {
                            $event_seats = BusinessEventSeat::create($event_seats);
                            $event_seats->save();
                        }
                    }else
                    {
                        $row = BusinessEventSeat::where($search)->first();
                        if($row)
                        {
                            $row->delete();
                        }
                    }
                }else
                {
                    BusinessEventSeat::where($search)->forceDelete();
                }
            }
        }
        return redirect('business-event')->with('success', 'Event updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $event = BusinessEvent::findOrFail($id);

        if($event->delete()){
            $response = array(
                'status' => 'success',
                'message' => 'Event deleted  successfully',
            );
        } else {
            $response = array(
                'status' => 'error',
                'message' => 'Event can not be deleted.Please try again',
            );
        }

        return json_encode($response);
    }

    public function exportToCsv(Request $request, $eventId)
    {
        //var_dump($request->input());dd();
        $input = $request->input();//var_dump($input);dd();
        $index = (--$input['index']);
        $limit = $input['limit'];

        $fields = array();
        foreach ($input['fields'] as $key => $value) {
            $fields[$value] = $value;
        }
        $fields = array_intersect_key($fields, User::$downloadable);
        
        $event = BusinessEvent::where('id',$eventId)->where('is_blocked',0)->first();
        if($event->total_seats!=0 and $event->total_seats!=null)
        {
            if($limit == '') {
                $eventTickets = EventTicket::groupBy('event_transaction_id')->where('event_id',$eventId)->skip($index)->get()->toArray();
            }else
            {
                $eventTickets = EventTicket::groupBy('event_transaction_id')->where('event_id',$eventId)->skip($index)->take($limit)->get()->toArray();
            }
            
            $users = array();
            $k=0;
            foreach ($eventTickets as $eventTicket) {
                $users[$k] = User::select($fields)->where('id',$eventTicket['user_id'])->get()->toArray()[0];
                $users[$k]['no_of_seats'] = EventTicket::where('event_id',$eventId)->where('user_id',$eventTicket['user_id'])->count();
                $k++;
            }
            
            $fields['no_of_seats'] = 'no_of_seats';
            $delimiter=",";
            
            $filename = "export".time().".csv";

            header('Content-Type: application/csv; charset=utf-8');
            header('Content-Disposition: attachment; filename="'.$filename.'";');

            $f = fopen('php://output', 'w');
            fputcsv($f, $fields, $delimiter);

            foreach ($users as $line) { 
                // generate csv lines from the inner arrays
                fputcsv($f, $line, $delimiter); 
            }
        }else
        {
            if($limit == '') {
                $users = User::select($fields)->leftJoin('event_participants', 'users.id', '=', 'event_participants.user_id')->where('event_participants.event_id',$eventId)->get()->toArray();

            } else {
                $users = User::select($fields)->leftJoin('event_participants', 'users.id', '=', 'event_participants.user_id')->where('event_participants.event_id',$eventId)->skip($index)->take($limit)->get()->toArray();
            }

            $delimiter=",";

            $filename = "export".time().".csv";

            header('Content-Type: application/csv; charset=utf-8');
            header('Content-Disposition: attachment; filename="'.$filename.'";');

            $f = fopen('php://output', 'w');
            fputcsv($f, $fields, $delimiter);

            foreach ($users as $line) { 
                // generate csv lines from the inner arrays
                fputcsv($f, $line, $delimiter); 
            }
        }
        
    }

    //create event password
    public function createEventPassword(Request $request)
    {
        $input = $request->input();
        $user = User::find(Auth::id());
        $user->event_password = bcrypt($input['event_password']);

        if($user->save())
            return back()->with('success', 'Event Password created successfully.Now you can add your event.');
    }

    //create event password
    public function changeEventPassword()
    {
        $flag = 0;
        return view('business-event.update-password', compact('flag'));
    }

    //Update event password
    public function updateEventPassword(Request $request)
    {
        $validator = Validator::make($request->input(), [
            'event_old_password' => 'required|min:6',
            'event_new_password' => 'required|min:6',
            'confirm_password' => 'required|min:6|same:event_new_password',    
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $user = User::find(Auth::id());

        if (Hash::check($request->input('event_old_password'), Auth::user()->event_password)) {
            
            $user->event_password = bcrypt($request->input('event_new_password'));
            $user->save();

            return redirect('business-event')->with('success', 'Event Password updated successfully.');
        } else {

            $validator->errors()->add('old_event_password', 'Old  event password does not match.Please try again');
            
            return back()->withErrors($validator);
        }
    }
}