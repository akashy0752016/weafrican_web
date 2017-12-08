<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\SubscriptionPlan;
use App\UserSubscriptionPlan;
use Auth;

class UserSubscriptionPlansController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageTitle = "Subscription Plans";
        $flag = 0;
        $plans = UserSubscriptionPlan::where('user_subscription_plans.user_id',Auth::id())->leftJoin('subscription_plans','subscription_plans.id', '=', 'user_subscription_plans.subscription_plan_id')->where('user_subscription_plans.status','!=',NULL)->get();
        
        return view('my-account.subscription', compact('pageTitle', 'plans','flag'));
    }


    public function getPremiumPlanDetails()
    {  
        $pageTitle = "Premium Plan Details";
        $flag = 0;
        $plans = UserSubscriptionPlan::whereUserId(Auth::id())->whereIsPremium(1)->get();
        
        return view('my-account.premium', compact('pageTitle', 'plans', 'flag'));
    }


    public function deactivatePremiumAutorenew($id)
    {   
        $plan = UserSubscriptionPlan::find($id);
        $plan->is_auto_renew = !$plan->is_auto_renew;
        $plan->save();

        if ($plan->is_auto_renew) { 
            $response = array(
                'status' => 'success',
                'message' => 'Premium Plan activated successfully.',
            );
        } else {
            $response = array(
                'status' => 'success',
                'message' => 'Premium Plan cancel successfully.',
            );
        }   

        return json_encode($response);
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
        $flag=0;
        $pageTitle = "Subscription Plan";
        $plan = UserSubscriptionPlan::find($id);
        return view('subscription-plan.show', compact('pageTitle', 'plan', 'flag'));
        
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
