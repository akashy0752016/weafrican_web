<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BusinessBanner;
use Auth;
use Validator;
use Image;
use App\Helper;
use App\BussinessCategory;
use App\CountryList;
use App\SubscriptionPlan;
use App\User;
use DB;

class BusinessBannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageTitle = "Business Banners | Weafricans";
        $businessBanners = BusinessBanner::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
        $flag=0;
        return view('my-account.business', compact('pageTitle','businessBanners', 'flag'));
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
        $pageTitle = "Business Banners Edit | Weafricans";
        $businessBanner = BusinessBanner::where('user_id', Auth::id())->find($id);
        $categories = BussinessCategory::where('is_blocked',0)->whereIn('parent_id',array(0,NULL))->get();
        $subCategories = BussinessCategory::where('is_blocked',0)->where('parent_id',$businessBanner->business_category_id)->get();

        $countries = User::select('country')->distinct()->whereNotNull('country')->get();

        if($businessBanner->state=="" or $businessBanner->state==NULL)
            $states = User::select('state')->distinct()->whereNotNull('state')->where('country',$businessBanner->user->country)->get();
        else
            $states = User::select('state')->distinct()->whereNotNull('state')->where('country',$businessBanner->country)->get();

        if($businessBanner->city=="" or $businessBanner->city==NULL)
            $cities = User::select('city')->distinct()->whereNotNull('city')->where('state',$businessBanner->user->state)->get();
        else
            $cities = User::select('city')->distinct()->whereNotNull('city')->where('state',$businessBanner->state)->get();

        $flag=0;
        return view('my-account.business_edit', compact('pageTitle','businessBanner','categories','countries', 'states', 'cities', 'subCategories', 'flag'));
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
            'business_category_id' => 'sometimes|required_with:business_subcategory_id',
            'business_subcategory_id' => 'sometimes',
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

        $businessBanner = BusinessBanner::find($id);
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
                    })->save(config('image.banner_image_path').'business/thumbnails/large/' . $image);
                
                $img->resize(config('image.medium_thumbnail_width'), null, function($constraint) {
                     $constraint->aspectRatio();
                })->save(config('image.banner_image_path').'business/thumbnails/medium/' . $image);
                
                $img->resize(config('image.small_thumbnail_width'), null, function($constraint) {
                     $constraint->aspectRatio();
                })->save(config('image.banner_image_path').'business/thumbnails/small/' . $image);
                $fileName = $file->move(config('image.banner_image_path').'business/', $image);
            }
        }
        if(isset($input['is_selected']) and $input['is_selected']==1)
        {
            $input['image'] = "";
        }
        $input = array_intersect_key($input, BusinessBanner::$updatable);
        /*if(!isset($input['business_subcategory_id']) or $input['business_subcategory_id']=="")
        {
            $input['business_subcategory_id'] = NULL;
        }*/
        if(isset($image))
        {
            $input['image'] = $image;
        }

        $businessBanner = BusinessBanner::where('id',$id)->update($input);
        
        if($businessBanner)
        {
            return redirect('business-banner')->with('banner', BusinessBanner::where('id',$id)->first());
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
        $banner = BusinessBanner::find($id);
        $banner->is_blocked = !$banner->is_blocked;
        $banner->save();

        if ($banner->is_blocked) {
            return redirect('business-banner')->with('success', 'Business Banner blocked successfully');
        } else {
            return redirect('business-banner')->with('success', 'Business Banner unblocked successfully');
        }
    }

    /**
     * Buy a specified Business Subscription Plan.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function buyBusinessSubscriptionPlan($id)
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

                    $subscriptPlan = SubscriptionPlan::select('*', DB::raw(implode(", ", $array)))->where('type', 'business')->where('is_blocked', 0)->find($id);
                } else {

                    $subscriptPlan = SubscriptionPlan::where('type', 'business')->find($id);
                }

                //Actual price of subscription plan in NGN
                $price = SubscriptionPlan::select('price')->where('type', 'business')->find($id);
                
                if($subscriptPlan)
                {
                    $pageTitle = "Buy ".$subscriptPlan->title." | Weafricans";
                    $flag=0;
                    return view('subscription-plan.buy-subscription', compact('pageTitle','subscriptPlan', 'flag', 'price'));
                }else
                {
                    return back()->with('Error', 'Business Supscription plan dose not exits or blocked by admin. Please try after some time.');
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
