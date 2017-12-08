<div class="panel panel-default table_set ">
        <table class="table">
            <thead>
                <tr>
                    <th>Video thumbnail</th>
                    <th>Video title</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @if($videos->count() > 0) 
                @foreach($videos as $video)
                    <tr>
                        <td class="video_play"> 
                        @if($video->thumbnail_image)
                        <div class="video_container">
                            <img src="{{$video->thumbnail_image}}"><a data-toggle="modal" onclick="javascript:videoModal('{{ $video->title }}', '{{ $video->embed_url }}')"   title="Watch Video"> <i class="fa fa-play-circle-o" aria-hidden="true"></i></a>  </div>
                        @else
                        <p>No image found</p>
                        @endif
                        </td>
                        <td>{{$video->title}}</td>
                        <td>{{$video->description}}</td>
                        <td>
                            <ul class="list-inline">
                                <li>
                                    <a class="btn btn-default btn_fix" data-toggle="modal" onclick="javascript:getVideoData('{{ $video->id }}')"  title="Edit Video"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                    <!-- Create Video Modal-->
                                    
                                    
                                </li>
                                <li>
                                    <form action="{{url('business-video/'.$video->id)}}" method="POST" onsubmit="deleteVideo('{{$video->id}}', '{{$video->title}}', event,this)">
                                        {{csrf_field()}}
                                        <button type="submit" class="btn btn-danger btn_fix" title="Delete Video"><i class="fa fa-trash-o" aria-hidden="true"></i>
                                        </button>
                                    </form>
                                </li>
                            <ul>
                        </td>
                    <tr>
                @endforeach
            @else
                <tr>
                    <td>No videos found</td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>
    {{ $videos->links() }}
