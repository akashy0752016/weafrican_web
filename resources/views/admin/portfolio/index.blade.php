@extends('admin.layouts.adminapp')
@section('title', $pageTitle)
@section('styles')
    <link href="{{ asset('css/lightgallery/lightgallery.css')}}" rel="stylesheet">
    <style>
        .list-unstyled>li:first-child{
            display: block;
        }
        .list-unstyled>li{
        display:none;
    }
    </style>
@endsection
@section('content')
	<p><h2><i class="fa fa-folder-open" aria-hidden="true"></i> Portfolio (Total Portfolio - {{ count($portfolios)}})</h2>
	<hr>
	<div class="all_content">
	@include('notification')
	<table id="subscription_list" class="display">
		<thead>
			<tr>
				<th title="Serial Number">#</th>
				<th>Business ID</th>
				<th>Business Name</th>
				<th>Title</th>
				<th>Description</th>
				<th>Image</th>
				<th>Created On</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			@foreach($portfolios as $key => $portfolio) 
			<tr>
				<td> {{++$key}}</td>
				<td><a href="{{ url('admin/business/'.$portfolio->businessId) }}">{{ $portfolio->business_id}}</a></td>
				<td>{{ $portfolio->business_name}}</td>
				<td>{{ $portfolio->title}}  </td>
				<td>{{ $portfolio->description}}</td>
                <td>
                	
                	@if(isset($portfolio->featured_image))
                		<div class="demo-gallery portfolio_gallery">
                            <script type="text/javascript">
                                $(document).ready(function() {
                                    $('#lightgallery-{{++$key+1}}').lightGallery();
                                });
	                                    </script>
	                            <ul id="lightgallery-{{++$key}}" class="list-unstyled row">
                            @foreach($portfolio->images() as $key => $image)
                            	@if($portfolio->featured_image == $image)
                                <li class="col-xs-6 col-sm-4 col-md-3 featured_image" data-responsive="{{ asset(config('image.portfolio_image_url').'thumbnails/medium/'.$image)}} 375, {{ asset(config('image.portfolio_image_url').'thumbnails/medium/'.$image)}} 480, {{ asset(config('image.portfolio_image_url').'thumbnails/medium/'.$image)}} 800" data-src="{{ asset(config('image.portfolio_image_url').'thumbnails/medium/'.$image)}}" data-sub-html="<h4>{{$portfolio->title}}</h4><p>{{$portfolio->description}}</p>">
                                    <img class="img-responsive" src="{{ asset(config('image.portfolio_image_url').'thumbnails/medium/'.$image)}}">
                                    <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>
                                </li>
                                @else
                                <li class="col-xs-6 col-sm-4 col-md-3 " data-responsive="{{ asset(config('image.portfolio_image_url').'thumbnails/medium/'.$image)}} 375, {{ asset(config('image.portfolio_image_url').'thumbnails/medium/'.$image)}} 480, {{ asset(config('image.portfolio_image_url').'thumbnails/medium/'.$image)}} 800" data-src="{{ asset(config('image.portfolio_image_url').'thumbnails/medium/'.$image)}}" data-sub-html="<h4>{{$portfolio->title}}</h4><p>{{$portfolio->description}}</p>">
                                    <img class="img-responsive" src="{{ asset(config('image.portfolio_image_url').'thumbnails/medium/'.$image)}}">
                                    <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>
                                </li>
                                @endif
                            @endforeach
                            </ul>
                        </div>
                    @else
                		<img class="event_img previewImg" src="{{asset('images/no-image.jpg')}}"/>
                	@endif
                
                </td>
				<td>{{ date_format(date_create($portfolio->created_at), 'd M,Y') }}</td>
				<td>
	        		<form class="form_inline" action="{{ url('admin/portfolio/'.$portfolio->id) }}" method="POST" onsubmit="deletePortfolio('{{$portfolio->id}}', '{{$portfolio->title}}', event,this)">
								{{csrf_field()}}
								{{ method_field('DELETE') }}
								<button type="submit" class="btn btn-danger btn_fixes" title="Delete"><i class="fa fa-trash-o"></i></button>
					</form>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
	</div>
	<script type="text/javascript">
		$(document).ready( function () {
		    $('#subscription_list').DataTable();
		} );
	</script>
@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/picturefill/2.3.1/picturefill.min.js"></script>
<script src="{{ asset('js/lightgallery/lightgallery-all.min.js')}}"></script>
<script src="{{ asset('js/lightgallery/lib/jquery.mousewheel.min.js') }}"></script>
<script type="text/javascript">
	$(document).ready(function(){
    	$('#lightgallery').lightGallery();
	}); 
		function deletePortfolio(id, title, event,form)
		{   

			event.preventDefault();
			swal({
				title: "Are you sure?",
				text: "You want to delete "+title,
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: "#DD6B55",
				confirmButtonText: "Yes, delete it!",
				cancelButtonText: "No, cancel pls!",
				closeOnConfirm: false,
				closeOnCancel: false,
				allowEscapeKey: false,
			},
			function(isConfirm){
				if(isConfirm) {
					$.ajax({
						url: $(form).attr('action'),
            			data: $(form).serialize(),
						type: 'DELETE',
						success: function(data) {
							data = JSON.parse(data);
							if(data['status']) {
								swal({
									title: data['message'],
									text: "Press ok to continue",
									type: "success",
									showCancelButton: false,
									confirmButtonColor: "#DD6B55",
									confirmButtonText: "Ok",
									closeOnConfirm: false,
									allowEscapeKey: false,
								},
								function(isConfirm){
									if(isConfirm) {
										window.location.reload();
									}
								});
							} else {
								swal("Error", data['message'], "error");
							}
						}
					});
				} else {
					swal("Cancelled", title+"'s record will not be deleted.", "error");
				}
			});
		}
	</script>
@endsection