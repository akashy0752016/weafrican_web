@extends('layouts.app')
@section('title', $pageTitle)
@section('content')
<div class="container row_pad">
    <h5 class="text-left">Business Following List</h5>
    <hr>
    <p class="text-left">This is the list of the businesses / people you are following.</p>
    <p id="message"></p> 
    <ul class="nav nav-tabs tab_align">
        <li class="active"><a data-toggle="tab" href="#home">Business Followering List</a></li>
    </ul>
    <div class="tab-content">
        <div id="home" class="tab-pane fade in active ">
            <div class="all_content">
                <div class="clearfix"></div>
                <div class="panel panel-default table_set">
                <div class="all_content">
                 <form id="unfollow">
                    <table class="table" id="follower">
                        <thead>
                            <tr>
                                <th>S No.</th>
                                <th>Unfolllow</th>
                                <th>Business Name</th>
                                <th>User Name </th>
                                <th>Email</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($followers) and count($followers)>0)
                                @foreach($followers as $key => $follower)
                                    <tr>
                                        <td>{{ ++$key }}</td>
                                        <td> <input name="chkbox[]" value="{{ $follower->id }}" type="checkbox" class="chkbox"></td>
                                        <td>{{ $follower->business->title }}</td>
                                        <td>{{ $follower->business->user->first_name }}</td>
                                        <td>{{ $follower->business->user->email }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td>No data found !</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>
    @if(isset($followers) and count($followers)>0)
        <div class="links">
            <a href="{{ url('business-following')}}"><button class="btn btn-info">RESET</button></a>
            <button class="btn btn-success" onclick="javascript:unfollowBusiness();">UNFOLLOW</button>
        </div>
    @endif  
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">

    $(document).ready(function(){
        $('.table').DataTable({
            responsive: true
        });
        $('.table').css("width","100%");
        $('.table').addClass("table-striped");
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function unfollowBusiness()
    {
        var data = $("#unfollow").serialize();

        $.ajax({
            url: "{{url('business-unfollow')}}",
            data: data,
            type: "DELETE",
            async: false,
            success: function(response) {
                var data = JSON.parse(JSON.stringify(response));

                if(data['status'] == 'success') {
                    location.reload();
                    $('html, body').animate({
                        scrollTop: 0}, 300);
                    $("#message").html('<div class="alert alert-info fade in"> <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a> '+ data['text']+'</div>');

                    setTimeout(function(){
                        document.getElementById("message").innerHTML = '';
                    }, 3000);

                } else {
                    $('html, body').animate({
                        scrollTop: 0}, 300);
                    $("#message").html('<div class="alert alert-danger fade in"> <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a> '+ data['text']+'</div>');

                    setTimeout(function(){
                        document.getElementById("message").innerHTML = '';
                    }, 3000);

                }
            }
        })
    }

</script>
@endsection
