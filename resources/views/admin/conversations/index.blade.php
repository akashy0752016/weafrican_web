@extends('admin.layouts.adminapp')
@section('title', $pageTitle)
@section('content')
	<h2><i class="fa fa-users" aria-hidden="true"></i> User Conversations</h2>
	<hr>
	<div class="all_content">
	@include('notification')
	<table id="subscription_list" class="display">
		<thead>
			<tr>
				<th>S.No</th>
				<th>Conversation Between</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
		@if(isset($users))
		@foreach($users as $key => $user)
			<tr>
				<td>{{ ++$key }}</td>
				<td>@if(isset($user->sender)){{ $user->sender->first_name }}@endif - @if(isset($user->receiver)){{ $user->receiver->first_name }}@endif</td>
				<td>
					<ul class="list-inline">
						<li>
							<a href="{{ URL::to('admin/get/conversations/'.$user->sender_id.'/'.$user->receiver_id) }}">
			                    <button type="button" class="btn btn-default btn_fixes" title="View Conversation"><i class="fa fa-eye"></i></button>
			                </a>
						</li>
					</ul>
				</td>
			</tr>
		@endforeach
		@endif
		</tbody>
	</table>
	</div>
@endsection
@section('scripts')
	<script type="text/javascript">
		$(document).ready( function () {
		    $('#subscription_list').DataTable();
		} );
	</script>
@endsection