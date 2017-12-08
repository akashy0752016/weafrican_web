<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\BusinessVideo;

class AdminBusinessVideosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageTitle = 'Admin - Premium User Video';
        $videos = BusinessVideo::select('business_videos.*', 'user_businesses.id as businessId','user_businesses.business_id', 'user_businesses.title as business_name')->leftJoin('user_businesses','business_videos.user_id' , '=', 'user_businesses.user_id')->get();
        return view('admin.videos.index', compact('pageTitle', 'videos'));
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

    public function block($id)
    {
        $video = BusinessVideo::find($id);
        $video->is_blocked = !$video->is_blocked;
        $video->save();

        if ($video->is_blocked) {
            return redirect('admin/video')->with('success', 'Video has been blocked successfully');
        } else {
            return redirect('admin/video')->with('success', 'Video has been unblocked');
        }
    }
}
