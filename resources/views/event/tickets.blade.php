@extends('layouts.event-app')

@section('content')
<h2>Event Tickets</h2>
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

<div class="content">

    <div>
        <div class="form-group">
            <p>Event Title : {{ $event->name }}</p>
            <div class="col-md-6 col-xs-12 col-sm-6">Total Seats : {{ $event->total_seats }}</div>
            <div class="col-md-6 col-xs-12 col-sm-6">Total Booked Tickets : {{ $tickets->count() }}</div>
        </div>

        <div class="search">
            <form id="form" class="form-horizontal" action="{{ url('event/search-ticket') }}" method="GET">
            {{csrf_field()}}
                <div class="form-group">
                    <label class="col-md-2 label_left">Enter Booking ID :</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="search" id="search" oninvalid="setCustomValidity('Please enter correct Booking ID.')" required>
                    </div>
                     <input type="submit" value="SEARCH" class="btn btn-warning">
                </div>
            </form>
        </div>

    </div>

    <div class="ticket-table">
        <p id="message"></p>
        @if($tickets->count() > 0)
        <form id="ticket">
        <table  class="ui celled table" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>S No.</th>
                    <th>Checked</th>
                    <th>Primary Booking ID</th>
                    <th>Sub Booking ID</th>
                    <th>User Name</th>
                    <th>Ticket Status</th>
                </tr>
            </thead>
            <tfoot class="table-search">
                <tr>
                    <th></th>
                    <th></th>
                    <th>Primary Booking ID</th>
                    <th>Sub Booking ID</th>
                    <th>User Name</th>
                    <th>Ticket Status</th>
                </tr>
            </tfoot>
            <tbody>
                @if($tickets)
                    @foreach($tickets as $key => $ticket)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>
                                <input name="chkbox[]" value="{{ $ticket->id }}" type="checkbox" class="chkbox" {{$ticket->attended_status  ? 'checked' : ''}} {{ $ticket->attended_status  ? 'disabled' : ''}}>
                            </td>
                            <td>{{ $ticket->primary_booking_id }}</td>
                            <td>{{ $ticket->sub_booking_id }}</td>
                            <td>{{ $ticket->user->first_name.' '.$ticket->user->middle_name.' '.$ticket->last_name}} </td>
                            <td>{{ $ticket->attended_status ? 'Booked' : 'Unbooked'}}</td>
                        </tr>
                    @endforeach
                @endif
            </tbody> 
        </table>
        </form>
        @endif
     </div>

    <div class="links">
        <a href="{{ url('event/search')}}"><button class="btn btn-info">RESET</button></a>
        <button class="btn btn-success" onclick="javascript:confirmTicket();">CONFIRM</button>
    </div>
   
</div>
@endsection

@section('scripts')
<script src="//code.jquery.com/jquery-1.12.4.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js" type="text/javascript"></script>

<script type="text/javascript">
    $(document).ready(function(){
        $('.table').DataTable({
            responsive: true
        });
        $('.table').css("width","100%");

        // Setup - add a text input to each footer cell
        $('.table tfoot th').each( function () {
            var title = $(this).text();
            if(title)
                $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
        } );
     
        // DataTable
        var table = $('.table').DataTable();
     
        // Apply the search
        table.columns().every( function () {
            var that = this;
     
            $( 'input', this.footer()).on( 'keyup change', function () {
                if ( that.search() !== this.value ) {
                    that
                        .search( this.value )
                        .draw();
                }
            } );
        } );

    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function confirmTicket()
    {
        var data = $("#ticket").serialize();
        
        var dataString = 'ticketId='+ data;
        $.ajax({
            url: "{{url('event/confirm-ticket')}}",
            data: data,
            type: "POST",
            async: false,
            success: function(response) {
                var data = JSON.parse(JSON.stringify(response));

                if(data['status'] == 'success') {
                    $('html, body').animate({
                        scrollTop: 0}, 300);
                    $("#message").html('<div class="alert alert-info fade in"> <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a> '+ data['text']+'</div>');

                    setTimeout(function(){
                        document.getElementById("message").innerHTML = '';
                    }, 3000);
                }
            }
        })
    }

</script>
@endsection
