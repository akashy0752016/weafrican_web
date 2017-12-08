<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\SubscriptionPlan;
use App\Helper;
use Validator;

class AdminSubscriptionPlansController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function index()
    {
        $pageTitle = 'Subscription Plan- Admin';
        $subscriptions = SubscriptionPlan::orderBy('id','DESC')->get();
        return view('admin.subscriptions.index', compact('pageTitle', 'subscriptions'));
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
        $pageTitle = "Edit Subscription Plan - Admin";
        $subscription = SubscriptionPlan::find($id);
        return view('admin.subscriptions.edit',compact('subscription','pageTitle'));
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
        $subscription = SubscriptionPlan::find($id);

        if(!$subscription) {
            return back()->with('error', 'Sorry, the plan you requested is not found');
        }

        $validator = Validator::make($request->all(), SubscriptionPlan::$validater);

        if ($validator->fails()) {
            return redirect('admin/subscription/plan/'.$id.'/edit')->withErrors($validator)->withInput();
        }

        $input = array_intersect_key($request->input(), SubscriptionPlan::$updatable);
        //var_dump($input);
        //var_dump($subscription->update($input));dd();
        if ($subscription->update($input)) {
            return redirect('admin/subscription/plan')->with('success', 'Subscription Updated successfully');
        } else {
            return back()->with('error', 'Subscription could not be updated. Please try again.');
        }
    }

    /**
     * Block the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function block($id)
    {
        $subscription = SubscriptionPlan::find($id);
        $subscription->is_blocked = !$subscription->is_blocked;
        $subscription->save();

        if ($subscription->is_blocked) { 
            return redirect('admin/subscription/plan')->with('success', 'Subscription Plan blocked successfully');
        } else {
            return redirect('admin/subscription/plan')->with('success', 'Subscription Plan unblocked successfully');
        }   
    }
}