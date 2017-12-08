<?php

namespace App\Http\Controllers\Api\v2;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BusinessLike;
use App\User;
use Validator;

class BusinessLikeController extends Controller
{
	/**
     * Function: To get Business User like list.
     * Url: api/v2/business/like
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getLikeList(Request $request)
    {   
        $input = $request->input();

        $validator = Validator::make($input, [
            'businessId' => 'required|integer',
            'index' => 'required',
            'limit' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'exception','response' => $validator->errors()->first()]);   
        }

        $userIds = BusinessLike::whereBusinessId($input['businessId'])->whereIsLike(1)->pluck('user_id');

        $response = User::select('first_name', 'middle_name', 'last_name', 'email', 'image')->whereIn('id', $userIds)->skip($input['index'])->take($input['limit'])->get();

        if (count($response) > 0) {
            return response()->json(['status' => 'success','response' => $response]); 
        } else {
            return response()->json(['status' => 'exception','response' => 'No like found.']); 
        }  
    }
}
