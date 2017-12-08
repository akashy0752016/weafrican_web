@extends('layouts.app')
@section('title', $pageTitle)
@section('content')
<div class="container row_pad">
	<h5>Business Banner List</h5>
	<hr>
	@include('notification-modal')
    @if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
	@include('includes.side-menu')
	<div class="col-md-9 col-sm-9">
		<div class="panel panel-default table_set">
			<div class="all_content">
		      	<table id="business_list" class="display">
		      		<thead>
						<tr>
							<th>Business Category</th>
							<th>Business Subcategory</th>
							<th>Subscription Plan</th>
							<th>Banner</th>
							<th>Created On</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
					@foreach($businessBanners as $banner)
						<tr>
							<td>@if(isset($banner->category->title))
								{{ $banner->category->title }}
								@else
								No Category Selected
								@endif</td>
							<td>@if(isset($banner->subcategory->title))
								{{ $banner->subcategory->title }}
								@else
								No Sub-Category Selected
								@endif
							</td>
							<td>{{ $banner->userSubscriptionPlan->subscription->title }}</td>
							<td>@if($banner->userSubscriptionPlan->subscription->id!=6)
									<div class="profiles_images"> 
									@if($banner->is_selected==1)
										@if($banner->business->banner!="")
											<img src="{{ asset(config('image.banner_image_url').'business/thumbnails/small/'.$banner->business->banner) }}" id="1" />
										@else
											<img src="{{asset('images/no-image.jpg')}}" alt="" id="preview">
										@endif
									@elseif($banner->image!="")
										<img src="{{ asset(config('image.banner_image_url').'business/thumbnails/small/'.$banner->image) }}" id="2" />
									@else
										<img src="{{asset('images/no-image.jpg')}}" alt="" id="preview">
									@endif
									</div>
								@else
								No Banner is needed for Top/Search Plan
								@endif
							</td>
							<td>{{ date_format(date_create($banner->created_at), 'd M,Y') }}</td>
							<td>
								@php 
								$planExp = $banner->userSubscriptionPlan->expired_date;
								$planExp = date_create($planExp);
								$current = date('Y-m-d');
								$current = date_create($current);
								@endphp
								@if(date_diff($current,$planExp)->format("%R%a")>=0)
									<ul class="list-inline inline_btn">
										<li class="float_btn">
											<a class="btn btn-warning btn_fix" href="{{ url('business-banner/'.$banner->id.'/edit/') }}" title="Edit"><i class="fa fa-pencil-square-o"></i></a>
										</li>
										<li>
											<a href="{{ URL::to('business/banner/block/'.$banner->id) }}">
							                    @if ($banner->is_blocked)
							                    	<button type="button" class="btn btn-danger btn_fix" title="UnBlock"><i class="fa fa-unlock"></i></button>
						                    	@else
						                    		<button type="button" class="btn btn-success btn_fix" title="Block"><i class="fa fa-ban"></i></button>
					                    		@endif
							                </a>
										</li>
									</ul>
								@else
									<ul class="list-inline">
										<li>
											<a class="btn btn-danger btn_fix" href="#"><i class="fa fa-window-close" aria-hidden="true"></i> Banner Expired</a>
										</li>
									</ul>
								@endif
							</td>
						</tr>
					@endforeach
					</tbody>
		      	</table>
			</div>
		</div>
	</div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">

	$(document).ready( function () {
	    $('#subscription_list').DataTable();
	    $('#business_list').DataTable();
	    $('#event_list').DataTable();
	} );

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
</script>
@endsection