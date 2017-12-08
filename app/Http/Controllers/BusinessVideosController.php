<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BusinessVideo;
use App\UserBusiness;
use App\Helper;
use Validator;
use Auth;

class BusinessVideosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageTitle = "Business Videos";
        $videos = BusinessVideo::where('user_id',Auth::id())->where('is_blocked',0)->orderBy('id', 'desc')->paginate(10);
        $flag = 0;
        return view('business-video.index', compact('videos','pageTitle', 'flag'));
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
        $input = $request->input();

        $validator = Validator::make($input, [

                'id' => 'sometimes|required',
                'title' => 'required',
                'description' => 'required',
                'url' => 'required|max:255|unique:business_videos,url,'.((isset($input['id'])&&($input['id'] != null)) ? ($input['id'].',id'): 'null,null'.',user_id,'.Auth::id()),
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'failure','response' => $validator->errors()->first()]);
        }

        $yt_rx = '/^((?:https?:)?\/\/)?((?:www|m)\.)?((?:youtube\.com|youtu.be))(\/(?:[\w\-]+\?v=|embed\/|v\/)?)([\w\-]+)(\S+)?$/';
        $has_match_youtube = preg_match($yt_rx, $input['url'], $yt_matches);

        $vm_rx = '/(https?:\/\/)?(www\.)?(player\.)?vimeo\.com\/([a-z]*\/)*([‌​0-9]{6,11})[?]?.*/';
        $has_match_vimeo = preg_match($vm_rx, $input['url'], $vm_matches);

        //Then we want the video id which is:
        if ($has_match_youtube) {
            $type = 'youtube';
            $videoId = (strpos($input['url'], '?v=')) ? explode("?v=", $input['url']): explode("https://youtu.be/", $input['url']);
            if (!$videoId) {
                return response()->json(['status' => 'failure','response' => 'Please enter a correct url']);
            }
            $videoId = $videoId[1];
            $thumbnailImage = 'https://img.youtube.com/vi/'.$videoId.'/hqdefault.jpg';
            $embedUrl = 'https://www.youtube.com/embed/'.$videoId;
        }
        elseif ($has_match_vimeo) {
            $videoId = (int) substr(parse_url($input['url'], PHP_URL_PATH), 1);
            $hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/$videoId.php"));
            if ($hash == null) {
                return response()->json(['status' => 'failure','response' => 'Please enter a correct url']);
            }
            $thumbnailImage = $hash[0]['thumbnail_medium'];
            $type = 'vimeo';
            $embedUrl = 'http://player.vimeo.com/video/'.$videoId;
        }
        else {
            $type  = 'none';
            return response()->json(['status' => 'failure','response' => 'Please enter a correct url']);
        }

        $business = UserBusiness::whereUserId(Auth::id())->first();

        $video = new BusinessVideo();

        $video->user_id = Auth::id();
        $video->business_id = $business->id;
        $video->title = $input['title'];
        $video->description = $input['description'];
        $video->url = $input['url'];
        $video->embed_url = $embedUrl;
        $video->type = $type;
        $video->thumbnail_image = $thumbnailImage;
        $video->slug = Helper::slug($input['title'], $video->id);

        $video->save();

        $videos = BusinessVideo::where('user_id',Auth::id())->where('is_blocked',0)->orderBy('id', 'desc')->paginate(10);

        $response = view('sections.video-list')->with('videos',$videos)->render();

        return response()->json(['status' => 'success','response' => $response]);

        //return redirect('business-service')->with('success', 'New Service created successfully');
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
        $video = BusinessVideo::find($id);
        return response()->json(['status' => 'success','response' => $video]);

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
        $validator = Validator::make($request->all(),BusinessVideo::$updateValidater);

        if ($validator->fails()) {
            return response()->json(['status' => 'failure','response' => $validator->errors()->first()]);
        }

        $input = $request->input();
      
        // $yt_rx = '/^((?:https?:)?\/\/)?((?:www|m)\.)?((?:youtube\.com|youtu.be))(\/(?:[\w\-]+\?v=|embed\/|v\/)?)([\w\-]+)(\S+)?$/';
        // $has_match_youtube = preg_match($yt_rx, $input['url'], $yt_matches);

        // $vm_rx = '/(https?:\/\/)?(www\.)?(player\.)?vimeo\.com\/([a-z]*\/)*([‌​0-9]{6,11})[?]?.*/';
        // $has_match_vimeo = preg_match($vm_rx, $input['url'], $vm_matches);

        // //Then we want the video id which is:
        // if ($has_match_youtube) {
        //     $type = 'youtube';
        //     $videoId = explode("?v=", $input['url']);
        //     $videoId = $videoId[1];
        //     $thumbnailImage = 'https://img.youtube.com/vi/'.$videoId.'/hqdefault.jpg';
        //     $embedUrl = 'https://www.youtube.com/embed/'.$videoId;
        // }
        // elseif ($has_match_vimeo) {
        //     $videoId = (int) substr(parse_url($input['url'], PHP_URL_PATH), 1);
        //     $hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/$videoId.php"));
        //     $thumbnailImage = $hash[0]['thumbnail_medium'];
        //     $type = 'vimeo';
        //     $embedUrl = 'http://player.vimeo.com/video/'.$videoId;
        // }
        // else {
        //     $type  = 'none';
        //     return response()->json(['status' => 'failure','response' => 'Please enter a correct url']);
        // }

        $input = array_intersect_key($input, BusinessVideo::$updatable);

        /*$input['embed_url'] = $embedUrl;
        $input['type'] = $type;
        $input['thumbnail_image'] = $thumbnailImage;
        $input['slug'] = Helper::slug($input['title'], $id);*/

        $service = BusinessVideo::where('id',$id)->update($input);

        $videos = BusinessVideo::where('user_id',Auth::id())->where('is_blocked',0)->orderBy('id', 'desc')->paginate(10);

        $response = view('sections.video-list')->with('videos',$videos)->render();

        return response()->json(['status' => 'success','response' => $response]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $video = BusinessVideo::findOrFail($id);

        if($video->delete()){
            $response = array(
                'status' => 'success',
                'message' => 'Video deleted  successfully',
            );
        } else {
            $response = array(
                'status' => 'error',
                'message' => 'Video can not be deleted.Please try again',
            );
        }

        return json_encode($response);
    }
}
