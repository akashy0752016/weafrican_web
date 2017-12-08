@extends('admin.layouts.adminapp')
@section('title', $pageTitle)
@section('content')
	<h2><i class="fa fa-comment" aria-hidden="true"></i> App Feedbacks</h2>
	<hr>
	@include('notification')
	<table id="subscription_list" class="display">
		<thead>
			<tr>
				<th>Full Name</th>
				<th>Mobile Number</th>
				<th>Feedbacks</th>
				<th>Created On</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			@foreach($feedbacks as $feedback)
			<tr>
				<td>{{ $feedback->first_name }} @if($feedback->middle_name!="")
				{{$feedback->middle_name}} 
				@endif 
				{{$feedback->last_name}}</td>
				<td>{{ '+' . $feedback->country_code . '-' . $feedback->mobile_number }}</td>
				<td>{{ $feedback->feedback}}</td>
				<td>{{ date_format(date_create($feedback->created_at), 'd M,Y') }}</td>
				<td>
					<ul class="list-inline">
						<li>
							<a href="{{ URL::to('admin/app-feedback/block/'.$feedback->id) }}">
			                    @if ($feedback->is_blocked)
			                    	<button type="button" class="btn btn-danger" title="UnBlock"><i class="fa fa-unlock"></i></button>
		                    	@else
		                    		<button type="button" class="btn btn-success" title="Block"><i class="fa fa-ban"></i></button>
	                    		@endif
			                </a>
						</li>
						<li>
							<form action="{{ url('admin/app-feedback/'.$feedback->id) }}" method="POST" onsubmit="deleteFeedback('{{$feedback->id}}', '{{$feedback->full_name}}', event,this)">
								{{csrf_field()}}
								{{ method_field('DELETE') }}
								<button type="submit" class="btn btn-danger" title="Delete"><i class="fa fa-trash-o"></i></button>
							</form>
						</li>
					</ul>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
	<script type="text/javascript">
		$(document).ready( function () {
		    $('#subscription_list').DataTable();
		} );
	</script>
@endsection
@section('scripts')
	<script type="text/javascript">
		function deleteFeedback(id, title, event,form)
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