<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Paystack;
use App\UserSubscriptionPlan;
use App\BusinessBanner;
use App\EventBanner;
use App\HomePageBanner;
use Validator;
use Auth;
use App\SubscriptionPlan;
use App\User;

class PaymentController extends Controller
{
    /**
     * Redirect the User to Paystack Payment Page
     * @return Url
     */
    public function redirectToGateway(Request $request)
    {   //dd($request->input());
        $input = $request->input();
        $validator = Validator::make($request->all(), [
            'subscription_plan_id' => 'required|integer|min:1',
            'amount' => 'required|min:1|regex:/^\d*(\.\d{2})?$/',
            'currency' => 'required|string',
            'channels' => 'required',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email',
            'country_code' => 'required|string',
            'mobile_number' => 'required|string',
            'address' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'country' => 'required|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)
                         ->withInput();
        }

        /*$plan = SubscriptionPlan::find($input['subscription_plan_id']);
        if ($plan->type == 'premium') {
            $input['is_premium'] = 1;
            $input['is_auto_renew'] = 1; 
        }*/

        $input['user_id'] = Auth::user()->id;
        $input['is_expired'] = 1;
        $input['user_currency'] = Auth::user()->currency;
        $input = array_intersect_key($input, UserSubscriptionPlan::$updatable);
        $userSubscriptionPlan = UserSubscriptionPlan::create($input);
        if($userSubscriptionPlan->save())
        {
            $pageTitle = $userSubscriptionPlan->subscription->title;
            $subscriptPlan = $userSubscriptionPlan->subscription;
            $flag=0;
            return view('subscription-plan.pay-subscription', compact('pageTitle','userSubscriptionPlan', 'subscriptPlan', 'flag'));/*return Paystack::getAuthorizationUrl()->redirectNow();*/
        }else
        {
            return back()->with('error', 'User payment could\'nt initialize, Please try after some time'); 
        }
    }

    /**
     * Obtain Paystack payment information
     * @return void
     */
    public function handleGatewayCallback()
    {
        $paymentDetails = Paystack::getPaymentData();
        if($paymentDetails['status'])
        {
            $userSubscriptionPlan = UserSubscriptionPlan::where('reference_id',$paymentDetails['data']['reference'])->first();
            if($userSubscriptionPlan)
            {
                $userSubscriptionPlan->status = $paymentDetails['data']['status'];
                $userSubscriptionPlan->transaction_date = $paymentDetails['data']['transaction_date'];
                $userSubscriptionPlan->ip_address = $paymentDetails['data']['ip_address'];
                $userSubscriptionPlan->subscription_date = date("Y-m-d");
                $userSubscriptionPlan->is_expired = 0;
                $userSubscriptionPlan->expired_date = date("Y-m-d", strtotime("+".$userSubscriptionPlan->subscription->validity_period." days"));
                if($userSubscriptionPlan->save())
                {
                    $input = array(
                        'user_id' => $userSubscriptionPlan->user_id,
                        'business_id' => $userSubscriptionPlan->business->id,
                        'user_subscription_plan_id' => $userSubscriptionPlan->id,
                        'is_blocked' => 1,
                    );
                    switch ($userSubscriptionPlan->subscription->type) {
                        case 'business':
                            $input = array_intersect_key($input, BusinessBanner::$updatable);
                            $businessBanner = BusinessBanner::create($input);
                            if($businessBanner->save())
                            {
                                return redirect('my-account')->with('success', "Business Banner has been added successfully added. Please add your business banner.");
                            }else
                            {
                                return redirect('my-account')->with('warning', "Business Banner could not be added. Please contact admin.");
                            }
                            break;

                        case 'event':
                            $input = array_intersect_key($input, EventBanner::$updatable);
                            $eventBanner = EventBanner::create($input);
                            if($eventBanner->save())
                            {
                                return redirect('my-account')->with('success', "Event Banner has been added successfully added. Please add your Event banner.");
                            }else
                            {
                                return redirect('my-account')->with('warning', "Event Banner could not be added. Please contact admin.");
                            }
                            break;

                        case 'sponsor':
                            $input = array_intersect_key($input, HomePageBanner::$updatable);
                            $homePageBanner = HomePageBanner::create($input);
                            if($homePageBanner->save())
                            {
                                return redirect('my-account')->with('success', "Sponsor Banner has been added successfully added. Please add your Sponsor banner.");
                            }else
                            {
                                return redirect('my-account')->with('warning', "Sponsor Banner could not be added. Please contact admin.");
                            }
                            break;

                        case 'premium':
                            $user = User::whereId(Auth::id())->update(['user_role_id' => 4]);
                            if ($user) {
                                return redirect('my-account')->with('success', "Premium plan has been activated successfully. Please add your Sponsor banner.");
                            } else {
                                return redirect('my-account')->with('warning', "Premium Plan could not be activated. Please contact admin.");
                            }
                            break;
                    }
                }else
                {
                    return redirect('my-account')->with('error', "Subscription plan could not be updated. Please contact admin.");
                }
                
            }else
            {
                return redirect('my-account')->with('error', "User Subscription plan could not be created. Please contact admin.");
            }
            var_dump($userSubscriptionPlan);
        }else
        {
            $userSubscriptionPlan = UserSubscriptionPlan::where('reference_id',$paymentDetails['data']['reference'])->first();
            $userSubscriptionPlan->status = "failure";
            $userSubscriptionPlan->save();
            return redirect('my-account')->with('error', $paymentDetails['message']);
        }
        //dd($paymentDetails);
        // Now you have the payment details,
        // you can store the authorization_code in your db to allow for recurrent subscriptions
        // you can then redirect or do whatever you want
    }

    public function checkPaymentStatus(Request $request)
    {
        $input = $request->input();

        $validator = Validator::make($request->all(), [
            'subscription_plan_id' => 'required|integer|min:1',
            'amount' => 'required|min:1|regex:/^\d*(\.\d{2})?$/',
            'currency' => 'required|string',
            'paystack-reference' => 'required',
            'channels' => 'required',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email',
            'country_code' => 'required|string',
            'mobile_number' => 'required|string',
            'address' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'country' => 'required|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)
                         ->withInput();
        }
        $input['user_id'] = Auth::user()->id;
        $input['reference_id'] = $input['paystack-reference'];
        $input['is_expired'] = 1;
        $subscriptionPlan = SubscriptionPlan::whereId($input['subscription_plan_id'])->first();
        $result = $this->transactionVerify($input['paystack-reference']);
        if (array_key_exists('data', $result) && array_key_exists('status', $result['data']) && ($result['data']['status'] === 'success')) {
            $input['status'] = $result['data']['status'];
            $input['transaction_date'] = $result['data']['transaction_date'];
            $input['ip_address'] = $result['data']['ip_address'];
            $input['subscription_date'] = date("Y-m-d");
            $input['is_expired'] = 0;
            $input['amount'] = number_format($result['data']['amount'],2, '.', '');
            $input['expired_date'] = date("Y-m-d", strtotime("+".$subscriptionPlan->validity_period." days"));
            $userSubscriptionPlan = array_intersect_key($input, UserSubscriptionPlan::$updatable);
            $userSubscriptionPlan = UserSubscriptionPlan::create($userSubscriptionPlan);
            if($userSubscriptionPlan->save())
            {  
                $input = array(
                    'user_id' => $userSubscriptionPlan->user_id,
                    'business_id' => $userSubscriptionPlan->business->id,
                    'user_subscription_plan_id' => $userSubscriptionPlan->id,
                    'is_blocked' => 1,
                );
                switch ($userSubscriptionPlan->subscription->type) {
                    case 'business':
                        $input = array_intersect_key($input, BusinessBanner::$updatable);
                        $businessBanner = BusinessBanner::create($input);
                        if($businessBanner->save())
                        {
                            return redirect('my-account')->with('success', "Business Banner has been added successfully added. Please add your business banner.");
                        }else
                        {
                            return redirect('my-account')->with('warning', "Business Banner could not be added. Please contact admin.");
                        }
                        break;

                    case 'event':
                        $input = array_intersect_key($input, EventBanner::$updatable);
                        $eventBanner = EventBanner::create($input);
                        if($eventBanner->save())
                        {
                            return redirect('my-account')->with('success', "Event Banner has been added successfully added. Please add your Event banner.");
                        }else
                        {
                            return redirect('my-account')->with('warning', "Event Banner could not be added. Please contact admin.");
                        }
                        break;

                    case 'sponsor':
                        $input = array_intersect_key($input, HomePageBanner::$updatable);
                        $homePageBanner = HomePageBanner::create($input);
                        if($homePageBanner->save())
                        {
                            return redirect('my-account')->with('success', "Sponsor Banner has been added successfully added. Please add your Sponsor banner.");
                        }else
                        {
                            return redirect('my-account')->with('warning', "Sponsor Banner could not be added. Please contact admin.");
                        }
                        break;
                }
            }else
            {
                return redirect('my-account')->with('error', "User Subscription plan could not be created. Please contact admin.");
            }
        }else
        {
            return back()->with('error', 'Your transaction was unsuccess full, Please try after some time');
        }
    }

    public function transactionVerify($reference)
    {
        $result = array();
        //The parameter after verify/ is the transaction reference to be verified
        $url = 'https://api.paystack.co/transaction/verify/'.$reference;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt(
          $ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer ".config('paystack.secretKey').""]
        );
        $request = curl_exec($ch);
        curl_close($ch);

        if ($request) {
          $result = json_decode($request, true);
        }
        //dd($result);
        return $result;
    }

    public function redirectTopaymentPage(Request $request)
    {
        $input = $request->input();

        $validator = Validator::make($request->all(), [
            'user_subscription_plan_id' => 'required|integer|min:1',
            'amount' => 'required|min:1|regex:/^\d*(\.\d{2})?$/',
            'currency' => 'required|string',
            'paystack-reference' => 'required',
            'channels' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)
                         ->withInput();
        }
        $userSubscriptionPlan = UserSubscriptionPlan::whereId($input['user_subscription_plan_id'])->first(); 

        if($userSubscriptionPlan)
        {    
            $result = $this->transactionVerify($input['paystack-reference']);
            if (array_key_exists('data', $result) && array_key_exists('status', $result['data']) && ($result['data']['status'] === 'success')) {
                $userSubscriptionPlan->status = $result['data']['status'];
                $userSubscriptionPlan->transaction_date = $result['data']['transaction_date'];
                $userSubscriptionPlan->transaction_message = $result['message'];
                $userSubscriptionPlan->authorization_code = $result['data']['authorization']['authorization_code'];
                $userSubscriptionPlan->is_premium = ($userSubscriptionPlan->subscription->type == 'premium') ? 1: '';
                $userSubscriptionPlan->is_auto_renew = ($userSubscriptionPlan->subscription->type == 'premium') ? 1: '';
                $userSubscriptionPlan->reference_id = $input['paystack-reference'];
                $userSubscriptionPlan->ip_address = $result['data']['ip_address'];
                $userSubscriptionPlan->subscription_date = date("Y-m-d");
                $userSubscriptionPlan->is_expired = 0;
                $userSubscriptionPlan->amount = number_format($input['amount'],2, '.', '');
                $userSubscriptionPlan->expired_date = date("Y-m-d", strtotime("+".$userSubscriptionPlan->subscription->validity_period." days"));
                if($userSubscriptionPlan->save())
                {
                    $input = array(
                        'user_id' => $userSubscriptionPlan->user_id,
                        'business_id' => $userSubscriptionPlan->business->id,
                        'user_subscription_plan_id' => $userSubscriptionPlan->id,
                        'is_blocked' => 1,
                    );
                    switch ($userSubscriptionPlan->subscription->type) {
                        case 'business':
                            $input = array_intersect_key($input, BusinessBanner::$updatable);
                            $businessBanner = BusinessBanner::create($input);
                            if($businessBanner->save())
                            {
                                return redirect('business-banner/'.$businessBanner->id.'/edit')->with('success', "Business Banner has been added successfully added. Please add your business banner.");
                            }else
                            {
                                return redirect('my-account')->with('warning', "Business Banner could not be added. Please contact admin.");
                            }
                            break;

                        case 'event':
                            $input = array_intersect_key($input, EventBanner::$updatable);
                            $eventBanner = EventBanner::create($input);
                            if($eventBanner->save())
                            {
                                return redirect('event-banner/'.$eventBanner->id.'/edit')->with('success', "Event Banner has been added successfully added. Please add your Event banner.");
                            }else
                            {
                                return redirect('my-account')->with('warning', "Event Banner could not be added. Please contact admin.");
                            }
                            break;

                        case 'sponsor':
                            $input = array_intersect_key($input, HomePageBanner::$updatable);
                            $homePageBanner = HomePageBanner::create($input);
                            if($homePageBanner->save())
                            {
                                return redirect('sponsor-banner/'.$homePageBanner->id.'/edit')->with('success', "Sponsor Banner has been added successfully added. Please add your Sponsor banner.");
                            }else
                            {
                                return redirect('my-account')->with('warning', "Sponsor Banner could not be added. Please contact admin.");
                            }
                            break;
                        case 'premium':
                            $user = User::whereId(Auth::id())->update(['user_role_id' => '5']);
                            if($user)
                            {
                                return redirect('my-account')->with('success', "Premium Plan has been activated successfully.");
                            }else
                            {
                                return redirect('my-account')->with('warning', "Premium Plan could not be added. Please contact admin.");
                            }
                            break;
                    }
                }else
                {
                    return redirect('my-account')->with('error', "User Subscription plan could not be created. Please contact admin.");
                }
            }else
            {
                $userSubscriptionPlan->amount = number_format($input['amount'],2, '.', '');
                $userSubscriptionPlan->status = "failed";
                $userSubscriptionPlan->transaction_date = date(DATE_ATOM, mktime(date("H"), date("i") , date("s"), date("n"), date("j") , date("Y") ));
                $userSubscriptionPlan->save();
                return redirect('my-account')->with('warning', "Your transaction was unsuccessfull. Please try after some time.");
            }
        }else
        {
            return redirect('my-account')->with('error', "User Subscription Plan Cannot be added please try again.");
        }
    }
}
