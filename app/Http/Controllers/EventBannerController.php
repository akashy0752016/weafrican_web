<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\EventBanner;
use App\BusinessEvent;
use App\CountryList;
use App\EventCategory;
use Auth;
use Validator;
use Image;
use App\Helper;
use App\SubscriptionPlan;
use App\User;
use DB;

class EventBannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageTitle = "Event Banners | Weafricans";
        $eventBanners = EventBanner::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
        $flag=0;
        return view('my-account.event', compact('pageTitle','eventBanners', 'flag'));
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
        $pageTitle = "Event Banners Edit | Weafricans";
        $eventBanner = EventBanner::where('user_id', Auth::id())->find($id);
        
        $currentDateTime = date("Y-m-d H:i:s");
        $events = BusinessEvent::where('user_id', Auth::id())->where('end_date_time','>=',$currentDateTime)->where('is_blocked',0)->get();
        $categories = EventCategory::where('is_blocked',0)->get();
        
        $countries = User::select('country')->distinct()->whereNotNull('country')->get();

        if($eventBanner->state=="" or $eventBanner->state==NULL)
            $states = User::select('state')->distinct()->whereNotNull('state')->where('country',$eventBanner->user->country)->get();
        else
            $states = User::select('state')->distinct()->whereNotNull('state')->where('country',$eventBanner->country)->get();

        if($eventBanner->city=="" or $eventBanner->city==NULL)
            $cities = User::select('city')->distinct()->whereNotNull('city')->where('state',$eventBanner->user->state)->get();
        else
            $cities = User::select('city')->distinct()->whereNotNull('city')->where('state',$eventBanner->state)->get();

        $flag=0;
        return view('my-account.event_edit', compact('pageTitle','eventBanner','countries', 'states', 'cities','events','categories', 'flag'));
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
            'event_category_id' => 'sometimes|required',
            'business_event_id' => 'sometimes|required_if:is_selected,1',
            'country' => 'sometimes|required_with:state',
            'state' => 'sometimes|required_with:city',
            'city' => 'sometimes|required',
            'image' => 'sometimes|required|image|mimes:jpg,png,jpeg',
            'is_blocked' => 'required'
        ],$messages);

        if ($validator->fails()) {
            return back()->withErrors($validator)
                         ->withInput();
        }

        $eventBanner = EventBanner::find($id);
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
                    })->save(config('image.banner_image_path').'event/thumbnails/large/' . $image);
                
                $img->resize(config('image.medium_thumbnail_width'), null, function($constraint) {
                     $constraint->aspectRatio();
                })->save(config('image.banner_image_path').'event/thumbnails/medium/' . $image);
                
                $img->resize(config('image.small_thumbnail_width'), null, function($constraint) {
                     $constraint->aspectRatio();
                })->save(config('image.banner_image_path').'event/thumbnails/small/' . $image);
                $fileName = $file->move(config('image.banner_image_path').'event/', $image);
            }
        }
        if(isset($input['is_selected']) and $input['is_selected']==1)
        {
            $input['image'] = "";
        }
        if(isset($input['is_selected']) and $input['is_selected']==0)
        {
            $input['business_event_id'] = NULL;
        }
        $input = array_intersect_key($input, EventBanner::$updatable);

        if(isset($image))
        {
            $input['image'] = $image;
        }

        $eventBanner = EventBanner::where('id',$id)->update($input);
        
        if($eventBanner)
        {
            return redirect('event-banner')->with('banner', EventBanner::where('id',$id)->first());
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
        $banner = EventBanner::find($id);
        $banner->is_blocked = !$banner->is_blocked;
        $banner->save();

        if ($banner->is_blocked) {
            return redirect('event-banner')->with('success', 'Event Banner blocked successfully');
        } else {
            return redirect('event-banner')->with('success', 'Event Banner unblocked successfully');
        }
    }

    /**
     * Buy a specified Event Subscription Plan.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function buyEventSubscriptionPlan($id)
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

                    $subscriptPlan = SubscriptionPlan::select('*', DB::raw(implode(", ", $array)))->where('type', 'event')->where('is_blocked', 0)->find($id);
                } else {

                    $subscriptPlan = SubscriptionPlan::where('type', 'event')->find($id);
                }

                //Actual price of subscription plan in NGN
                $price = SubscriptionPlan::select('price')->where('type', 'event')->find($id);

                if($subscriptPlan)
                {
                    $pageTitle = "Buy ".$subscriptPlan->title." | Weafricans";
                    $flag=0;
                    return view('subscription-plan.buy-subscription', compact('pageTitle','subscriptPlan', 'flag', 'price'));
                }else
                {
                    return back()->with('Error', 'Event Supscription plan dose not exits or blocked by admin. Please try after some time.');
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
