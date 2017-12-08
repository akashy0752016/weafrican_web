<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\FcmUser;
use DB;

class UserConversation extends Model
{
	protected $fillable = ['sender_id', 'receiver_id', 'message'];

    public function sender()
    {
        return $this->belongsTo('App\User','sender_id', 'id');
    }

    public function receiver()
    {
        return $this->belongsTo('App\User','receiver_id', 'id');
    }

    public function apiPostUserMessage($input)
    {
    	$conversation = new UserConversation();

    	$conversation->sender_id = $input['senderId'];
    	$conversation->receiver_id = $input['receiverId'];
    	$conversation->message = $input['message'];
    	$conversation->save();
        $receiver = FcmUser::where('user_id',$input['receiverId'])->first();
        if($receiver)
        {
            $result = $this->sendPushNotificationToFCM($receiver->fcm_reg_id,$input['message'],$input['senderId']);
        }
    	return $conversation;
    }

    public function apiGetUserMessage($input)
    {
        if ($input['id'] == -1)
            return null;
        else
    	   return $this->whereSenderId($input['senderId'])->whereReceiverId($input['receiverId'])->where('id', '>', $input['id'])->orderBy('id','asc')->get();
    }

    public function apiGetUserAllMessages($input)
    {
    	return  $this->where(['sender_id' => $input['senderId'], 'receiver_id' => $input['receiverId']])->orWhere(['sender_id' => $input['receiverId'], 'receiver_id' => $input['senderId']])->orderBy('created_at', 'desc')->skip($input['index'])->limit($input['limit'])->get();
    }

    public function apiGetChatUsers($input)
    {
        $userIds = DB::select('SELECT m.* FROM user_conversations m JOIN (SELECT MAX(id) as id, CASE WHEN sender_id = "'.$input['userId'].'" THEN receiver_id WHEN `receiver_id` = "'.$input['userId'].'" THEN sender_id END AS otherUser FROM user_conversations GROUP BY CASE WHEN sender_id = "'.$input['userId'].'" THEN receiver_id WHEN receiver_id = "'.$input['userId'].'" THEN sender_id END ) as other ON m.id = other.id where m.sender_id = "'.$input['userId'].'" or m.receiver_id = "'.$input['userId'].'" order by m.id desc');
        $response = array();
        $object = array();
        foreach ($userIds as $value) {
            $message = $this->where('id','=',$value->id)->orderBy('id', 'DESC')->first();

            $object['message'] = $message->message;
            if ($message->sender_id == $input['userId']) {
                $object['friend_id'] = $message->receiver->id;
                $object['sender_id'] = $message->sender->id;
                $object['receiver_id'] = $message->receiver->id;
                $object['userName'] = $message->receiver->first_name;
                $object['avatar'] = $message->receiver->image;
                $object['id'] = $message->id;
            } else {
                $object['friend_id'] = $message->sender->id;
                $object['sender_id'] = $message->sender->id; 
                $object['receiver_id'] = $message->receiver->id;
                $object['userName'] = $message->sender->first_name;
                $object['avatar'] = $message->sender->image;
                $object['id'] = $message->id;
            }

            $response[] = $object;
        }
        return $response;
    }

    public function apiGetPreviousMessages($input)
    {

        $ids = $this->where(['sender_id' => $input['senderId'], 'receiver_id' => $input['receiverId']])->orWhere(['sender_id' => $input['receiverId'], 'receiver_id' => $input['senderId']])->pluck('id');

       return $this->whereIn('id', $ids)->where('id', '<', $input['index'])->orderBy('id', 'desc')->take($input['limit'])->get();
    }

    public function sendPushNotificationToFCM($registation_id, $message, $senderId) {
        //Google cloud messaging GCM-API url
        $url = 'https://fcm.googleapis.com/fcm/send';
        
        $registation_ids = array();
        $registation_ids[] = $registation_id;
        $notification = array("body" => $message, "title" => 'WeAfrican Chat Notification', "click_action" => "actionCategory",'senderId' => $senderId, 'sound'=>"default");
        $data = array("body" => $message, "title" => 'WeAfrican Chat Notification', "click_action" => "actionCategory",'senderId' => $senderId, 'sound'=>"default");
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