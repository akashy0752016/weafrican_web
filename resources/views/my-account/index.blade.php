@extends('layouts.app')
@section('title', $pageTitle)
@section('content')
<div class="container row_pad">
	<h5>My Account</h5>
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
	        <h5>Transaction History</h5>
	        <div class="panel panel-default table_set">
	            <div class="all_content ">
	                <ul class="nav nav-tabs tab_align">
	                    <li class="active"><a data-toggle="tab" href="#subscription" aria-expanded="true">Subscription Buyed History</a></li>
	                    <li class=""><a data-toggle="tab" href="#event" aria-expanded="false">Ticket Booked History</a></li>
	                </ul>
	                <div class="tab-content">
	                    <div id="event" class="tab-pane fade in">
	                        <div class="all_content">
	                            <table class="table cell-border" id="booking_history" width="100%">
	                                <thead>
	                                    <tr>
	                                        <th>Event Name</th>
	                                        <th>Total Tickets</th>
	                                        <th>Tickets Per Plan</th>
	                                        <th>Amount</th>
	                                        <th>Reference ID</th>
	                                        <th>Purchased Date</th>
	                                        <th>Status</th>
	                                    </tr>
	                                </thead>
	                                <tbody>
	                                    @foreach($eventTransaction as $value)
	                                    <tr>
	                                        <td>{{$value->event->name}}</td>
	                                        <td>{{$value->total_seats_buyed}}</td>
	                                        <td>
	                                        @foreach($value->soldEventTickets as $value1)
	                                        {{$value1->businessEventSeats->seating_plan_alias}}: {{$value1->total_tickets_buyed}}<br>
	                                        @endforeach
	                                        </td>
	                                        <td>{{$value->amount}}</td>
	                                        <td>{{$value->reference_id}}</td>
	                                        <td>{{date_format(date_create($value->transaction_date), 'd-m-Y h:i a')}}</td>
	                                        @if($value->status=="success")<td style="color:#18dd18">
	                                        @else
	                                        <td>
	                                        @endif {{ucfirst($value->status)}}</td>
	                                    </tr>
	                                   @endforeach
	                                </tbody>
	                            </table>
	                        </div>
	                    </div>
	                    <div id="subscription" class="tab-pane fade active in">
	                        <div class="all_content table-responsive">
	                            <table class="table cell-border" id="tranaction_history">
	                                <thead>
	                                    <tr>
	                                        <th>Subscription Plan Name</th>
	                                        <th>Amount</th>
	                                        <th>Reference ID</th>
	                                        <th>Purchased Date</th>
	                                        <th>Status</th>
	                                        <th>Expired Date</th>
	                                    </tr>
	                                </thead>
	                                <tbody>
	                                   @foreach($userSubscription as $value)
	                                    <tr>
	                                        <td>{{$value->subscription->title}}</td>
	                                        <td>{{$value->user_amount.' '.$value->user_currency}}</td>
	                                        <td>{{$value->reference_id}}</td>
	                                        <td>{{$value->transaction_date}}</td>
	                                        @if($value->status=="success")<td style="color:#18dd18">
	                                        @else
	                                        <td>
	                                        @endif {{ucfirst($value->status)}}</td>
	                                        <td>{{$value->expired_date}}</td>
	                                    </tr>
	                                   @endforeach
	                                </tbody>
	                            </table>
	                        </div>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">

    $(document).ready( function () {
        $('#tranaction_history').DataTable();
        $('#booking_history').DataTable();
        $('#event_list').DataTable();
    } );
</script>
@endsection