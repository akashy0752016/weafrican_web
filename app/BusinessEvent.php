<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\UserBusiness;
use App\SoldEventTicket;
use App\BusinessNotification;
use App\User;
use Carbon\Carbon;
use App\EventTicket;
use Validator;
use DB;
use Session;
use App\Helper;

class BusinessEvent extends Model
{
	use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = ['user_id', 'business_id', 'event_category_id', 'name', 'keywords', 'slug', 'description', 'organizer_name', 'address', 'start_date_time', 'end_date_time', 'banner', 'city', 'state', 'country', 'pin_code', 'latitude', 'longitude', 'total_seats', 'start_date', 'end_date', 'event_log_id'];

    public static $updatable = ['user_id' => "", 'business_id' => "", 'event_category_id' => "", 'name' => "" , 'keywords' => "", 'slug' => "", 'description' => "", 'organizer_name' => "", 'address' => "", 'start_date_time' => "", 'end_date_time' => "", 'banner' => "", 'city' => "", 'state' => "", 'country' => "", 'pin_code' => "", 'latitude' => "", 'longitude' => "", 'total_seats' => "", 'start_date' => "", 'end_date' => "", 'event_log_id' => ""];

    public static $validater = array(
        'event_category_id' => 'required',
        'name' => 'required|max:255',
    	'keywords' => 'required|max:255',
        'description' => 'required',
    	'organizer_name' => 'required',
    	'address' => 'required',
        'start_date_time' => 'required',
        'end_date_time' => 'required',
        'city' => 'required',
        'pin_code' => 'required',
        'address' => 'required',
        'banner' => 'required|image|mimes:jpg,png,jpeg',
	);

    public static $updateValidater = array(
        'event_category_id' => 'required',
    	'name' => 'required|max:255',
        'keywords' => 'required|max:255',
        'description' => 'required',
        'organizer_name' => 'required',
        'address' => 'required',
        'start_date_time' => 'required',
        'end_date_time' => 'required',
        'city' => 'required',
        'address' => 'required',
        'banner' => 'image|mimes:jpg,png,jpeg',
	);

    public function seatingPlan($id,$event_id)
    {
        $businessEventSeats = BusinessEventSeat::where('business_event_id',$event_id)->where('event_seating_plan_id',$id)->first();
        if(isset($businessEventSeats) and $businessEventSeats->seating_plan_alias!="" and $businessEventSeats->seating_plan_alias!=NULL)
        {
            return BusinessEventSeat::where('business_event_id',$event_id)->where('event_seating_plan_id',$id)->first()->seating_plan_alias;
        }elseif(EventSeatingPlan::where('id', $id)->first())
        {
            return EventSeatingPlan::where('id', $id)->first()->title;
        }else
        {
            return 0;
        }
    }

    public function soldTicket($user_id,$business_event_id,$transaction_id,$event_seating_plan_id)
    {
        if(SoldEventTicket::where(array('user_id'=>$user_id,'business_event_id'=>$business_event_id,'event_transaction_id'=>$transaction_id,'event_seating_plan_id'=>$event_seating_plan_id))->first())
        {
            return SoldEventTicket::where(array('user_id'=>$user_id,'business_event_id'=>$business_event_id,'event_transaction_id'=>$transaction_id,'event_seating_plan_id'=>$event_seating_plan_id))->first();
        }else
        {
            return 0;
        }
    }

    public function soldEventTickets()
    {
        return $this->hasMany('App\SoldEventTicket','business_event_id');
    }

    public function category()
    {
        return $this->belongsTo('App\EventCategory','event_category_id');
    }

    public function participations()
    {
        return $this->hasMany('App\EventParticipant','event_id');
    }

    public function eventSeatingPlans()
    {
        return $this->hasMany('App\BusinessEventSeat','business_event_id');
    }

    public function business()
    {
        return $this->belongsTo('App\UserBusiness','business_id','id');
    }

