<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\SubscriptionPlan;
use App\UserSubscriptionPlan;
use App\Helper;
use Auth;
use Session;
use DB;

class SubscriptionPlansController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageTitle = "Subscription Plans";
        $flag=0;
        $plans = UserSubscriptionPlan::where('user_subscription_plans.user_id',Auth::id())->leftJoin('subscription_plans','subscription_plans.id', '=', 'user_subscription_plans.subscription_plan_id')->get();
        return view('subscription-plan.index', compact('pageTitle', 'plans', 'flag'));
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
        $pageTitle = "Subscription Plan";
        $flag=0;
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

    /**
     * Show Subscription plan Static Page
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function subscription()
    {
        $pageTitle = "Subscription Plans";
        $flag=0;
        return view('subscription-plan-pages.index', compact('pageTitle', 'flag'));
    }

    /**
     * Buy a specified Premium Subscription Plan.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function buyPremiumSubscriptionPlan($id)
    {   
        if (Auth::check() && (Auth::user()->user_role_id == 3 )) {
            if (Auth::user()->business->is_identity_proof_validate && Auth::user()->business->is_business_proof_validate) {

                if (Auth::user()->currency && Auth::user()->currency != 'NGN') {
                    $userCurrency = Auth::user()->currency ? Auth::user()->currency : 'NGN';

                    if ($userCurrency != 'NGN') {
                        $currency = Helper::convertCurrency(strtoupper('NGN'), strtoupper($userCurrency), 1);
                    } else {
                        $currency = Helper::convertCurrency(strtoupper('NGN'), strtoupper('NGN'), 1);
                    }

                    $array['price'] = "IF((currency = '".strtoupper($userCurrency)."'), (price), (price * ".$currency.")) as price";
                    $array['currency'] = "IF((currency = '".strtoupper($userCurrency)."'), (currency), ('".$userCurrency."')) as currency";

                    $subscriptPlan = SubscriptionPlan::select('*', DB::raw(implode(", ", $array)))->where('type', 'like', '%premium%')->where('is_blocked', 0)->find($id);
                } else {

                    $subscriptPlan = SubscriptionPlan::where('type', 'premium')->find($id);
                }

                //Actual price of subscription plan in NGN
                $price = SubscriptionPlan::select('price')->where('type', 'premium')->find($id);
                
                if ($subscriptPlan) {
                    $pageTitle = "Buy ".$subscriptPlan->title." | Weafricans";
                    $flag = 0;
                    return view('subscription-plan.buy-subscription', compact('pageTitle','subscriptPlan', 'flag', 'price'));
                } else { 
                    return back()->with('error', 'Premium Supscription plan does not exits or blocked by admin. Please try after some time.');
                }
            } else {
                return redirect('register-business/'.Auth::id())->with('warning', 'You are not able to purchase plan because your business is not verified by the admin. Once your business is verified then you can purchase premium plan.');
            }
        } elseif(Auth::check() && Auth::user()->user_role_id == 5) {
            return redirect('premium-plan-details')->with('alert', 'You already have an active premium membership plan.');
        } elseif (!Auth::check()) { 
            return redirect('login');
        } else {
            return redirect('/');
        }
    }
}
