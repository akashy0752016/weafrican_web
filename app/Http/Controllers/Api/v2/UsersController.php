<?php

namespace App\Http\Controllers\Api\v2;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\User;
use Validator;

class UsersController extends Controller
{
    /**
     * Function: Add user event password
     * Url: api/v2/create/event-password
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function eventPassword(Request $request) 
    {
    	$input = $request->input();
    	$validator = Validator::make($input, [
                'userId' => 'required',
                'eventPassword' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'exception','response' => $validator->errors()->first()]);   
        }

        $user = User::whereId($input['userId'])->first();

        if ($user->event_password == Null || $user->event_password == "") {

            if($user->update(['event_password' => bcrypt($input['eventPassword'])]))
                return response()->json(['status' => 'success','response' =>'Event password created successfully']);
            else
                return response()->json(['status' => 'exception','response' => 'Unable to save event password.Please try again']);
        } else {

            if($user->update(['event_password' => bcrypt($input['eventPassword'])]))
                return response()->json(['status' => 'success','response' =>'Event password updated successfully']);
            else
                return response()->json(['status' => 'exception','response' => 'Unable to update event password.Please try again']);

        }
    }

    /**
     * Function: update user event password
     * Url: api/v2/update/event-password
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateEventPassword(Request $request) 
    {
    	$input = $request->input();

    	$validator = Validator::make($input, [
                'userId' => 'required',
                'oldEventPassword' => 'required',
                'newEventPassword' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'exception','response' => $validator->errors()->first()]);   
        }

        $user = User::whereId($input['userId'])->first();

        if (Hash::check($input['oldEventPassword'], $user->event_password)) {
            
            $user->event_password = bcrypt($request->input('newEventPassword'));
            $user->save();

            return response()->json(['status' => 'success','response' =>'Event password updated successfully']);
        } else {

        	return response()->json(['status' => 'exception','response' => 'Old event password does not match.']);
        }
    }
}

