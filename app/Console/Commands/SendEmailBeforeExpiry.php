<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\UserSubscriptionPlan;
use App\Http\Controllers\AdminFcmNotificationController;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendPriorExpiryMail;
use App\Mail\SendPriorPremiumExpiryMail;
use App\BusinessNotification;
use App\UserNotification;
use App\FcmUser;
use DB;

class SendEmailBeforeExpiry extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:mailBeforExpire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Mail and SMS to the user whose banners get expire in 5 days';

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
        $premiumUserSubs = UserSubscriptionPlan::where('is_premium', 1)->where('is_auto_renew', 0)->where("is_expired","=","0")->where("expired_date","=",DB::raw("DATE_ADD(CURDATE(), INTERVAL 5 DAY)"))->get();

        if ($premiumUserSubs) {
            foreach ($premiumUserSubs as $banner) {
                Mail::to($banner->user->email)->send(new SendPriorPremiumExpiryMail($banner));
            }
        }

        $userSubs = UserSubscriptionPlan::where('is_premium', 0)->where("is_expired","=","0")->where("expired_date","=",DB::raw("DATE_ADD(CURDATE(), INTERVAL 5 DAY)"))->get();
        if($userSubs)
        {
            $adminFcm = new AdminFcmNotificationController();
            foreach ($userSubs as $banner) {
                Mail::to($banner->user->email)->send(new SendPriorExpiryMail($banner));
                $notification = new BusinessNotification();
                $notification->user_id = 1;
                $notification->source = "super-admin";
                $notification->message = "Hello ".$banner->user->first_name."\r\n,Your banner ".$banner->subscription->title." will get expired in 5 days. Kindly, buy new banner to continue your business promotion.";
                $notification->save();
                $id = FcmUser::where('user_id', $banner->user_id)->first();
                if($id)
                {
                    $registation_ids[] = $id->fcm_reg_id;

                    $userNotification = UserNotification::where('user_id', $banner->user_id)->first();
                    if($userNotification)
                    {
                        $userNotification->business_notification_id = $userNotification->business_notification_id.','.$notification->id;
                        $userNotification->save();
                    }else
                    {
                        $input['user_id'] = $banner->user_id;
                        $input['business_notification_id'] = $notification->id;

                        $userNotification = array_intersect_key($input, UserNotification::$updatable);
                        $userNotification = UserNotification::create($userNotification);
                        $userNotification->save();
                    }
                    $adminFcm->sendPushNotificationToFCM($registation_ids,$notification->message);
                }
            }
        }
        $this->info('Send Email Before Expiry Run SuccessFully');
    }
}
