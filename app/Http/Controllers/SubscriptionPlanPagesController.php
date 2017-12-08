<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SubscriptionPlan;
use App\Helper;
use Auth;
Use DB;

class SubscriptionPlanPagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

    /**
     * Display a plans of Event Subscription Plan of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function event()
    {
        $pageTitle = 'Event planner | Business Events in Africa | Business Services in Africa';
        $metaDescription = 'Weafricans Provide Special Events Plans For Business members who want to do business in Africa.For More Information Inquire Now.';

        $flag = 1;

        if (Auth::check() && Auth::user()->currency && Auth::user()->currency != 'NGN') {
            $userCurrency = Auth::user()->currency ? Auth::user()->currency : 'NGN';

            if ($userCurrency != 'NGN') {
                $currency = Helper::convertCurrency(strtoupper('NGN'), strtoupper($userCurrency), 1);
            } else {
                $currency = Helper::convertCurrency(strtoupper('NGN'), strtoupper('NGN'), 1);
            }

            $array['price'] = "IF((currency = '".strtoupper($userCurrency)."'), (price), (price * ".$currency.")) as price";
            $array['currency'] = "IF((currency = '".strtoupper($userCurrency)."'), (currency), ('".$userCurrency."')) as currency";

            $plans = SubscriptionPlan::select('*', DB::raw(implode(", ", $array)))->where('type', 'like', '%event%')->where('is_blocked',0)->get();
        } elseif(!Auth::check()) {

            $userCurrency = 'USD';

            $currency = Helper::convertCurrency(strtoupper('NGN'), strtoupper($userCurrency), 1);

            $array['price'] = "IF((currency = '".strtoupper($userCurrency)."'), (price), (price * ".$currency.")) as price";
            $array['currency'] = "IF((currency = '".strtoupper($userCurrency)."'), (currency), ('".$userCurrency."')) as currency";

            $plans = SubscriptionPlan::select('*', DB::raw(implode(", ", $array)))->where('type', 'like', '%event%')->where('is_blocked',0)->get();
        } else {
            $plans = SubscriptionPlan::where('type', 'like', '%event%')->where('is_blocked',0)->get();

        }

        return view('subscription-plan-pages.event', compact('pageTitle', 'flag', 'plans', 'metaDescription'));
    }

    /**
     * Display a plans of Sponsor Subscription Plan of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function sponsor()
    {
        $pageTitle = 'Sponsor business ads | Drive Best Results with Any Budget | Weafricans.com';
        $metaDescription = 'Reach the audience that matters to your business. Create a sponsor ads today. Further information inquire on weafricans.com';

        $flag = 1;

        if (Auth::check() && Auth::user()->currency && Auth::user()->currency != 'NGN') {
            $userCurrency = Auth::user()->currency ? Auth::user()->currency : 'NGN';

            if ($userCurrency != 'NGN') {
                $currency = Helper::convertCurrency(strtoupper('NGN'), strtoupper($userCurrency), 1);
            } else {
                $currency = Helper::convertCurrency(strtoupper('NGN'), strtoupper('NGN'), 1);
            }

            $array['price'] = "IF((currency = '".strtoupper($userCurrency)."'), (price), (price * ".$currency.")) as price";
            $array['currency'] = "IF((currency = '".strtoupper($userCurrency)."'), (currency), ('".$userCurrency."')) as currency";

            $plans = SubscriptionPlan::select('*', DB::raw(implode(", ", $array)))->where('type', 'like', '%sponsor%')->where('is_blocked',0)->get();
        } elseif(!Auth::check()) {

            $userCurrency = 'USD';

            $currency = Helper::convertCurrency(strtoupper('NGN'), strtoupper($userCurrency), 1);

            $array['price'] = "IF((currency = '".strtoupper($userCurrency)."'), (price), (price * ".$currency.")) as price";
            $array['currency'] = "IF((currency = '".strtoupper($userCurrency)."'), (currency), ('".$userCurrency."')) as currency";

            $plans = SubscriptionPlan::select('*', DB::raw(implode(", ", $array)))->where('type', 'like', '%sponsor%')->where('is_blocked',0)->get();
        } else {
            $plans = SubscriptionPlan::where('type', 'like', '%sponsor%')->where('is_blocked',0)->get();
        }

        return view('subscription-plan-pages.sponsor', compact('pageTitle', 'flag', 'plans', 'metaDescription'));
    }

    /**
     * Display a plans of Business Banner Subscription Plan of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function banner()
    {
        $pageTitle = 'Digital Marketing Services in Africa | Online Ads Marketing Services | Display ads Marketing in Africa';
        $metaDescription = 'Advertise in Local Area, city, nationwide, or even internationally. We africans provide ads banner facility for your business growth. Inquire Now For banner marketing';

        $flag = 1;

        if (Auth::check() && Auth::user()->currency && Auth::user()->currency != 'NGN') {
            $userCurrency = Auth::user()->currency ? Auth::user()->currency : 'NGN';

            if ($userCurrency != 'NGN') {
                $currency = Helper::convertCurrency(strtoupper('NGN'), strtoupper($userCurrency), 1);
            } else {
                $currency = Helper::convertCurrency(strtoupper('NGN'), strtoupper('NGN'), 1);
            }

            $array['price'] = "IF((currency = '".strtoupper($userCurrency)."'), (price), (price * ".$currency.")) as price";
            $array['currency'] = "IF((currency = '".strtoupper($userCurrency)."'), (currency), ('".$userCurrency."')) as currency";

            $plans = SubscriptionPlan::select('*', DB::raw(implode(", ", $array)))->where('type', 'like', '%business%')->where('is_blocked',0)->get();
        } elseif(!Auth::check()) {
            $userCurrency = 'USD';

            $currency = Helper::convertCurrency(strtoupper('NGN'), strtoupper($userCurrency), 1);

            $array['price'] = "IF((currency = '".strtoupper($userCurrency)."'), (price), (price * ".$currency.")) as price";
            $array['currency'] = "IF((currency = '".strtoupper($userCurrency)."'), (currency), ('".$userCurrency."')) as currency";

            $plans = SubscriptionPlan::select('*', DB::raw(implode(", ", $array)))->where('type', 'like', '%business%')->where('is_blocked',0)->get();
        }else{
            $plans = SubscriptionPlan::where('type', 'like', '%business%')->where('is_blocked',0)->get();
        
        }

        return view('subscription-plan-pages.business', compact('pageTitle', 'flag', 'plans', 'metaDescription'));
    }

    /**
     * Display a plans of Search Subscription Plan of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search()
    {
        $pageTitle = "Weafricans Search Subscription Plans";
        $flag = 0;
        $plans = SubscriptionPlan::where('title', 'like', '%Search%')->where('is_blocked',0)->get();
        return view('subscription-plan-pages.search', compact('pageTitle', 'flag', 'plans'));
    }

    /**
     * Display a plans of Premium Subscription Plan of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function premium()
    {
        $pageTitle = "Business Services For B2B Customers | Premium membership for B2B Customers | Weafricans.com";
        $metaDescription = "Weafricans provide a extra facility to premium membership customers that help transform a small mid and semi large size african business and get connected to potential business partners,importers and real buyers.";
        $flag = 1;

        if (Auth::check() && Auth::user()->currency && Auth::user()->currency != 'NGN') {
            $userCurrency = Auth::user()->currency ? Auth::user()->currency : 'NGN';

            if ($userCurrency != 'NGN') {
                $currency = Helper::convertCurrency(strtoupper('NGN'), strtoupper($userCurrency), 1);
            } else {
                $currency = Helper::convertCurrency(strtoupper('NGN'), strtoupper('NGN'), 1);
            }

            $array['price'] = "IF((currency = '".strtoupper($userCurrency)."'), (price), (price * ".$currency.")) as price";
            $array['currency'] = "IF((currency = '".strtoupper($userCurrency)."'), (currency), ('".$userCurrency."')) as currency";

            $plans = SubscriptionPlan::select('*', DB::raw(implode(", ", $array)))->where('type', 'like', '%Premium%')->where('is_blocked',0)->get();
        } elseif(!Auth::check()) {

            $userCurrency = 'USD';

            $currency = Helper::convertCurrency(strtoupper('NGN'), strtoupper($userCurrency), 1);

            $array['price'] = "IF((currency = '".strtoupper($userCurrency)."'), (price), (price * ".$currency.")) as price";
            $array['currency'] = "IF((currency = '".strtoupper($userCurrency)."'), (currency), ('".$userCurrency."')) as currency";

            $plans = SubscriptionPlan::select('*', DB::raw(implode(", ", $array)))->where('type', 'like', '%premium%')->where('is_blocked', 0)->get();
        }else{
            $plans = SubscriptionPlan::where('type', 'like', '%Premium%')->where('is_blocked',0)->get();
        
        }
        
        return view('subscription-plan-pages.premium', compact('pageTitle', 'flag', 'plans', 'metaDescription'));
    }
}
