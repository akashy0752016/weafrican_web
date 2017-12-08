<?php

namespace App\Http\Controllers\Api\v2;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BusinessVideo;
use App\User;   
use Validator;

class BusinessVideoController extends Controller
{
    /**
     * Create a controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->video = new BusinessVideo();
    }

    /**
     * Function: get User all Videos list.
     * Url: api/v2/business/video/index
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $input = $request->input();

        $validator = Validator::make($input, [
                'userId' => 'required|integer',
                'index' => 'required',
                'limit' => 'required',
        ]);

        if ($validator->fails()) 
            return response()->json(['status' => 'exception','response' => $validator->errors()->first()]);   
            
        $videos = $this->video->whereUserId($input['userId'])->whereIsBlocked(0)->whereDeletedAt(null)->orderBy('created_at', 'desc')->skip($input['index'])->take($input['limit'])->get();

        if($videos->count() > 0)
            return response()->json(['status' => 'success','response' => $videos]);
        else
            return response()->json(['status' => 'exception','response' => 'No more video found.']);
    }

    /**
     * Show the form for creating a new resource or update.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

    }

    /**
     * Function: create and update User Video Details.
     * Url: api/v2/business/video/create
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $input = $request->input();

        $validator = Validator::make($input, [
                'userId' => 'required',
                'businessId' => 'required',
                'id' => 'sometimes|required',
                'title' => 'required',
                'description' => 'required',
                'type' => 'required',
                'thumbnailImage' => 'required|url',
                'url' => 'required|max:255|unique:business_videos,url,'.((isset($input['id'])&&($input['id'] != null)) ? ($input['id'].',id'): 'null,null'.',user_id,'.$input['userId']),
        ]);

        if ($validator->fails()) {
                return response()->json(['status' => 'exception','response' => $validator->errors()->first()]);   
        }

        $user = User::find($request->userId);
        
        if (isset($input['id']) && $input['id'] != null) {
            $businessVideo = $this->video->find($input['id']); 
           
            if($businessVideo){
                $video = array_intersect_key($request->input(), BusinessVideo::$updatable);

                $video['user_id'] = $input['userId'];
                $video['business_id'] = $input['businessId'];
                //$video['thumbnail_image'] = $input['thumbnailImage'];
                $video = BusinessVideo::whereId($input['id'])->update($video);

                if ($video)
                    return response()->json(['status' => 'success','response' => 'Video updated successfully.']);
                else
                    return response()->json(['status' => 'exception','response' => 'Could not update video data.Please try again.']);
            }
            
        } else {
            
            $video = array_intersect_key($request->input(), BusinessVideo::$updatable);

            $video['user_id'] = $input['userId'];
            $video['business_id'] = $input['businessId'];
            $video['thumbnail_image'] = $input['thumbnailImage'];
            if ($input['type'] == 'youtube') {
                $videoId = (strpos($input['url'], '?v=')) ? explode("?v=", $input['url']): explode("https://youtu.be/", $input['url']);
            if (!$videoId) {
                return response()->json(['status' => 'failure','response' => 'Please enter a correct url']);
            }
                $videoId = $videoId[1];
                $embedUrl = 'https://www.youtube.com/embed/'.$videoId;
            }
            elseif ($input['type'] == 'vimeo') {
                $videoId = (int) substr(parse_url($input['url'], PHP_URL_PATH), 1);
                $hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/$videoId.php"));
                if ($hash == null) {
                    return response()->json(['status' => 'failure','response' => 'Please enter a correct url']);
                }
                $embedUrl = 'http://player.vimeo.com/video/'.$videoId;
            }
            else {
                return response()->json(['status' => 'failure','response' => 'Incorrect video type.']);
            }

            $video['embed_url'] = $embedUrl;
            $video = BusinessVideo::create($video);

            if ($video->save())
                return response()->json(['status' => 'success','response' => $video]);
            else
                return response()->json(['status' => 'exception','response' => 'Could not save video data.Please try again.']);
        }
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
     * Function: delete User Video .
     * Url: api/v2/business/video/delete
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request)
    {
        $input = $request->input();

        $validator = Validator::make($input, [
                'userId' => 'required|integer',
                'id' => 'required|integer'
        ]);

        if ($validator->fails()) 
            return response()->json(['status' => 'exception','response' => $validator->errors()->first()]);   

        $video = $this->video->whereUserId($input['userId'])->whereId($input['id'])->delete();

        if ($video)
            return response()->json(['status' => 'success', 'response' => 'Video deleted successfully.']);
        else
            return response()->json(['status' => 'exception', 'response' => 'Video could not be deleted.Please try again.']);

    }
}