    public function getTotalNumberofParticipants()
    {
        return $this->hasMany('App\EventTicket','event_id','id');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function apiGetBusinessEvents($input)
    {
        date_default_timezone_set ($input['timezone']);
        $first_day_this_month = date('Y-m-01');
        $last_day_this_month  = date('Y-m-d');
        $current_day_this_month  = date('Y-m-d'); 
        $currentDateTime = date("Y-m-d H:i:s");
            
        if (isset($input['latitude']) && isset($input['longitude']) && isset($input['radius'])) {

            $top = 'SELECT id,event_log_id,user_id,business_id,event_category_id,name,keywords,slug,description,organizer_name,start_date_time,end_date_time,banner,address,city,state,country,pin_code,latitude,longitude,total_seats,is_blocked,mobile_number, distance_in_km,is_top,planPurchaseDate FROM (';

            $subscribed = 'SELECT be.*,usp.created_at as planPurchaseDate,u.mobile_number, 1 AS is_top, p.distance_unit * DEGREES( ACOS( COS( RADIANS( p.latpoint ) ) * COS( RADIANS(be.latitude ) ) * COS( RADIANS( p.longpoint ) - RADIANS( be.longitude ) ) + SIN( RADIANS( p.latpoint ) ) * SIN( RADIANS( be.latitude ) ) ) ) AS distance_in_km FROM business_events AS be INNER JOIN user_businesses as ub ON be.user_id=ub.user_id INNER JOIN users AS u ON u.id=be.user_id LEFT JOIN (SELECT '.$input['latitude'].' AS latpoint, '.$input['longitude'].' AS longpoint, '.$input['radius'].' AS radius, 111.045 AS distance_unit) AS p ON 1 =1 LEFT JOIN user_subscription_plans as usp ON be.user_id = usp.user_id INNER JOIN event_banners as eb ON eb.user_subscription_plan_id=usp.id WHERE be.latitude BETWEEN p.latpoint - ( p.radius / p.distance_unit ) AND p.latpoint + ( p.radius / p.distance_unit ) AND be.longitude BETWEEN p.longpoint - ( p.radius / ( p.distance_unit * COS( RADIANS( p.latpoint ) ) ) ) AND p.longpoint + ( p.radius / ( p.distance_unit * COS( RADIANS( p.latpoint ) ) ) ) AND be.is_blocked=0 AND be.end_date_time >= "'.$currentDateTime.'" AND usp.is_expired=0 AND usp.subscription_date<= "'.$current_day_this_month.'" AND usp.expired_date>= "'.$current_day_this_month.'" AND usp.status="success" AND usp.subscription_plan_id>=7 AND usp.subscription_plan_id<=10 AND (be.deleted_at IS NULL OR be.deleted_at = "") AND be.is_blocked=0 AND (ub.deleted_at IS NULL OR ub.deleted_at = "") AND ub.is_blocked=0 AND ub.is_identity_proof_validate=1 AND ub.is_business_proof_validate=1 ';
            $unsubscribed = 'SELECT be.*,NULL as planPurchaseDate, u.mobile_number, 0 AS is_top, p.distance_unit * DEGREES( ACOS( COS( RADIANS( p.latpoint ) ) * COS( RADIANS(be.latitude ) ) * COS( RADIANS( p.longpoint ) - RADIANS( be.longitude ) ) + SIN( RADIANS( p.latpoint ) ) * SIN( RADIANS( be.latitude ) ) ) ) AS distance_in_km FROM business_events AS be INNER JOIN user_businesses as ub ON be.user_id=ub.user_id INNER JOIN users AS u ON u.id=be.user_id LEFT JOIN (SELECT '.$input['latitude'].' AS latpoint, '.$input['longitude'].' AS longpoint, '.$input['radius'].' AS radius, 111.045 AS distance_unit) AS p ON 1 =1 WHERE be.latitude BETWEEN p.latpoint - ( p.radius / p.distance_unit ) AND p.latpoint + ( p.radius / p.distance_unit ) AND be.longitude BETWEEN p.longpoint - ( p.radius / ( p.distance_unit * COS( RADIANS( p.latpoint ) ) ) ) AND p.longpoint + ( p.radius / ( p.distance_unit * COS( RADIANS( p.latpoint ) ) ) ) AND be.is_blocked=0 AND be.end_date_time >= "'.$currentDateTime.'"AND (be.deleted_at IS NULL OR be.deleted_at = "") AND be.is_blocked=0 AND (ub.deleted_at IS NULL OR ub.deleted_at = "") AND ub.is_blocked=0 AND ub.is_identity_proof_validate=1 AND ub.is_business_proof_validate=1 ';
            if(isset($input['eventCategoryId']))
            {
                $subscribed = $subscribed . 'AND (eb.event_category_id="'.$input['eventCategoryId'].'" OR be.event_category_id="'.$input['eventCategoryId'].'") AND ((eb.country="'.$input['country'].'" AND eb.state="'.$input['state'].'" AND eb.city="'.$input['city'].'") OR (be.country="'.$input['country'].'" AND be.state="'.$input['state'].'" AND be.city="'.$input['city'].'"))';

                $unsubscribed = $unsubscribed . 'AND be.event_category_id="'.$input['eventCategoryId'].'" ';
            }
            if(isset($input['country']))
            {
                //$subscribed = $subscribed . 'AND eb.country="'.$input['country'].'" ';
                $unsubscribed = $unsubscribed . 'AND be.country="'.$input['country'].'" ';
            }
            if(isset($input['state']))
            {
                //$subscribed = $subscribed . 'AND eb.state="'.$input['state'].'" ';
                $unsubscribed = $unsubscribed . 'AND be.state="'.$input['state'].'" ';   
            }
            if(isset($input['city']))
            {
                //$subscribed = $subscribed . 'AND eb.city="'.$input['city'].'" ';
                $unsubscribed = $unsubscribed . 'AND be.city="'.$input['city'].'" ';   
            }
            $subscribed = $top . $subscribed . ') as subscribed';
            $unsubscribed = $top . $unsubscribed . ') as unsubscribed';
            $query = 'SELECT * FROM (' . $subscribed . ' UNION ' . $unsubscribed . ') as business_list GROUP BY id ORDER BY is_top DESC,distance_in_km ASC,start_date_time ASC, id DESC, planPurchaseDate DESC LIMIT '.$input['index'].','.$input['limit'].'';
            
            $events = DB::select($query);
        } else { 
            $top = 'SELECT id,event_log_id,user_id,business_id,event_category_id,name,keywords,slug,description,organizer_name,start_date_time,end_date_time,banner,address,city,state,country,pin_code,latitude,longitude,total_seats,is_blocked,mobile_number,is_top, planPurchaseDate FROM (';
            $subscribed = 'SELECT be.*, usp.created_at as planPurchaseDate,u.mobile_number, 1 AS is_top FROM business_events AS be INNER JOIN user_businesses as ub ON be.user_id=ub.user_id INNER JOIN users AS u ON u.id=be.user_id LEFT JOIN user_subscription_plans as usp ON be.user_id = usp.user_id LEFT JOIN event_banners as eb ON eb.user_subscription_plan_id=usp.id WHERE be.is_blocked=0 AND be.end_date_time >= "'.$currentDateTime.'" AND usp.is_expired=0 AND usp.subscription_date<= "'.$current_day_this_month.'" AND usp.expired_date>= "'.$current_day_this_month.'" AND usp.status="success" AND usp.subscription_plan_id>=7 AND usp.subscription_plan_id<=10 AND eb.business_event_id=be.id AND (be.deleted_at IS NULL OR be.deleted_at = "") AND be.is_blocked=0 AND (ub.deleted_at IS NULL OR ub.deleted_at = "") AND ub.is_blocked=0 AND ub.is_identity_proof_validate=1 AND ub.is_business_proof_validate=1 ';
            $unsubscribed = 'SELECT be.*,NULL as planPurchaseDate, u.mobile_number, 0 AS is_top FROM business_events AS be INNER JOIN user_businesses as ub ON be.user_id=ub.user_id INNER JOIN users AS u ON u.id=be.user_id WHERE be.is_blocked=0 AND be.end_date_time >= "'.$currentDateTime.'" AND (be.deleted_at IS NULL OR be.deleted_at = "") AND be.is_blocked=0 AND (ub.deleted_at IS NULL OR ub.deleted_at = "") AND ub.is_blocked=0 AND ub.is_identity_proof_validate=1 AND ub.is_business_proof_validate=1 ';
            if(isset($input['eventCategoryId']))
            {
                $subscribed = $subscribed . 'AND (eb.event_category_id="'.$input['eventCategoryId'].'" OR be.event_category_id="'.$input['eventCategoryId'].'") AND ((eb.country="'.$input['country'].'" AND eb.state="'.$input['state'].'" AND eb.city="'.$input['city'].'") OR (be.country="'.$input['country'].'" AND be.state="'.$input['state'].'" AND be.city="'.$input['city'].'"))';
                $unsubscribed = $unsubscribed . 'AND be.event_category_id="'.$input['eventCategoryId'].'" ';
            }
            if(isset($input['country']))
            {
               // $subscribed = $subscribed . 'AND eb.country="'.$input['country'].'" ';
                $unsubscribed = $unsubscribed . 'AND be.country="'.$input['country'].'" ';
            }
            if(isset($input['state']))
            {
                //$subscribed = $subscribed . 'AND eb.state="'.$input['state'].'" ';
                $unsubscribed = $unsubscribed . 'AND be.state="'.$input['state'].'" ';   
            }
            if(isset($input['city']))
            {
                //$subscribed = $subscribed . 'AND eb.city="'.$input['city'].'" ';
                $unsubscribed = $unsubscribed . 'AND be.city="'.$input['city'].'" ';   
            }
            $subscribed = $top . $subscribed . ') as subscribed';
            $unsubscribed = $top . $unsubscribed . ') as unsubscribed';
            $query = 'SELECT * FROM (' . $subscribed . ' UNION ' . $unsubscribed . ') as business_list GROUP BY id ORDER BY is_top DESC, start_date_time ASC, id DESC,planPurchaseDate DESC LIMIT '.$input['index'].','.$input['limit'].'';
            
            $events = DB::select($query); //var_dump($query);dd();
        }
        $event = array();
        $user = User::whereId($input['userId'])->first();
        foreach ($events as $key => $value) {
            
            $value = (array)$value;
            $value['seating_plans'] = BusinessEventSeat::where('business_event_id',$value['id'])
            ->select('id','event_seating_plan_id','seating_plan_alias','total_seat_available','per_ticket_price', 'seat_buyed')
            ->get();
            $k=0;
            $seats_plans = array();
            foreach ($value['seating_plans'] as $key => $value1) {
                $seats_plans[$k]['id'] = $value1->id;
                $seats_plans[$k]['event_seating_plan_id'] = $value1->event_seating_plan_id;
                $seats_plans[$k]['seating_plan_alias'] = $value1->seating_plan_alias;
                $seats_plans[$k]['total_seat_available'] = $value1->total_seat_available;
                $seats_plans[$k]['per_ticket_price'] = number_format($value1->per_ticket_price,2, '.', '');
                $seats_plans[$k]['user_per_ticket_price'] = (isset($user) && ($user->currency != null) && ($user->currency != 'NGN')) ? number_format(Helper::convertCurrency('NGN', $user->currency, number_format($value1->per_ticket_price,2, '.', '')),2,'.', '') : number_format($value1->per_ticket_price,2, '.', '');
                $seats_plans[$k]['user_currency'] = (isset($user) && ($user->currency != null)) ? $user->currency : 'NGN';
                $seats_plans[$k]['seat_buyed'] = $value1->seat_buyed;
                if($value1->seat_buyed!=null and $value1->seat_buyed!="")
                {
                    $seats_plans[$k]['seat_left'] = $value1->total_seat_available-$value1->seat_buyed;
                    $value['total_seats'] = $value['total_seats']-$value1->seat_buyed;
                }else
                {
                    $seats_plans[$k]['seat_left'] = $value1->total_seat_available;
                }
                
                $k++;
            }
            $value['seating_plans'] = $seats_plans;
            $event[] = $value;
        }
        return $event;
    }

    public function apiGetUserBusinessEvents($input)
    {
        $event = DB::table('business_events as be')
        ->select('be.*',DB::raw('(SELECT title FROM event_categories as ec where ec.id=be.event_category_id) as event_category'))
        ->where('user_id',$input['userId'])
        ->where('is_blocked',0)
        ->where('deleted_at',NULL)
        ->orderBy('created_at', 'DESC')
        ->get();
        $temp = array();
        foreach ($event as $value) {
            $value = (array)$value;
            $value['seating_plans'] = array();

            $seats = BusinessEventSeat::where('business_event_id',$value['id'])
            ->select('id','event_seating_plan_id','seating_plan_alias','total_seat_available','per_ticket_price', 'seat_buyed', 'business_event_id')
            ->get();
            if($seats)
            {
                $k=0;
                foreach ($seats as $key => $value1) {
                    $value['seating_plans'][$k]['id'] = $value1->id;
                    $value['seating_plans'][$k]['event_seating_plan_id'] = $value1->event_seating_plan_id;
                    $value['seating_plans'][$k]['seating_plan_alias'] = $value1->seating_plan_alias;
                    $value['seating_plans'][$k]['total_seat_available'] = $value1->total_seat_available;
                    $value['seating_plans'][$k]['per_ticket_price'] = number_format($value1->per_ticket_price,2, '.', '');
                    $value['seating_plans'][$k]['seat_buyed'] = $value1->seat_buyed;
                    $value['seating_plans'][$k]['business_event_id'] = $value1->business_event_id;
                    $k++;
                }
            }else
            {
                $value['seating_plans'] = array();                
            }

            $temp[] = $value; 
        }
        return $temp;
    }

    public function apiPostUserEvent($input)
    {
       $validator = Validator::make($input, [
            'userId' => 'required',
            'businessId' => 'required',
            'eventCategoryId' => 'required',
            'name' => 'required',
            'keywords' => 'required',
            'description' => 'required',
            'organizerName' => 'required',
            'address' => 'required',
            'startDateTime' => 'required',
            'endDateTime' => 'required',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',
            'pincode' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        if ($validator->fails()) {
            if (count($validator->errors()) <= 1) {
                return response()->json(['status' => 'exception','response' => $validator->errors()->first()]);   
            } else {
                return response()->json(['status' => 'exception','response' => 'All fields are required']);   
            }
        }

        if (isset($input['eventId'])) {

            if (isset($input['eventBanner']) && !empty($input['eventBanner'])) {

                $data = $input['eventBanner'];

                $img = str_replace('data:image/jpeg;base64,', '', $data);
                $img = str_replace(' ', '+', $img);

                $data = base64_decode($img);

                $fileName = md5(uniqid(rand(), true));

                $image = $fileName.'.'.'png';

                $file = config('image.banner_image_path').'event/'.$image;

                $success = file_put_contents($file, $data);

                $command = 'ffmpeg -i '.config('image.banner_image_path').'event/'.$image.' -vf scale='.config('image.small_thumbnail_width').':-1 '.config('image.banner_image_path').'event/thumbnails/small/'.$image;
                shell_exec($command); 

                $command = 'ffmpeg -i '.config('image.banner_image_path').'/event/'.$image.' -vf scale='.config('image.medium_thumbnail_width').':-1 '.config('image.product_image_path').'event/thumbnails/medium/'.$image;
                shell_exec($command);

                $command = 'ffmpeg -i '.config('image.banner_image_path').'event/'.$image.' -vf scale='.config('image.large_thumbnail_width').':-1 '.config('image.product_image_path').'event/thumbnails/large/'.$image;
                shell_exec($command);
            }

            $input['user_id'] = $input['userId'];
            $input['business_id'] = $input['businessId'];   
            $input['event_category_id'] = $input['eventCategoryId'];
            $input['organizer_name'] = $input['organizerName'];
            $input['pin_code'] = $input['pincode'];
            $input['start_date_time'] = date('Y-m-d H:i:s', strtotime($input['startDateTime']));
            $input['end_date_time'] = date('Y-m-d H:i:s', strtotime($input['endDateTime']));

            if (isset($image)) {
                $input['banner'] =  $image;
            } 
            
            $event = array_intersect_key($input, BusinessEvent::$updatable);
           
            $event = BusinessEvent::where('id', $input['eventId'])->update($event);

            if($event)
                return response()->json(['status' => 'success','response' => "Event updated successfully."]);
            else
                return response()->json(['status' => 'failure','response' => "Event could not updated successfully.Please try again."]);
        }else{

            if(isset($input['eventBanner']) && !empty($input['eventBanner']))
            {
                $data = $input['eventBanner'];

                $img = str_replace('data:image/jpeg;base64,', '', $data);
                $img = str_replace(' ', '+', $img);

                $data = base64_decode($img);

                $fileName = md5(uniqid(rand(), true));

                $image = $fileName.'.'.'png';

                $file = config('image.banner_image_path').'event/'.$image;

                $success = file_put_contents($file, $data);

                $command = 'ffmpeg -i '.config('image.banner_image_path').'event/'.$image.' -vf scale='.config('image.small_thumbnail_width').':-1 '.config('image.banner_image_path').'event/thumbnails/small/'.$image;
                shell_exec($command); 

                $command = 'ffmpeg -i '.config('image.banner_image_path').'/event/'.$image.' -vf scale='.config('image.medium_thumbnail_width').':-1 '.config('image.product_image_path').'event/thumbnails/medium/'.$image;
                shell_exec($command);

                $command = 'ffmpeg -i '.config('image.banner_image_path').'event/'.$image.' -vf scale='.config('image.large_thumbnail_width').':-1 '.config('image.product_image_path').'event/thumbnails/large/'.$image;
                shell_exec($command);
            }

            $event = array_intersect_key($input, BusinessEvent::$updatable);
            $event['user_id'] = $input['userId'];
            $event['business_id'] = $input['businessId'];
            $event['event_category_id'] = $input['eventCategoryId'];
            $event['organizer_name'] = $input['organizerName'];
            $event['pin_code'] = $input['pincode'];

            $event['start_date_time'] = date('Y-m-d H:i:s', strtotime($input['startDateTime']));
            $event['end_date_time'] = date('Y-m-d H:i:s', strtotime($input['endDateTime']));

            if(isset($image)) {
                $event['banner'] =  $image;
            } 
            
            $event = BusinessEvent::create($event);
            $event->save();

            $businessNotification = new BusinessNotification();
            $source = 'event';
            $businessNotification->saveNotification($event->business_id, $source);

            $event->slug = Helper::slug($event->name, $event->id);
            $event->event_log_id = 'EVE' . str_pad($event->id, 4, '0', STR_PAD_LEFT);

            if($event->save())
                return response()->json(['status' => 'success','response' => $event]);
            else 
                return response()->json(['status' => 'failure','response' => 'System Error:Event could not be created .Please try later.']);
        }
    }

    public function apiPostEventAttendingUsers($input)
    {
        $check = DB::table('event_participants')->where('user_id',$input['userId'])->where('event_id',$input['eventId'])->first();

        if($check)
        {
            DB::table('event_participants')->where('user_id',$input['userId'])->where('event_id',$input['eventId'])->delete();
            return response()->json(['status' => 'success','response' => 0]);

        } else{
            $event = DB::table('event_participants')->insert(['user_id' => $input['userId'], 'event_id' => $input['eventId'] ]);
            return response()->json(['status' => 'success','response' => 1]);
        }
    }

    public function apiPostEventSeatingPlan(Request $request)
    {
        $input = $request->input();
        $rules = [
            'userId' => 'required',
            'businessId' => 'required',
            'businessEventId' => 'required',
            'total_seats' => 'required',
            'seatingPlan.*.seating_plan_id' => 'sometimes|integer|required',
            'seatingPlan.*.event_seating_plan_id' => 'sometimes|integer|required',
            'seatingPlan.*.seating_plan_alias' => 'sometimes|string|required',
            'seatingPlan.*.seating_plan_seats' => 'sometimes|integer|required',
            'seatingPlan.*.per_ticket_price' => 'sometimes|required',
        ];
        $message = [];$total = 0;
        foreach ($request->input('seatingPlan') as $key => $value) {
            foreach ($value as $key1 => $value1) {  
                if($key1 == 'seating_plan_seats')
                {
                    $total = $total + $value1;
                }
            }
        }
        
        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
            if (count($validator->errors()) <= 1) {
                return response()->json(['status' => 'exception','response' => $validator->errors()->first()]);   
            } else {
                return response()->json(['status' => 'exception','response' => 'All fields are required']);   
            }
        }
        if($total!=$input['total_seats'])
        {
            return response()->json(['status' => 'exception','response' => 'Sum of all the seating plans seat must be equal to the total seats']);
        }

        $event = BusinessEvent::whereId($input['businessEventId'])->where('user_id',$input['userId'])->where('business_id',$input['businessId'])->first();
        if($event)
        {
            $event->total_seats = $input['total_seats'];
            if($event->save())
            {
                $seating_plan['business_event_id'] = $input['businessEventId'];
                $seating_plan['business_id'] = $input['businessId'];
                $seating_plan['user_id'] = $input['userId'];
                $seating_plan_ids = array();

                $addedSeatingPlans = BusinessEventSeat::whereUserId($seating_plan['user_id'])
                    ->whereBusinessId($seating_plan['business_id'])
                    ->where('business_event_id',$seating_plan['business_event_id'])->pluck('id');

                foreach ($request->input('seatingPlan') as $key => $value) {

                    $seating_plan['event_seating_plan_id'] = $value['event_seating_plan_id'];
                    $seating_plan['seating_plan_alias'] = $value['seating_plan_alias'];
                    $seating_plan['seating_plan_seats'] = $value['seating_plan_seats'];
                    $seating_plan['per_ticket_price'] = $value['per_ticket_price'];
                    $seating_plan['total_seat_available'] = $value['seating_plan_seats'];

                    $seatingPlan = BusinessEventSeat::whereUserId($seating_plan['user_id'])
                    ->whereBusinessId($seating_plan['business_id'])
                    ->where('business_event_id',$seating_plan['business_event_id'])
                    ->where('event_seating_plan_id',$seating_plan['event_seating_plan_id'])->first();

                    $event_seats = array_intersect_key($seating_plan, BusinessEventSeat::$updatable);
                    if($seatingPlan and isset($value['seating_plan_id']))
                    {
                        $seating_plan_ids[] = $value['seating_plan_id'];
                        $event_seats = BusinessEventSeat::where('id',$value['seating_plan_id'])->update($event_seats);
                    }else
                    {
                        $event_seats = BusinessEventSeat::create($event_seats);
                        if(!$event_seats->save())
                        {
                            return response()->json(['status' => 'failure','response' => 'Event seating plans cannot be updated please try after some time']);
                        }
                    }
                }
                $seating_plan_ids = array_diff($addedSeatingPlans->toArray(),$seating_plan_ids);
                if(count($seating_plan_ids)>0)
                {
                    $deletedSeatingPlans = BusinessEventSeat::whereUserId($seating_plan['user_id'])
                    ->whereBusinessId($seating_plan['business_id'])
                    ->where('business_event_id',$seating_plan['business_event_id'])
                    ->whereIn('id',$seating_plan_ids)->delete();
                }
                return response()->json(['status' => 'success','response' => 'Event seating added successfully']);
            }else
            {
                return response()->json(['status' => 'failure','response' => 'Event cannot be updated please try after some time']);
            }
        }else
        {
            return response()->json(['status' => 'exception','response' => 'Event dose not exits. Please try again.']);
        }
    }

    public function apiEventLogin($input)
    {
        $event = BusinessEvent::where('event_log_id', $input['eventLogId'])->first();
        if($event)
        {
            if($event->is_blocked==0)
            {
                if (Hash::check($input['password'], $event->user->event_password)) {
                    if($event->business->is_identity_proof_validate && $event->business->is_business_proof_validate)
                    {
                        if($event->total_seats!=Null AND $event->total_seats>0)
                        {
                            $d1 = strtotime(date("Y/m/d",strtotime($event->start_date_time)));
                            $d2 = strtotime(date("Y/m/d",strtotime($event->end_date_time)));
                            $d3 = strtotime(date("Y/m/d"));
                            $st = (int)(($d3 - $d1)/86400);
                            $et = (int)(($d2 - $d3)/86400);
                            /*var_dump($et);dd();*/
                            if(($st>=0 OR $st==-1) AND $et>=0)
                            {
                                $array =  $event->toArray();
                                //$array['user'] = $event->user->toArray(); 
                                $array['total_seats_buyed'] = $event->soldEventTickets->sum('total_tickets_buyed');
                                $array['total_seats_left'] = intval($event->total_seats - $event->soldEventTickets->sum('total_tickets_buyed'));
                                $eventSeatingPlans = EventSeatingPlan::where('is_blocked', 0)->get();
                                $seatingPlan = array();
                                $i=0;
                                foreach ($eventSeatingPlans as $eventSeatingPlan) {
                                    if($eventSeatingPlan->getEventPlanSeats($event->id, $eventSeatingPlan->id)>0)
                                    {
                                        $seatingPlan[$i]['seating_plan_title'] = $eventSeatingPlan->title;
                                        $seatingPlan[$i]['seating_plan_seats'] = $eventSeatingPlan->getEventPlanSeats($event->id, $eventSeatingPlan->id);
                                        $i++;
                                    }
                                }
                                $array['seating_plans'] = $seatingPlan;
                                $array['user_ckecked_in'] = EventTicket::where('event_id',$event->id)->where('attended_status',1)->count();
                                $array['user_left'] = EventTicket::where('event_id',$event->id)->where('attended_status',0)->count();
                                //var_dump($array);dd();
                                return response()->json(['status' => 'success','response' => $array]);
                            }elseif($st<-1)
                            {
                                return response()->json(['status' => 'exception','response' => 'Your Event will be start on '.date("d-M-Y", strtotime($event->start_date_time)).'. And you will be able to log in this section one day before your event start date.']); 
                            }elseif($et<0)
                            {
                                return response()->json(['status' => 'exception','response' => 'Your event has been expired.']);
                            }else
                            {
                                return response()->json(['status' => 'exception','response' => 'Event is not in our records.']);
                            }
                        }else
                        {
                            return response()->json(['status' => 'exception','response' => 'Your Event dose not have any seating plan.']);
                        }
                    }else
                    {
                        return response()->json(['status' => 'exception','response' => 'You cannot login in the Event Section. As your business is not verified by the admin.']); 
                    }
                }else
                {
                    return response()->json(['status' => 'exception','response' => 'Please Enter a valid password to login.']);
                }
            }else
            {
                return response()->json(['status' => 'exception','response' => 'Your Event has been blocked.']);
            }
        }else
        {
            return response()->json(['status' => 'exception','response' => 'These event id do not match with our records.']);
        }
    }
}