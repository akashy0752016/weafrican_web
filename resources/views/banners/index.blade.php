@extends('layouts.app')
@section('title', $pageTitle)
@section('content')
<div class="container row_pad">
	<h5>Banners</h5>
	<hr>
	@include('notification')
	<ul class="nav nav-tabs ul_botm">
		<li class="active"><a data-toggle="tab" href="#home">Home Banners</a></li>
		<li><a data-toggle="tab" href="#menu1">Business Banners</a></li>
		<li><a data-toggle="tab" href="#menu2">Event Banners</a></li>
	</ul>
  	<div class="tab-content">
    	<div id="home" class="tab-pane fade in active">
    	<div class="panel panel-default table_set">
    		<div class="all_content">
		      	<table id="subscription_list" class="display">
					<thead>
						<tr>
							<th>Business ID</th>
							<th>Business name</th>
							<th>Subscription Plan</th>
							<th>Banner</th>
							<th>Created On</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
					@foreach($homeBanners as $banner)
						<tr>
							<td>{{ $banner->business->business_id}}</td>
							<td>{{ $banner->business->title}}</td>
							<td>{{ $banner->subscription->title}}</td>
							<td><img src="{{ asset(config('image.banner_image_url').'business/thumbnails/small/'.$banner->image) }}"/></td>
							<td>{{ date_format(date_create($banner->created_at), 'd M,Y') }}</td>
							<td>
								<ul class="list-inline">
									<!-- <li>
										<a class="btn btn-warning" href="{{ url('admin/banner/'.$banner->id.'/edit/') }}" title="Edit"><i class="fa fa-pencil-square-o"></i></a>
									</li> -->
									<li>
										<a href="{{ URL::to('home/banner/block/'.$banner->id) }}">
						                    @if ($banner->is_blocked)
						                    	<button type="button" class="btn btn-danger" title="UnBlock"><i class="fa fa-unlock"></i></button>
					                    	@else
					                    		<button type="button" class="btn btn-success" title="Block"><i class="fa fa-ban"></i></button>
				                    		@endif
						                </a>
									</li>
									<li>
										<form action="{{ url('banner/'.$banner->id) }}" method="POST" onsubmit="deleteHomeBanner('{{$banner->id}}', '{{$banner->subscription->title}}', event,this)">
											{{csrf_field()}}
											<button type="submit" class="btn btn-danger" title="Delete"><i class="fa fa-trash"></i></button>
										</form>
									</li>
								</ul>
							</td>
						</tr>
					@endforeach
					</tbody>
				</table>
				</div>
			</div>
    	</div>
	    <div id="menu1" class="tab-pane fade">
	    <div class="panel panel-default table_set">
	    	<div class="all_content">
	      	<table id="business_list" class="display">
				<thead>
					<tr>
						<th>Business ID</th>
						<th>Business name</th>
						<th>Subscription Plan</th>
						<th>Banner</th>
						<th>Created On</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
				@foreach($businessBanners as $banner)
					<tr>
						<td>{{ $banner->business->business_id}}</td>
						<td>{{ $banner->business->title}}</td>
						<td>{{ $banner->subscription->title}}</td>
						<td><img src="{{ asset(config('image.banner_image_url').'business/thumbnails/small/'.$banner->image) }}"/></td>
						<td>{{ date_format(date_create($banner->created_at), 'd M,Y') }}</td>
						<td>
							<ul class="list-inline">
								<!-- <li>
									<a class="btn btn-warning" href="{{ url('admin/banner/'.$banner->id.'/edit/') }}" title="Edit"><i class="fa fa-pencil-square-o"></i></a>
								</li> -->
								<li>
									<a href="{{ URL::to('business/banner/block/'.$banner->id) }}">
					                    @if ($banner->is_blocked)
					                    	<button type="button" class="btn btn-danger" title="UnBlock"><i class="fa fa-unlock"></i></button>
				                    	@else
				                    		<button type="button" class="btn btn-success" title="Block"><i class="fa fa-ban"></i></button>
			                    		@endif
					                </a>
								</li>
								<li>
									<form action="{{ url('business/banner/'.$banner->id) }}" method="POST" onsubmit="deleteBusinessBanner('{{$banner->id}}', '{{$banner->subscription->title}}', event,this)">
										{{csrf_field()}}
										<button type="submit" class="btn btn-danger" title="Delete"><i class="fa fa-trash"></i></button>
									</form>
								</li>
							</ul>
						</td>
					</tr>
				@endforeach
				</tbody>
			</table>
			</div>
			</div>
	    </div>
	    <div id="menu2" class="tab-pane fade">
	    <div class="panel panel-default table_set">
	    <div class="all_content">
			<table id="event_list" class="display">
				<thead>
					<tr>
						<th>Business ID</th>
						<th>Business Name</th>
						<th>Subscription Plan</th>
						<th>Banner</th>
						<th>Created On</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
				@foreach($eventBanners as $banner)
					<tr>
						<td>{{ $banner->business->business_id}}</td>
						<td>{{ $banner->business->title}}</td>
						<td>{{ $banner->subscription->title}}</td>
						<td><img src="{{ asset(config('image.banner_image_url').'event/thumbnails/small/'.$banner->image) }}"/></td>
						<td>{{ date_format(date_create($banner->created_at), 'd M,Y') }}</td>
						<td>
							<ul class="list-inline">
								<!-- <li>
									<a class="btn btn-warning" href="{{ url('admin/banner/'.$banner->id.'/edit/') }}" title="Edit"><i class="fa fa-pencil-square-o"></i></a>
								</li> -->
								<li>
									<a href="{{ URL::to('event/banner/block/'.$banner->id) }}">
					                    @if ($banner->is_blocked)
					                    	<button type="button" class="btn btn-danger" title="UnBlock"><i class="fa fa-unlock"></i></button>
				                    	@else
				                    		<button type="button" class="btn btn-success" title="Block"><i class="fa fa-ban"></i></button>
			                    		@endif
					                </a>
								</li>
								<li>
									<form action="{{ url('event/banner/'.$banner->id) }}" method="POST" onsubmit="deleteEventBanner('{{$banner->id}}', '{{$banner->subscription->title}}', event,this)">
										{{csrf_field()}}
										<button type="submit" class="btn btn-danger" title="Delete"><i class="fa fa-trash"></i></button>
									</form>
								</li>
							</ul>
						</td>
					</tr>
				@endforeach
				</tbody>
			</table>
			</div>
			</div>
	    </div>
	</div>
</div>
<style type="text/css">
	#event_list,#business_list{width: 100%!important;}
</style>
@endsection
@section('scripts')
	<script type="text/javascript">

		$(document).ready( function () {
		    $('#subscription_list').DataTable();
		    $('#business_list').DataTable();
		    $('#event_list').DataTable();
		} );

		function deleteHomeBanner(id, title, event, form)
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

		function deleteBusinessBanner(id, title, event,form)
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

		function deleteEventBanner(id, title, event,form)
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