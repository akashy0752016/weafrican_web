<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BusinessBanner;
use App\HomePageBanner;
use App\EventBanner;
use App\UserSubscriptionPlan;
use App\EventTransaction;
use Auth;

class MyAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageTitle = "My Account | Weafricans";
        $flag=0;
        $userSubscription = UserSubscriptionPlan::where('user_id',Auth::user()->id)->where('status','!=', NULL)->orderBy('created_at', 'desc')->orderBy('id', 'desc')->get();
        $eventTransaction = EventTransaction::where('user_id',Auth::user()->id)->where('status','!=', NULL)->orderBy('created_at', 'desc')->orderBy('id', 'desc')->get();
        return view('my-account.index', compact('pageTitle','userSubscription','eventTransaction', 'flag'));
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
