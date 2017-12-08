<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\UserBusiness;
use App\BusinessFollower;
use App\BusinessLike;
use App\BusinessRating;
use App\BusinessNotification;
use App\User;
use Auth;

class BusinessFollowerListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageTitle = "Business Follower, Business Like, and Business Dislike Lists";

        $businessId = UserBusiness::where('user_id',Auth::id())->pluck('id')->first();

        $followers = BusinessFollower::whereBusinessId($businessId)->get();

        $likes = BusinessLike::whereBusinessId($businessId)->where('is_like',1)->get();

        $dislikes = BusinessLike::whereBusinessId($businessId)->where('is_dislike',1)->get();

        $ratings = BusinessRating::whereBusinessId($businessId)->get();

        $business = UserBusiness::where('user_id',Auth::id())->first();

        $flag = 0;

        return view('business-follower.index', compact('pageTitle','businessId','followers','likes','dislikes','ratings', 'business', 'flag'));
    }


    public function getFollowingList()
    {
        $pageTitle = "Following Lists";

        $followers = BusinessFollower::whereUserId(Auth::id())->get();
        
        $flag = 0;

        return view('business-following.index', compact('pageTitle', 'followers', 'flag'));
    }

    public function unfollowBusiness(Request $request)
    {
        $input = $request->input();
        $data = BusinessFollower::whereIn('id', $input['chkbox'])->delete();

        if ($data)
            return response()->json(['status' => 'success', 'text' => 'Unfollow business successfully']);
        else 
            return response()->json(['status' => 'failure', 'text' => 'Business cannot be unfollow.Please try again.']);

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

    public function sendMessage(Request $request)
    {
        $input = $request->input();
        $this->businessNotification = new BusinessNotification();
        $result = $this->businessNotification->saveNotificationMessage($input['business_id'], $input['source'], $input['message']);
        return $result;
    }
}
