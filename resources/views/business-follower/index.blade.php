@extends('layouts.app')
@section('title', $pageTitle)
@section('content')
<div class="container row_pad">
    <h5 class="text-left">Business Follower List</h5>
    <hr>
    <p class="text-left">You can see list of users who had liked, disliked or followed your business.</p> 
    <ul class="nav nav-tabs tab_align">
        <li class="active"><a data-toggle="tab" href="#home">Business Follower List</a></li>
        <li><a data-toggle="tab" href="#like">Business Like List</a></li>
        <li><a data-toggle="tab" href="#dislike">Business Dislike List</a></li>
        <li><a data-toggle="tab" href="#rating">Business Rating List</a></li>
    </ul>
    <div class="tab-content">
        <div id="home" class="tab-pane fade in active ">
            <div class="all_content">
                <div class="col-md-12" style="margin-bottom: 10px">
                <div class="row">
                    <div class="col-md-6"><p id="response" style="color: green"></p></div>
                    <div class="col-md-6 text-right"><div class="row">
                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#fcm_notification" @if(count($followers) == 0) disabled @endif >Send Message</button></div></div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="panel panel-default table_set">
                <div class="all_content">
                    <table class="table" id="follower">
                        <thead>
                            <tr>
                                <th>User Name </th>
                                <th>Email</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($followers) and count($followers)>0)
                                @foreach($followers as $follower)
                                    <tr>
                                        <td>@if(isset($follower->user)) {{ $follower->user->first_name }} @endif</td>
                                        <td>@if(isset($follower->user)) {{ $follower->user->email }} @endif</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td>No data found !</td>
                                    <td></td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
        <div id="like" class="tab-pane fade in">
            <div class="all_content">
            <div class="panel panel-default table_set">
                <div class="all_content">
                <table class="table" id="likes">
                    <thead>
                        <tr>
                            <th>User Name</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($likes)>0)
                            @foreach($likes as $like)
                                <tr>
                                    <td>{{ $like->user->first_name }}</td>
                                    <td>{{ $like->user->email }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td>No data found !</td>
                                <td></td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                </div>
                </div>
            </div>
        </div>
        <div id="dislike" class="tab-pane fade in">
            <div class="all_content">
            <div class="panel panel-default table_set">
            <div class="all_content">
                <table class="table" id="dislikes">
                    <thead>
                        <tr>
                            <th>User Name</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($dislikes)>0)
                            @foreach($dislikes as $dislike)
                                <tr>
                                    <td>{{ $dislike->user->first_name }}</td>
                                    <td>{{ $dislike->user->email }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td>No data found !</td>
                                <td></td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                </div>
                </div>
            </div>
        </div>
        <div id="rating" class="tab-pane fade in">
            <div class="all_content">
                <div class="panel panel-default table_set">
                <div class="all_content">
                    <table class="table" id="ratings">
                        <thead>
                            <tr>
                                <th>User Name</th>
                                <th>Email</th>
                                <th>Rating</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($ratings)>0)
                                @foreach($ratings as $rating)
                                    <tr>
                                        <td>{{ $rating->user->first_name }}</td>
                                        <td>{{ $rating->user->email }}</td>
                                        <td>{{ $rating->rating }}/5</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td>No data found !</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    </div>
                    <div>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>
<!-- Modal -->
<div id="fcm_notification" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Send Messsage to all followers</h4>
      </div>
      <div class="modal-body mesg_container">
        <textarea name="message" id="message" class="form-control" rows="5" style="resize:none;" placeholder="Enter your message" maxlength="160"></textarea>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" id="send_message" data-dismiss="modal">Submit</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
      </div>
    </div>

  </div>
</div>
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
    $( "#send_message" ).click(function() {
        if($("#message").val()=="" || $("#message").val()==null)
        {
            alert("Please enter the message");
        }else
        {
            $.ajax({
                type: "POST",
                url: '{{ url("send_message") }}',
                data: {
                    _token: "{{ csrf_token() }}",
                    business_id : {{ $business->id }},
                    message : '{{$business->title}} send a message: ' + $("#message").val(),
                    source : "business"
                },success:function(response){
                    $("#response").html(response).show('slow');
                    setTimeout(function() { $("#response").hide('slow'); }, 10000);
                }
            });
            $("#message").val("");
        }
    });
    $(document).ready(function(){
        $('.table').DataTable({
            responsive: true
        });
        $('.table').css("width","100%");
        $('.table').addClass("table-striped");
    });
</script>
@endsection