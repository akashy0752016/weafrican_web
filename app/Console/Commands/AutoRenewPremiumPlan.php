<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\UserSubscriptionPlan;
use App\SubscriptionPlan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\PremiumPaymentMail;
use App\User;
use DB;
use App\Helper;

class AutoRenewPremiumPlan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:autorenew-payment';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto renew premium plans';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $userSubs = UserSubscriptionPlan::where('is_premium',1)->where('is_auto_renew',1)->where('expired_date', '<=', date('Y-m-d'))->where('is_expired','=',0)->get();
        
        //var_dump($userSubs);dd();
        if ($userSubs) {
            foreach ($userSubs as $banner) {
                $user = User::whereId($banner->user_id)->first();

                if ($user->currency && $user->currency != 'NGN') {
                    $userCurrency = $user->currency ? $user->currency : 'NGN';

                    $currency = Helper::convertCurrency(strtoupper('NGN'), strtoupper($userCurrency), 1);

                    $array['price'] = "IF((currency = '".strtoupper($userCurrency)."'), (price), (price * ".$currency.")) as price";
                    $array['currency'] = "IF((currency = '".strtoupper($userCurrency)."'), (currency), ('".$userCurrency."')) as currency";

                    $subscriptPlan = SubscriptionPlan::select('*', DB::raw(implode(", ", $array)))->where('type', 'like', '%premium%')->where('is_blocked', 0)->find($banner->subscription_plan_id);
                } else {

                    $subscriptPlan = SubscriptionPlan::where('type', 'premium')->find($banner->subscription_plan_id);
                }

                $subscriptionDetails = SubscriptionPlan::where('type', 'premium')->find($banner->subscription_plan_id);

                $data = array();
                $data['authorization_code'] = $banner->authorization_code;
                $data['email'] = $banner->email;
                $data['amount'] = $subscriptPlan->price *100;

                $result = $this->autoPayment($data);
               //dd($result);
                if($result['status'] == true && $result['data']['status'] == 'success') {
                    $banner->amount = $subscriptionDetails->price;
                    $banner->user_amount = $subscriptPlan->price;
                    $banner->subscription_date = date("Y-m-d");
                    $banner->is_expired = 0;
                    $banner->expired_date = date("Y-m-d", strtotime("+".$banner->subscription->validity_period." days"));
                    $banner->save();
                    Mail::to($banner->user->email)->send(new PremiumPaymentMail($banner));
                } else {
                    $banner->is_auto_renew = 0;
                    $banner->is_expired = 1;
                    $banner->transaction_message = $result['data']['gateway_response'];
                    $banner->save();
                    User::whereId($banner->user_id)->update(['user_role_id' => 3]);
                    Mail::to($banner->user->email)->send(new PremiumPaymentMail($banner));
                }
                
            }
        }
        $this->info('All Premium Plan payment done SuccessFully');
    }

    /*Auto Payment of premium plan by using authorzation code*/
    public function autoPayment($data)
    {
        $url = 'https://api.paystack.co/transaction/charge_authorization';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt(
          $ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer ".config('paystack.secretKey')."","Content-Type: application/json"]
        );

        curl_setopt($ch,CURLOPT_POSTFIELDS, json_encode($data));

        $request = curl_exec($ch);
        curl_close($ch);

        if ($request) {
          $result = json_decode($request, true);
        }
        //dd($result);
        return $result;
    }
}
