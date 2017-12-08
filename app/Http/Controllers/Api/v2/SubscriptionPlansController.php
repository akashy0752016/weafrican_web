<?php

namespace App\Http\Controllers\Api\v2;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\SubscriptionPlan;
use App\UserSubscriptionPlan;
use App\Helper;
use App\User;
use Validator;
use DB;

class SubscriptionPlansController extends Controller
{
    /**
     * Function: get premium plans details.
     * Url: api/v2/subscriptionPlans/premium
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPremiumPlan(Request $request)
    {
        $input = $request->input();

        $validator = Validator::make($input, [
                'userId' => 'required|integer',
        ]);

        if ($validator->fails()) 
            return response()->json(['status' => 'exception','response' => $validator->errors()->first()]);

        $user = User::find($input['userId']);
        
        $userCurrency = $user->currency ? $user->currency : 'NGN';

        if ($userCurrency != 'NGN') {
            $currency = Helper::convertCurrency(strtoupper('NGN'), strtoupper($userCurrency), 1);

            $array['price'] = "IF((currency = '".strtoupper($userCurrency)."'), round((price),2), round((price * ".$currency."),2)) as price";
            $array['currency'] = "IF((currency = '".strtoupper($userCurrency)."'), (currency), ('".$userCurrency."')) as currency";

            $subscriptPlan = SubscriptionPlan::select('*', DB::raw(implode(", ", $array)))->where('type', 'like', '%premium%')->whereIsBlocked(0)->get();
        } else {

            $subscriptPlan = SubscriptionPlan::where('type', 'like', '%premium%')->whereIsBlocked(0)->get();
        }

        $plan = SubscriptionPlan::select('price as plan_price', 'currency as plan_currency')->where('type','premium')->whereIsBlocked(0)->get();

        if($plan->count() > 0)
            return response()->json(['status' => 'success','response' => $subscriptPlan ,'plan' => $plan]);
        else
            return response()->json(['status' => 'exception','response' => 'No premium plan found.']);
    }

    /**
     * Function: get sponsor plans details.
     * Url: api/v2/subscriptionPlans/sponsor
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSponsorPlan(Request $request)
    {
        $input = $request->input();

        $validator = Validator::make($input, [
                'userId' => 'required|integer',
        ]);

        if ($validator->fails()) 
            return response()->json(['status' => 'exception','response' => $validator->errors()->first()]);

        $user = User::find($input['userId']);
        
        $userCurrency = $user->currency ? $user->currency : 'NGN';

        if ($userCurrency != 'NGN') {
            $currency = Helper::convertCurrency(strtoupper('NGN'), strtoupper($userCurrency), 1);

            $array['price'] = "IF((currency = '".strtoupper($userCurrency)."'), round((price),2), round((price * ".$currency."),2)) as price";
            $array['currency'] = "IF((currency = '".strtoupper($userCurrency)."'), (currency), ('".$userCurrency."')) as currency";

            $subscriptPlan = SubscriptionPlan::select('*', DB::raw(implode(", ", $array)))->where('type', 'like', '%sponsor%')->whereIsBlocked(0)->get();
        } else {
            $subscriptPlan = SubscriptionPlan::where('type', 'like', '%sponsor%')->whereIsBlocked(0)->get();
        }

        $plan = SubscriptionPlan::select('price as plan_price', 'currency as plan_currency')->where('type','sponsor')->whereIsBlocked(0)->get();

        if($plan->count() > 0)
            return response()->json(['status' => 'success','response' => $subscriptPlan ,'plan' => $plan]);
        else
            return response()->json(['status' => 'exception','response' => 'No sponsor plan found.']);
    }

    /**
     * Function: get event plans details.
     * Url: api/v2/subscriptionPlans/event
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getEventPlan(Request $request)
    {
        $input = $request->input();

        $validator = Validator::make($input, [
                'userId' => 'required|integer',
        ]);

        if ($validator->fails()) 
            return response()->json(['status' => 'exception','response' => $validator->errors()->first()]);

        $user = User::find($input['userId']);
        
        $userCurrency = $user->currency ? $user->currency : 'NGN';

        if ($userCurrency != 'NGN') {
            $currency = Helper::convertCurrency(strtoupper('NGN'), strtoupper($userCurrency), 1);

            $array['price'] = "IF((currency = '".strtoupper($userCurrency)."'), round((price),2), round((price * ".$currency."),2)) as price";
            $array['currency'] = "IF((currency = '".strtoupper($userCurrency)."'), (currency), ('".$userCurrency."')) as currency";

            $subscriptPlan = SubscriptionPlan::select('*', DB::raw(implode(", ", $array)))->where('type', 'like', '%event%')->whereIsBlocked(0)->get();
        } else {
            $subscriptPlan = SubscriptionPlan::where('type', 'like', '%event%')->whereIsBlocked(0)->get();
        }

        $plan = SubscriptionPlan::select('price as plan_price', 'currency as plan_currency')->where('type','event')->whereIsBlocked(0)->get();

        if($plan->count() > 0)
            return response()->json(['status' => 'success','response' => $subscriptPlan ,'plan' => $plan]);
        else
            return response()->json(['status' => 'exception','response' => 'No event plan found.']);
    }

    /**
     * Function: get business plans details.
     * Url: api/v2/subscriptionPlans/business
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBusinessPlan(Request $request)
    {
        $input = $request->input();

        $validator = Validator::make($input, [
                'userId' => 'required|integer',
        ]);

        if ($validator->fails()) 
            return response()->json(['status' => 'exception','response' => $validator->errors()->first()]);

        $user = User::find($input['userId']);
        
        $userCurrency = $user->currency ? $user->currency : 'NGN';

        if ($userCurrency != 'NGN') {
            $currency = Helper::convertCurrency(strtoupper('NGN'), strtoupper($userCurrency), 1);

            $array['price'] = "IF((currency = '".strtoupper($userCurrency)."'), round((price),2), round((price * ".$currency."),2)) as price";
            $array['currency'] = "IF((currency = '".strtoupper($userCurrency)."'), (currency), ('".$userCurrency."')) as currency";

            $subscriptPlan = SubscriptionPlan::select('*', DB::raw(implode(", ", $array)))->where('type', 'like', '%business%')->whereIsBlocked(0)->get();
        } else {
            $subscriptPlan = SubscriptionPlan::where('type', 'like', '%business%')->whereIsBlocked(0)->get();
        }

        $plan = SubscriptionPlan::select('price as plan_price', 'currency as plan_currency')->where('type','business')->whereIsBlocked(0)->get();

        if($plan->count() > 0)
            return response()->json(['status' => 'success','response' => $subscriptPlan ,'plan' => $plan]);
        else
            return response()->json(['status' => 'exception','response' => 'No business plan found.']);
    }


    public function premiumAutoRenew(Request $request) 
    {
        $input = $request->input();

        $validator = Validator::make($input, [
                'userId' => 'required|integer',
        ]);

        if ($validator->fails()) 
            return response()->json(['status' => 'exception','response' => $validator->errors()->first()]);

        $plan = UserSubscriptionPlan::whereUserId($input['userId'])->whereIsPremium(1)->first();
        if($plan) {
            $plan->is_auto_renew = !$plan->is_auto_renew;
            $plan->save();

            if ($plan->is_auto_renew) { 
                $response = array(
                    'status' => 'success',
                    'premium_status' => 1,
                );
            } else {
                $response = array(
                    'status' => 'success',
                    'premium_status' => 0,
                );
            }   

            return response()->json(['status' => 'success','response' => $response]);
        } else {
            return response()->json(['status' => 'exception','response' => 'No plan found']);   
        }

    }

    public function getPremiumTransaction(Request $request) 
    {
        $input = $request->input();

        $validator = Validator::make($input, [
            'userId' => 'required|integer',
        ]);

        if ($validator->fails()) 
            return response()->json(['status' => 'exception','response' => $validator->errors()->first()]);

        $plan = UserSubscriptionPlan::whereUserId($input['userId'])->whereIsPremium(1)->first();

        if ($plan) {
            return response()->json(['status' => 'success','response' => $plan]);
        } else {
            return response()->json(['status' => 'exception','response' => 'No plan found']);   
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
