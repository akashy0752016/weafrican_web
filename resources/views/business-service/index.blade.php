@extends('layouts.app')
@section('title', $pageTitle)
@section('content')
<div class="container row_pad">
    <h5 class="text-left">Service Details</h5>
    <hr>
    <p class="text-left">You can add multiple services.</p> 
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
    <p class="text-right"><a href="{{url('business-service/create')}}"><button type="button" class="btn btn-info">Add Service</button></a></p>
    <div class="panel panel-default table_set ">
        <table class="table">
            <thead>
                <tr>
                    <th>Service Name</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @if($services->count()) 
                @foreach($services as $service)
                    <tr>
                        <td>{{$service->title}}</td>
                        <td>{{$service->description}}</td>
                        <td>
                            <ul class="list-inline">
                                <li>
                                    <a href="{{url('business-service/'.$service->id.'/edit')}}"><button type="button" class="btn btn-default btn_fix" title="Edit Service"><i class="fa fa-pencil-square-o" aria-hidden="true" ></i>
                                    </button></a>
                                </li>
                                <li>
                                    <form action="{{url('business-service/'.$service->id)}}" method="POST" onsubmit="deleteService('{{$service->id}}', '{{$service->title}}', event,this)">
                                        {{csrf_field()}}
                                        <button type="submit" class="btn btn-danger btn_fix" title="Delete Service"><i class="fa fa-trash-o" aria-hidden="true"></i>
                                        </button>
                                    </form>
                                </li>
                            <ul>
                        </td>
                    <tr>
                @endforeach
            @else
                <tr>
                    <td>No services found</td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>
    {{ $services->links() }}
</div>
@endsection
@section('scripts')
<script type="text/javascript">
    function deleteService(id, title, event,form)
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