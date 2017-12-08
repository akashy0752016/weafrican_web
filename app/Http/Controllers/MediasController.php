<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\UploadHandler;

class MediasController extends Controller
{
    public $uploadHandler;
    
    public function __construct()
    {
        $this->uploadHandler  = new UploadHandler(); 
    }

    public function postUploadMedia()
    { 	
        $this->uploadHandler->chunksFolder = config('image.file_chunks_path');

        $result = $this->uploadHandler->handleUpload(config('image.media_temp_path'));

        return json_encode($result);
    }


    public function postCombinedChunks()
    {
        $this->uploadHandler->chunksFolder = config('image.file_chunks_path');

        $result = $this->uploadHandler->combineChunks(config('image.media_temp_path'));

        return $result;
        //return json_encode(array('message' => 'Testsdsd'));
    }
}
