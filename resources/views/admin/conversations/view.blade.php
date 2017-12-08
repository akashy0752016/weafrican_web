@extends('admin.layouts.adminapp')
@section('title', $pageTitle)
@section('content')
	<h2><i class="fa fa-users" aria-hidden="true"></i> View Users Conversations</h2>
	<hr>
	<table id="subscription_list" class="display">
		<thead>
			<tr>
				<th>S.No</th>
				<th>Sender Name</th>
				<th>Receiver Name</th>
				<th>Message</th>
				<th>Date</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
		@if($conversations->count())
			@foreach($conversations as $key => $conversation)
			<tr>
				<td>{{ ++$key }}</td>
				<td>{{ $conversation->sender->first_name}}</td>
				<td>{{ $conversation->receiver->first_name}}
				<td>{{ substr($conversation->message,0,25)}}</td>
				<td>{{ date_format(date_create($conversation->created_at), 'd M,Y')}} </td>
				<td>
					<ul class="list-inline">
						<li>
			                <button type="button" class="btn btn-default btn_fixes" title="View Message" onclick="javascript:message('{{ $conversation->id }}')"><i class="fa fa-envelope" aria-hidden="true"></i>
							</button>
						</li>
					</ul>
				</td>
			</tr>
			@endforeach
		@endif
		</tbody>
	</table>
	<!-- Modal -->
	<div id="myModal" class="modal fade" role="dialog">
	  	<div class="modal-dialog">
	    <!-- Modal content-->
		    <div class="modal-content">
		      	<div class="modal-header">
		        	<button type="button" class="close" data-dismiss="modal">&times;</button>
		        	<h4 class="modal-title">Message:</h4>
		      	</div>
		      	<div class="modal-body modal_popup">
		        	<p></p>
		      	</div>
		      	<div class="modal-footer modal_foter">
		        	<button type="button" class="btn btn-default admin_btn" data-dismiss="modal">Close</button>
		      	</div>
		    </div>
	  	</div>
	</div>
	<script type="text/javascript">
		$(document).ready( function () {
		    $('#subscription_list').DataTable();
		} );
	</script>
@endsection
@section('scripts')
	<script type="text/javascript">
		function message(id)
		{
		    $.ajax({
		        url: "{{url('admin/get/message')}}" + '/' + id,
		        type: "GET",
		        async: false,
		        success: function(response) {
		            if(response['status'] == 'success') {
		                $('.modal-body').text(response['response']['message']);
		                $('#myModal').modal('show');
		            }
		        }
		    })
		}
	</script>
@endsection