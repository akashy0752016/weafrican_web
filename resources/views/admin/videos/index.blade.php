@extends('admin.layouts.adminapp')
@section('title', $pageTitle)
@section('content')
	<h2>Videos</h2>
	<hr>
	<div class="all_content">
	@include('notification')
	<table id="video_list" class="display">
		<thead>
			<tr>
				<th>Business ID</th>
				<th>Business Name</th>
				<th>Video Thumbnail</th>
				<th>Title</th>
				<th>Description</th>
				<th>Created On</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			@foreach($videos as $video) 
			<tr>
				<td><a href="{{ url('admin/business/'.$video->businessId) }}">{{ $video->business_id}}</a></td>
				<td>{{ $video->business_name}}</td>
				<td class="video_play">@if(!empty($video->thumbnail_image && $video->embed_url))
						<img class="video-image" src="{{$video->thumbnail_image}}"><a data-toggle="modal" onclick="javascript:videoModal('{{ $video->title }}', '{{ $video->embed_url }}')"   title="Watch Video"> <i class="fa fa-play-circle-o" aria-hidden="true"></i></a>
					@else 
						<p>No video found</p>
					@endif </td>
				<td>{{ $video->title}}  </td>
				<td>{{ $video->description}}</td>
				<td>{{ date_format(date_create($video->created_at), 'd M,Y') }}</td>
				<td>
					<a href="{{ URL::to('admin/video/block/'.$video->id) }}">
	                    @if($video->is_blocked)
	                    	<button type="button" class="btn btn-danger btn_fixes" title="Unblock"><i class="fa fa-unlock"></i></button>
	                	@else
	                		<button type="button" class="btn btn-success btn_fixes" title="Block"><i class="fa fa-ban"></i></button>
	            		@endif
	        		</a>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
	</div>

	<!-- Watch Video Modal -->
    <div class="modal fade" id="watchVideo" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="video-title"></h4>
                </div>
                <div class="modal-body">
                        <iframe id="video" width="870	" height="345" src="" frameborder="0" allowfullscreen>
                        </iframe>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
<script type="text/javascript">
	$(document).ready( function () {
		$('#video_list').DataTable();
	} );

	function videoModal (title, src) {
        var url = src +"?autoplay=1";

        $("#watchVideo").modal('show');

	    $("#watchVideo").on('shown.bs.modal', function(){
	        $('.video-title').html(title);

	        $("#video").attr('src', url);

	    });
    
	    $("#watchVideo").on('hide.bs.modal', function(){

	        $("#video").attr('src', '');

	    });
    }
</script>
@endsection
