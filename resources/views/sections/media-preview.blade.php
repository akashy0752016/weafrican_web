<span>VIDEO THUMBNAILS <i class="fa fa-question-circle" data-toggle="popover" data-placement="right" data-content="Choose the thumbnail that best represents your video. To be able to add custom thumbnails your account needs to be verified and in good standing. Learn more"></i></span>
<ul>
    @for ($i=1; $i<=3;$i++)
        <li>
            <label>
                @if($i==1)
                    <input name="video_thumbnail" type="radio" value="{{$result[fileName]}}" checked class="video-thumbnail-option" required onChange="getValue('{{$result[fileName]}}')">
                    <img src="{{ asset('uploads/medias/temp/'.$result[uuid].'/'.$result[fileName]) }}" class='img-responsive'>
                @else
                    <input name="video_thumbnail" type="radio" value="{{$result[fileName]}}" class="video-thumbnail-option" required onChange="getValue('{{$result[fileName]}}')">
                    <img src="{{ asset('uploads/medias/temp/'.$result[uuid].'/'.$result[fileName])}}" class='img-responsive'>
                @endif
            </label>
        </li>
    @endfor
</ul>