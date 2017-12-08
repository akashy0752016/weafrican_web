@extends('layouts.app')
@section('title', $pageTitle)
@section('content')
<div class="container row_pad">
	<h5>Premium Plan Details</h5>
	<hr>
	@include('notification')
    @if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <div class="wrap_container">
	@include('includes.side-menu')
	<div class="col-md-9 col-sm-9">
		<div class="panel panel-default table_set">
			<div class="all_content">
		      	<table id="premium_list" class="display">
		      		<thead>
						<tr>
							<th>Plan Name</th>
							<th>Status</th>
							<th>Start Date</th>
							<th>Period End</th>
							<th>Options</th>
						</tr>
					</thead>
					<tbody>
						@foreach($plans as $plan)
						<tr>
							<td>{{ $plan->subscription->title }} (&#8358; {{$plan->amount}}/month)</td>
                            @if(($plan->is_auto_renew == 0 && $plan->is_expired == 1) || ($plan->is_auto_renew == 1 && $plan->is_expired == 1))
	                        <td style="color:#D46752">
                                Inactive
                            @else
                            <td style="color:#18dd18">
                                Active
	                        @endif </td>
							<td>{{ date_format(date_create($plan->transaction_date), 'd M ,Y h:i a') }}</td>
							<td>{{ date_format(date_create($plan->expired_date), 'd M ,Y') }}</td>
							<td>
							@if($plan->is_auto_renew)
								<form action="{{url('deactivated-plan/'.$plan->id)}}" method="POST" onsubmit="deactivateAutoRenew('{{$plan->id}}', '{{$plan->subscription->title}}', event,this)">
                                    {{csrf_field()}}
                                    <button type="submit" class="btn btn-danger btn_fix" title="Cancel premium plan ">Cancel*</button>
                                </form>
                            @else
                            	<form action="{{url('deactivated-plan/'.$plan->id)}}" method="POST" onsubmit="activateAutoRenew('{{$plan->id}}', '{{$plan->subscription->title}}', event,this)">
                                    {{csrf_field()}}
                                    <button type="submit" class="btn btn-success btn_fix" title="Activate premium plan">Activate</button>
                                </form>
                            @endif
                            </td>
						</tr>
						@endforeach
					</tbody>
		      	</table>
                <p> <strong>*This subscription will be auto renew at the end of the period until this plan is cancel.</strong></p>
                <p><strong> * After cancellation,your subscription will continue until the period ends.</strong></p>
			</div>
		</div>
	</div>
</div>

     <!-- Premium Plan Modal -->
  <div class="modal fade" id="premiumPlan" role="dialog">
    <div class="modal-dialog modal-sm premium-popup">
      <div class="modal-content">
        <div class="modal-header">Message:</div>
        <div class="modal-body">
          <p>You already have an active premium membership plan.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default btn_colr" data-dismiss="modal">Ok</button>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">

	$(document).ready( function () {
	    $('#premium_list').DataTable();

        $login = '{{Auth::check()}}';

            if($login) {
                $value = '{{Session::has("premiumPlan")}}';
                if ($value) {
                    $('.notifications').hide();
                    $('#premiumPlan').modal('show');
                    $value = '{{Session::forget("premiumPlan")}}';
                }
            }
	});

	function deactivateAutoRenew(id, title, event,form)
    {   
        event.preventDefault();
        swal({
            title: "Are you sure?",
            text: "You want to cancel "+title+" Plan",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, cancel it!",
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
                    type: 'POST',
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
                swal("Cancelled", title+"'s  Plan will not be cancel.Please try again", "error");
            }
        });
    }

    function activateAutoRenew(id, title, event,form)
    {   
        event.preventDefault();
        swal({
            title: "Are you sure?",
            text: "You want to activate "+title+" Plan",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, activate it!",
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
                    type: 'POST',
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
                swal("Cancelled", title+"'s  Plan will not be activated. Please try again.", "error");
            }
        });
    }

</script>
@endsection