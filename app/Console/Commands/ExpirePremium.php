<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\UserSubscriptionPlan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendPremiumExpiryMail;
use App\User;
use DB;

class ExpirePremium extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'expire:premium';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Expire Premium Plan Daily';

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
        $userSubs = UserSubscriptionPlan::where('is_premium',1)->where('is_auto_renew',0)->where('expired_date', '<', Carbon::now())->where('is_expired','=',0)->get();

        if ($userSubs) {
            foreach ($userSubs as $banner) {
                Mail::to($banner->user->email)->send(new SendPremiumExpiryMail($banner));
                $banner->is_expired = 1;
                $banner->save();  
                User::whereId($banner->user_id)->update(['user_role_id' => 3]);
            }
        }
        $this->info('Expire Premium Plan Run SuccessFully');
    }
}
