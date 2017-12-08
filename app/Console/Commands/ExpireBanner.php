<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\UserSubscriptionPlan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendExpiryMail;
use App\BusinessNotification;
use App\UserNotification;
use App\Http\Controllers\AdminFcmNotificationController;
use App\FcmUser;
use DB;

class ExpireBanner extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'expire:banner';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Expire Banners Daily';

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
        
        $userSubs = UserSubscriptionPlan::where('expired_date', '<', Carbon::now())->where('is_expired','=',0)->get();

        if($userSubs)
        {
            $adminFcm = new AdminFcmNotificationController();
            foreach ($userSubs as $banner) {
                Mail::to($banner->user->email)->send(new SendExpiryMail($banner));
                $banner->is_expired = 1;
                $banner->save();
                $notification = new BusinessNotification();
                $notification->user_id = 1;
                $notification->source = "super-admin";
                $notification->message = "Hello ".$banner->user->first_name."\r\n,Your banner ".$banner->subscription->title." has expired. Kindly, buy new banner to continue your business promotion.";
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
        $this->info('Expire Banner Run SuccessFully');
    }
}
