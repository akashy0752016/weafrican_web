@extends('admin.layouts.adminapp')
@section('title', $pageTitle)
@section('content')
	<h2><i class="fa fa-building" aria-hidden="true"></i> Services</h2>
	<hr>
	<div class="all_content">
	@include('notification')
	<table id="subscription_list" class="display">
		<thead>
			<tr>
				<th title="Serial Number">#</th>
				<th>Business ID</th>
				<th>Business Name</th>
				<th>Service Name</th>
				<th>Description</th>
				<th>Created On</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			@foreach($services as $key => $service)
			<tr>
				<td>{{ ++$key }}</td>
				<td><a href="{{ url('admin/business/'.$service->businessId) }}">{{ $service->business_id}}</a></td>
				<td>{{ $service->business_name}}</td>
				<td>{{ $service->title}}</td>
				<td>{{ $service->description}}</td>
				<td>{{ date_format(date_create($service->created_at), 'd M,Y') }}</td>
				<td>
					<a href="{{ URL::to('admin/service/block/'.$service->id) }}">
	                    @if($service->is_blocked)
	                    	<button type="button" class="btn btn-danger btn_fixes" title="Unblock"><i class="fa fa-unlock"></i></button>
	                	@else
	                		<button type="button" class="btn btn-success btn_fixes" title="Block"><i class="fa fa-ban"></i></button>
	            		@endif
	        		</a>
	        		<form class="form_inline" action="{{ url('admin/service/'.$service->id) }}" method="POST" onsubmit="deleteService('{{$service->id}}', '{{$service->title}}', event,this)">
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
	<script type="text/javascript">
		function deleteService(id, title, event,form)
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