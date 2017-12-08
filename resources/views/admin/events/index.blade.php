@extends('admin.layouts.adminapp')
@section('title', $pageTitle)
@section('content')
	<h2><i class="fa fa-calendar" aria-hidden="true"></i> Business Event</h2>
	<hr>
	<div class="all_content">
	@include('notification')
	<table id="subscription_list" class="display">
		<thead>
			<tr>
				<th>Business ID</th>
				<th>Business Name</th>
				<th>Event Name</th>
				<th>Event Keywords</th>
				<th>Organizer Name</th>
				<th>Address</th>
				<th>Start Date & Time</th>
				<th>End Date & Time</th>
				<th>Event Status</th>
				<th>Participants</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			@foreach($events as $event)
			<tr>
				<td><a href="{{ url('admin/business/'.$event->businessId) }}">{{ $event->event_log_id}}</a></td>
				<td>{{ $event->business_name}}</td>
				<td>{{ $event->name}}</td>
				<td>{{ $event->keywords}}</td>
				<td>{{ $event->organizer_name }}</td>
				<td>{{ $event->address }}</td>
				<td>{{ date('d M,Y h:i A', strtotime($event->start_date_time))}}</td>
				<td>{{ date('d M,Y h:i A', strtotime($event->end_date_time))}}</td>
				 @if(date('y m,d h:i A', strtotime($event->end_date_time)) > date('y m,d h:i A'))
                        <td style="color:#18dd18">
                         Active
                         @else
                         <td style="color:#D46752">
                         Expired
                         @endif
                         </td>
				<td>@if($event->total_seats!=NULL and $event->total_seats!=0){{ isset($event->getTotalNumberofParticipants) ? $event->getTotalNumberofParticipants->count() : 'Default' }}@else{{ isset($event->participations) ? $event->participations->count() : 'Default' }}@endif</td>
				<td>
					<ul class="list-inline">
						<li>
							<a href="{{ URL::to('admin/event/block/'.$event->id) }}">
			                    @if ($event->is_blocked)
			                    	<button type="button" class="btn btn-danger btn_fixes" title="UnBlock"><i class="fa fa-unlock"></i></button>
		                    	@else
		                    		<button type="button" class="btn btn-success btn_fixes" title="Block"><i class="fa fa-ban"></i></button>
	                    		@endif
			                </a>
						</li>
						<li>
							<form action="{{ url('admin/event/'.$event->id) }}" method="POST" onsubmit="deleteEvent('{{$event->id}}', '{{$event->name}}', event,this)">
								{{csrf_field()}}
								<button type="submit" class="btn btn-danger btn_fixes" title="Delete"><i class="fa fa-trash"></i></button>
							</form>
						</li>
						<li>
							<a class="btn btn-default btn_fixes" href="{{ url('admin/event/'.$event->id) }}" title="View"><i class="fa fa-eye" aria-hidden="true"></i>
</a>
						</li>
					</ul>
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
		function deleteEvent(id, name, event,form)
		{
			event.preventDefault();
			swal({
				title: "Are you sure?",
				text: "You want to delete "+name,
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
					swal("Cancelled", name+"'s record will not be deleted.", "error");
				}
			});
		}
	</script>
@endsection