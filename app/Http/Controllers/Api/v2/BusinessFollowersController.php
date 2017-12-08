<?php

namespace App\Http\Controllers\Api\v2;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BusinessFollower;
use App\User;
use Validator;
use DB;

class BusinessFollowersController extends Controller
{
    /**
     * Function: To get Business following list.
     * Url: api/v2/business/following
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getFollowingList(Request $request)
    {   
        $input = $request->input();

        $validator = Validator::make($input, [
            'userId' => 'required|integer',
            'index' => 'required',
            'limit' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'exception','response' => $validator->errors()->first()]);   
        }

        $response = BusinessFollower::Select('business_followers.id','user_businesses.user_id', 'user_businesses.id as business_id', 'user_businesses.title', 'user_businesses.bussiness_category_id', 'user_businesses.bussiness_subcategory_id','user_businesses.business_logo')->join('user_businesses','user_businesses.id', '=', 'business_followers.business_id')->where('business_followers.user_id', '=', $input['userId'])->skip($input['index'])->take($input['limit'])->get();

        $follower = array();

        foreach($response as $key => $data)
        {
            $follower[$key]['id'] = $data->id;
            $follower[$key]['user_id'] = $data->user_id;
            $follower[$key]['business_id'] = $data->business_id;
            $follower[$key]['title'] = $data->title;
            $follower[$key]['bussiness_category_id'] = $data->bussiness_category_id;
            $follower[$key]['bussiness_subcategory_id'] = $data->bussiness_subcategory_id;
            $follower[$key]['business_logo'] = $data->business_logo;
            $user = User::find($data->user_id);
            $follower[$key]['is_premium'] = ($user->user_role_id == 5)? 1:0;
        }

        if (count($response) > 0) {
            return response()->json(['status' => 'success','response' => $follower]); 
        } else {
            return response()->json(['status' => 'exception','response' => 'No data found.']); 
        }  
    }

    /**
     * Function: Delete single and multiple following user.
     * Url: api/v2/business/delete/following
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteFollowingBusiness(Request $request)
    {
        $input = $request->input();

        $ids = explode( ',', $input['id']);
        
        $followings = BusinessFollower::whereIn('id',$ids)->delete();
       
        if ($followings) {
            return response()->json(['status' => 'success', 'response' => 'Unfollow Successfully']);
        } else {
            return response()->json(['status' => 'exception', 'response' => 'Unfollow unsuccessfully .Please try again.']);
        }
    }

    /**
     * Function: Get business user follower list.
     * Url: api/v2/business/follower
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getFollowerList(Request $request)
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

        $userIds = BusinessFollower::whereBusinessId($input['businessId'])->pluck('user_id');
        $response = User::select('first_name', 'middle_name', 'last_name', 'email', 'image')->whereIn('id', $userIds)->skip($input['index'])->take($input['limit'])->get();

        if (count($response) > 0) {
            return response()->json(['status' => 'success','response' => $response]); 
        } else {
            return response()->json(['status' => 'exception','response' => 'No follower found.']); 
        }  
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
