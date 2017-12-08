@extends('layouts.app')
@section('title', $pageTitle)
@section('content')
<div class="container row_pad">
    <h5 class="text-left">Event Details</h5>
    <hr>
    <div class="wrap_addevent">
    <p class="text-left">You can add multiple events.</p> 
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
    <p class="right_btn"><a href="{{url('business-event/create')}}"><button type="button" class="btn btn-info"><i class="fa fa-plus" aria-hidden="true"></i> Add Event</button></a>
    @if(Auth::user()->event_password)
    <a href="{{url('change/event-password')}}"><button type="button" class="btn btn-info"><i class="fa fa-cog" aria-hidden="true"></i>Change Event Password</button></a>
    @endif</p>
    </div>
    <div class="panel panel-default tab_wide table_set ">
        <table class="table">
            <thead>
                <tr>
                    <th>Event Id</th>
                    <th>Event Name</th>
                    <!-- <th>Event Keywords</th> -->
                    <th>Orgainzer Name</th>
                    <th>Event Start Date</th>
                    <th>Event End Date</th>
                    <th>Event Status</th>
                    <!-- <th>Address</th> -->
                    <th>Event Banner</th>
                    <!-- <th>Participants</th> -->
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @if($events->count()) 
                @foreach($events as $event)
                    <tr>
                        <td>{{$event->event_log_id}}</td>
                        <td>{{$event->name}}</td>
                        <!-- <td>{{$event->keywords}}</td> -->
                        <td>{{$event->organizer_name}}</td>
                        <td>{{ date('d M,Y h:i A', strtotime($event->start_date_time))}}</td>
                        <td>{{ date('d M,Y h:i A', strtotime($event->end_date_time))}}</td>
                       
                        @if($event->end_date_time > date('Y-m-d h:i:s'))
                        <td style="color:#18dd18">
                         Active
                         @else
                         <td style="color:#D46752">
                         Expired
                         @endif
                         </td>
                        <!-- <td>{{$event->address}}</td> -->
                        <td> @if($event->banner)<img  class="event_img" src="{{asset(config('image.banner_image_url').'event/thumbnails/small/'.$event->banner)}}"/>
                        @else Banner not uploded yet @endif</td>
                        <!-- <td> {{ isset($event->participations) ? $event->participations->count() : 'Default' }}</td> -->
                        <td>
                            <ul class="list-inline">
                                <li>
                                    <button type="button" class="btn btn-info btn_fix" data-toggle="modal" data-target="#myModal-{{$event->id}}" title="Download Participant List"><i class="fa fa-download" aria-hidden="true"></i></button>
                                  <!-- Modal -->
                                    <div class="modal fade" id="myModal-{{$event->id}}" role="dialog">
                                    <div class="modal-dialog modal-lg body_container">

                                      <!-- Modal content-->
                                      <div class="modal-content upld_popup">
                                        <div class="modal-header">
                                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                                          <h6 class="modal-title">Choose data to show in csv</h6>
                                        </div>
                                        <form class="form-horizontal" id="download_form{{$event->id}}" action="{{ url('event/participants/download-csv/'.$event->id) }}" method="POST">
                                        <div class="modal-body csv_box" style="width: 100%">
                                         <p class="text_bold">Please Select atleast one checkbox to continue</p>
                                            {{csrf_field()}}
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-xs-6">
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" name="fields[]" value="first_name" id="check" /> First Name
                                                            </label>
                                                        </div>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" name="fields[]" value="middle_name" id="check" /> Middle Name
                                                            </label>
                                                        </div>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" name="fields[]" value="last_name" id="check" /> Last Name
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <div class="col-xs-6">
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" name="fields[]" value="mobile_number" id="check" /> Mobile Number
                                                            </label>
                                                        </div>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" name="fields[]" value="country_code" id="check" /> Country Code
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- The container to place the error of checkboxes -->
                                                <div id="alertDayMessage"></div>
                                            </div>
                                            
                                            <div class="col-md-12">
                                            <div class="row">
                                            <div class="form-group form-inline col-md-6">
                                                <label>Index</label>
                                                    <input type="number" class="form-control " name="index" value="0" required="required" min="0">
                                            </div>
                                            <div class="form-group form-inline col-md-6">
                                                <label>Limit</label>
                                                    <input type="number" class="form-control " name="limit" required="required" min="10">
                                            </div>
                                            </div>
                                            </div>
                                        
                                        </div>
                                        <div class="modal-footer">
                                         <button class="btn btn-success" type="submit">Download</button>
                                          <button type="button " class="btn btn-default btn-danger" data-dismiss="modal" id="cancel">Cancel</button>
                                        </div>
                                        </form>
                                        <script type="text/javascript">
                                        //Bootstarp validation on form
                                        $(document).ready(function() {
                                            $('#download_form{{$event->id}}').bootstrapValidator({
                                                feedbackIcons: {
                                                    valid: 'glyphicon glyphicon-ok',
                                                    invalid: 'glyphicon glyphicon-remove',
                                                    validating: 'glyphicon glyphicon-refresh'
                                                },
                                                fields: {
                                                    index: {
                                                        // The group will be set as default (.form-group)
                                                        validators: {
                                                            notEmpty: {
                                                                message: 'The index is required'
                                                            }
                                                        }
                                                    },
                                                    limit: {
                                                        // The group will be set as default (.form-group)
                                                        validators: {
                                                            notEmpty: {
                                                                message: 'The limit is required'
                                                            }
                                                        }
                                                    },
                                                    "fields[]": {
                                                        validators: {
                                                            choice: {
                                                                min: 1,
                                                                message: 'Please choose 2 - 4 programming languages you are good at'
                                                            }
                                                        }
                                                    }
                                                }
                                            });
                                            $('#cancel').click(function() {
                                                document.getElementById('download_form{{$event->id}}').reset();
                                                $('#download_form{{$event->id}}').bootstrapValidator('resetForm', true); 
                                            });
                                        });
                                        </script>
                                      </div>
                                    </div>
                                    </div>
                                </li>
                                <li>
                                    <a href="{{url('business-event/'.$event->id.'/edit')}}"><button type="button" class="btn btn-default btn_fix" title="Edit Event"><i class="fa fa-pencil-square-o" aria-hidden="true" ></i></button></a>
                                </li>
                                <li>
                                    <a href="{{url('business-event/'.$event->id)}}"><button type="button" class="btn btn-success btn_fix" title="View Event"><i class="fa fa-eye" aria-hidden="true"></i></button></a>
                                </li>
                                <li>@if($event->end_date_time > date('Y-m-d h:i:s'))
                                    @else
                                    <form action="{{url('business-event/'.$event->id)}}" method="POST" onsubmit="deleteEvent('{{$event->id}}', '{{$event->name}}', event,this)">
                                        {{csrf_field()}}
                                        <button type="submit" class="btn btn-danger btn_fix" title="Delete Event"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                                    </form>
                                    @endif
                                </li>
                            </ul>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td>No events found</td>
                </tr>
            @endif    
            </tbody>
        </table>
    </div>
    {{ $events->links() }}
</div>
@endsection
@section('header-scripts')
<script src='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-validator/0.4.5/js/bootstrapvalidator.min.js'></script>
<style type="text/css">
    .has-feedback label~.form-control-feedback{top:0px !important;right: 65px;}
</style>
@endsection
@section('scripts')

<script type="text/javascript">
    
    function deleteEvent(id, title, event,form)
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