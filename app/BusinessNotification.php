<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\UserBusiness;
use App\BusinessLike;
use App\BusinessFollower;
use App\UserNotification;

class BusinessNotification extends Model
{
    protected $fillable = ['user_id', 'business_id', 'source', 'message'];

    public function saveNotification($businessId, $source)
    {
    	$business = UserBusiness::whereId($businessId)->first();

    	$notification = new BusinessNotification();

        $notification->user_id = $business->user_id;
        $notification->business_id = $businessId;
        $notification->source = $source;
        $notification->message = $business->title." "."created new"." ".$source.".";
        $notification->save();
        $user_id1 = BusinessLike::whereBusinessId($businessId)->pluck('user_id');
        $user_id2 = BusinessFollower::whereBusinessId($businessId)->pluck('user_id');
        $user_id = $user_id1->merge($user_id2)->unique()->toArray();
        $fcm_tokens = FcmUser::whereIn('user_id', $user_id)->pluck('fcm_reg_id')->toArray();
        foreach ($user_id as $value) {
            $userNotification = UserNotification::where('user_id', $value)->first();
            if($userNotification)
            {
                $userNotification->business_notification_id = $userNotification->business_notification_id.','.$notification->id;
                $userNotification->save();
            }else
            {
                $input['user_id'] = $value;
                $input['business_notification_id'] = $notification->id;

                $userNotification = array_intersect_key($input, UserNotification::$updatable);
                $userNotification = UserNotification::create($userNotification);
                $userNotification->save();
            }
        }
        $res = $this->sendPushNotificationToFCM($fcm_tokens,$notification->message);
    }

    public function saveNotificationMessage($businessId, $source, $message)
    {
        $business = UserBusiness::whereId($businessId)->first();

        $notification = new BusinessNotification();

        $notification->user_id = $business->user_id;
        $notification->business_id = $businessId;
        $notification->source = $source;
        $notification->message = $message;
        $notification->save();
        $user_id = BusinessFollower::whereBusinessId($businessId)->pluck('user_id')->toArray();
        if(count($user_id)>0)
        {
            foreach ($user_id as $value) {
                $userNotification = UserNotification::where('user_id', $value)->first();
                if($userNotification)
                {
                    $userNotification->business_notification_id = $userNotification->business_notification_id.','.$notification->id;
                    $userNotification->save();
                }else
                {
                    $input['user_id'] = $value;
                    $input['business_notification_id'] = $notification->id;

                    $userNotification = array_intersect_key($input, UserNotification::$updatable);
                    $userNotification = UserNotification::create($userNotification);
                    $userNotification->save();
                }
            }
            $fcm_tokens = FcmUser::whereIn('user_id', $user_id)->pluck('fcm_reg_id')->toArray();

            $res = $this->sendPushNotificationToFCM($fcm_tokens,$notification->message);

            return "Message Sent Successfully";
        }else
        {
            return "No follower found";
        }
    }


    public function sendPushNotificationToFCM($registation_ids, $message) {

        //Google cloud messaging GCM-API url
        $url = 'https://fcm.googleapis.com/fcm/send';

        $notification = array("body" => $message, "title" => 'WeAfrican Business Notification', "click_action" => "", 'sound'=>"default");

        $data = array("body" => $message, "title" => 'WeAfrican Business Notification', "click_action" => "", 'sound'=>"default");

        $fields = array(
            'registration_ids' => $registation_ids,
            "priority" => "high",
            'notification' => $notification,
            'data' => $data
        );

        $headers = array(
            'Authorization: key=' . env('FIREBASE_API_KEY'),
            'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        if ($result === FALSE) {
        die('FCM Send Error: ' . curl_error($ch));
        }
        curl_close($ch);
        return $result;
    }
}