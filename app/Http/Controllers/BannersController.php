<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;

use App\HomePageBanner;
use App\BusinessBanner;
use App\EventBanner;
use Auth;

class BannersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageTitle = 'Banners';

        $homeBanners = HomePageBanner::where('user_id', Auth::id())->get();

        $eventBanners = EventBanner::where('user_id', Auth::id())->get();

        $businessBanners = BusinessBanner::where('user_id', Auth::id())->get();

        $flag=0;
        
        return view('banners.index', compact('pageTitle', 'homeBanners', 'eventBanners', 'businessBanners', 'flag'));
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
        $pageTitle = "Edit Banner - Admin";
        $banner = BusinessBanner::find($id);
        $flag=0;
        return view('admin.banners.edit',compact('banner','pageTitle', 'flag'));
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
        $banner = BusinessBanner::find($id);

        if (!$banner) {
            return back()->with('error', 'Sorry, the banner you requested does not exists');
        }

        $validator = Validator::make($request->input(), BusinessBanner::$validator);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $input = array_intersect_key($request->input(), BusinessBanner::$updatable);

        if ($banners->update($input)){
            return redirect('business-banner')->with('success', 'Banner Updated successfully');
        } else {
            return back()->with('error', 'Banner could not be updated. Please try again.');
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
        $banner = HomePageBanner::findOrFail($id);
        if ($banner->delete()) {
            $response = array(
                'status' => 'success',
                'message' => ' Home Banner deleted  successfully',
            );
        } else {
            $response = array(
                'status' => 'error',
                'message' => ' Home Banner can not be deleted.Please try again',
            );
        }
        return json_encode($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteBusinessBanner($id)
    {
        $banner = BusinessBanner::findOrFail($id);
        if ($banner->delete()) {
            $response = array(
                'status' => 'success',
                'message' => ' Business Banner deleted  successfully',
            );
        } else {
            $response = array(
                'status' => 'error',
                'message' => 'Business Banner can not be deleted.Please try again',
            );
        }
        return json_encode($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteEventBanner($id)
    {
        $banner = EventBanner::findOrFail($id);
        if ($banner->delete()) {
            $response = array(
                'status' => 'success',
                'message' => ' Event Banner deleted  successfully',
            );
        } else {
            $response = array(
                'status' => 'error',
                'message' => 'Event Banner can not be deleted.Please try again',
            );
        }
        return json_encode($response);
    }

    public function blockHomeBanner($id)
    {
        $banner = HomePageBanner::find($id);
        $banner->is_blocked = !$banner->is_blocked;
        $banner->save();

        if ($banner->is_blocked) {
            return redirect('banners')->with('success', 'Home Banner blocked successfully');
        } else {
            return redirect('banners')->with('success', 'Home Banner unblocked successfully');
        }
    }

    public function blockEventBanner($id)
    {
        $banner = EventBanner::find($id);
        $banner->is_blocked = !$banner->is_blocked;
        $banner->save();

        if ($banner->is_blocked) {
            return redirect('banners')->with('success', 'Event Banner blocked successfully');
        } else {
            return redirect('banners')->with('success', 'Event Banner unblocked successfully');
        }
    }
}