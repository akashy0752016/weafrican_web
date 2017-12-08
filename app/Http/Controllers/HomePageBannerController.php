<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\HomePageBanner;
use App\CountryList;
use App\BusinessEvent;
use Auth;
use Validator;
use Image;
use App\Helper;
use App\SubscriptionPlan;
use App\User;
use DB;

class HomePageBannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageTitle = "Sponsor Banners | Weafricans";
        $flag=0;
        $homeBanners = HomePageBanner::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
        return view('my-account.sponsor', compact('pageTitle','homeBanners', 'flag'));
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
        $pageTitle = "Sponsor Banners Edit | Weafricans";
        $flag=0;
        $homeBanner = HomePageBanner::where('user_id', Auth::id())->find($id);
        
        $currentDateTime = date("Y-m-d H:i:s");
        $events = BusinessEvent::where('user_id', Auth::id())->where('end_date_time','>=',$currentDateTime)->where('is_blocked',0)->get();
        
        $countries = User::select('country')->distinct()->whereNotNull('country')->get();

        if($homeBanner->state=="" or $homeBanner->state==NULL)
            $states = User::select('state')->distinct()->whereNotNull('state')->where('country',$homeBanner->user->country)->get();
        else
            $states = User::select('state')->distinct()->whereNotNull('state')->where('country',$homeBanner->country)->get();

        if($homeBanner->city=="" or $homeBanner->city==NULL)
            $cities = User::select('city')->distinct()->whereNotNull('city')->where('state',$homeBanner->user->state)->get();
        else
            $cities = User::select('city')->distinct()->whereNotNull('city')->where('state',$homeBanner->state)->get();

        return view('my-account.sponsor_edit', compact('pageTitle','homeBanner','countries', 'states', 'cities', 'events', 'flag'));
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
        $messages = array(
            'is_selected.required' => 'Please choose a banner.',
        );

        $validator = Validator::make($request->all(), [
            'is_selected' => 'sometimes|required|integer',
            'business_event_id' => 'required_if:is_selected,2',
            'country' => 'sometimes|required_with:state',
            'state' => 'sometimes|required',
            'image' => 'sometimes|required|image|mimes:jpg,png,jpeg',
            'is_blocked' => 'required'
        ],$messages);

        if ($validator->fails()) {
            return back()->withErrors($validator)
                         ->withInput();
        }

        $homeBanner = HomePageBanner::find($id);
        $input = $request->input();
        
        if ($request->hasFile('image') ){
            $file = $request->file('image');
            if ($file->isValid())
            {
                $image_name = $key = md5(uniqid(rand(), true));
                $ext = $file->
                    getClientOriginalExtension();
                $image = $image_name.'.'.$ext; 

                $img = Image::make($file->getRealPath());

                $img->resize(config('image.large_thumbnail_width'), null, function($constraint) {
                         $constraint->aspectRatio();
                    })->save(config('image.banner_image_path').'home/thumbnails/large/' . $image);
                
                $img->resize(config('image.medium_thumbnail_width'), null, function($constraint) {
                     $constraint->aspectRatio();
                })->save(config('image.banner_image_path').'home/thumbnails/medium/' . $image);
                
                $img->resize(config('image.small_thumbnail_width'), null, function($constraint) {
                     $constraint->aspectRatio();
                })->save(config('image.banner_image_path').'home/thumbnails/small/' . $image);
                $fileName = $file->move(config('image.banner_image_path').'home/', $image);
            }
        }
        if(isset($input['is_selected']) and ($input['is_selected']==1 or $input['is_selected']==2))
        {
            $input['image'] = "";
        }
        if(isset($input['is_selected']) and $input['is_selected']!=2)
        {
            $input['business_event_id'] = NULL;
        }
        $input = array_intersect_key($input, HomePageBanner::$updatable);

        if(isset($image))
        {
            $input['image'] = $image;
        }

        $homeBanner = HomePageBanner::where('id',$id)->update($input);
        
        if($homeBanner)
        {
            return redirect('sponsor-banner')->with('banner', HomePageBanner::where('id',$id)->first());
        }else
        {
            return back()->with('Error', 'Banner image cannot be updated. Please try again');
        }
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
     * Block the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function block($id)
    {
        $banner = HomePageBanner::find($id);
        $banner->is_blocked = !$banner->is_blocked;
        $banner->save();

        if ($banner->is_blocked) {
            return redirect('sponsor-banner')->with('success', 'Sponsor Banner blocked successfully');
        } else {
            return redirect('sponsor-banner')->with('success', 'Sponsor Banner unblocked successfully');
        }
    }

    /**
     * Buy a specified Event Subscription Plan.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function buySponsorSubscriptionPlan($id)
    {
        if(Auth::check() and (Auth::user()->user_role_id==3 || Auth::user()->user_role_id==5))
        {
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

                    $subscriptPlan = SubscriptionPlan::select('*', DB::raw(implode(", ", $array)))->where('type', 'sponsor')->where('is_blocked', 0)->find($id);
                } else {

                    $subscriptPlan = SubscriptionPlan::where('type', 'sponsor')->find($id);
                }

                //Actual price of subscription plan in NGN
                $price = SubscriptionPlan::select('price')->where('type', 'sponsor')->find($id);

                if($subscriptPlan)
                {
                    $pageTitle = "Buy ".$subscriptPlan->title." | Weafricans";
                    $flag=0;
                    return view('subscription-plan.buy-subscription', compact('pageTitle','subscriptPlan', 'flag', 'price'));
                }else
                {
                    return back()->with('Error', 'Sponsor Supscription plan dose not exits or blocked by admin. Please try after some time.');
                }
            }else
            {
                return redirect('register-business/'.Auth::id())->with('warning', 'Your business is not verified by the admin. Your business and event will get live once admin verify your documents.');
            }
        }elseif(!Auth::check())
        {
            return redirect('login');
        }else
        {
            return redirect('/');
        }
    }
}
