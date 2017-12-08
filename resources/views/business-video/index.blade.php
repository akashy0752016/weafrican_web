@extends('layouts.app')
@section('title', (isset($pageTitle)) ? $pageTitle: 'Business Videos')
@section('content')
<div class="container row_pad">
    <h5 class="text-left">Video Details</h5>
    <hr>
    <p class="text-left">You can add multiple Videos.</p> 
    @include('notification')
    <p id="video-error"></p>
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <p class="text-right"><a class="btn btn-info" data-toggle="modal" href="#createVideoModal" >{{ (count($videos) == 0) ? 'Add Video' : 'Add more Videos'}} </a></p>
    <div class="videos">
    @include('sections.video-list')
    </div>
    <!-- Create Video Modal-->
    <div class="modal fade" id="createVideoModal" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content video_popup">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Create Video</h4>
                </div>
                <div class="modal-body">
                    <p class="error-message"></p>
                    <div id="loading-image" style="display:none"><img src="{{ asset('images/loading.gif')}}"></div>

                    <form id="video-form" class="form-horizontal" method="POST">
                    {{csrf_field()}}
                    <input type="hidden" name="userId" value="{{ Auth::id()}}">
                        <div class="form-group ">
                            <label for="description" class="col-md-3 col-sm-3 required control-label">Url</label>
                            <div class="col-md-9 col-sm-9">
                                <input required type="url" class="form-control" name="url" id="url">
                                <span>* Video you are going to add must be public.</span>
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="category" class="col-md-3 col-sm-3 required control-label">Video Title</label>
                            <div class="col-md-9 col-sm-9">
                                <input type="text" class="form-control" name="title" value="{{ old('title') }}" required>
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="description" class="col-md-3 col-sm-3 required control-label">Description</label>
                            <div class="col-md-9 col-sm-9">
                                <textarea required type="text" class="form-control" name="description"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12 text-right">
                                <button class="btn btn-primary">
                                Submit
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div> -->
            </div>
        </div>
    </div>
    <!-- Edit Video Modal -->
    <div class="modal fade" id="editVideo" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content video_popup">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit Video</h4>
                </div>
                <div class="modal-body">
                    <p class="error-message" id="error-message"></p>
                    <div id="loading-image" style="display:none"><img src="{{ asset('images/loading.gif')}}"></div>
                    <form id="video-edit-form" class="form-horizontal"  method="POST">
                    {{csrf_field()}}
                    {{ method_field('PUT') }}
                    <input type="hidden" name="userId" id="userId" value="">
                     <input type="hidden" name="videoId" id="videoId" value="">
                        <div class="form-group ">
                            <label for="description" class="col-md-3 col-sm-3 required control-label">Url</label>
                            <div class="col-md-9 col-sm-9">
                                <input required type="text" class="form-control" name="url" id="video_url" value="" readonly="">
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="category" class="col-md-3 col-sm-3 required control-label">Video Title</label>
                            <div class="col-md-9 col-sm-9">
                                <input type="text" class="form-control" name="title" id="title" value="" required>
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="description" class="col-md-3 col-sm-3 required control-label">Description</label>
                            <div class="col-md-9 col-sm-9">
                                <textarea required type="text" class="form-control" id="description" name="description"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12 text-right">
<<<<<<< HEAD
                                <button class="btn btn-primary">
=======
                                <button  class="btn btn-primary">
>>>>>>> 1cd2723847faea66728f8b6f0ffe74f716efd5f2
                                Submit
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div> 
        </div>
    </div>

    <!-- Watch Video Modal -->
    <div class="modal fade" id="watchVideo" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="video-title"></h4>
                </div>
                <div class="modal-body">
                <div class="embed-responsive embed-responsive-16by9 text-center">
                        <iframe id="video" width="680" height="345" src="" frameborder="0" allowfullscreen>
                        </iframe>
                 </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
@section('scripts')
<script src='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-validator/0.4.5/js/bootstrapvalidator.min.js'></script>
<script type="text/javascript">
    //Bootstarp validation on form
    $(document).ready(function() {
        $("#createVideoModal").on('hide.bs.modal', function(){

            $(".error-message").html('');
            document.getElementById("video-form").reset();

        });


        $('#video-form').bootstrapValidator({
            // To use feedback icons, ensure that you use Bootstrap v3.1.0 or later
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                title: {
                    validators: {
                        stringLength: {
                            max:40 ,
                            message: 'The title should be of length 40 character'
                        },
                        notEmpty: {
                            message: 'Please fill your Title'
                        }
                    }
                },
                description: {
                    validators: {
                        stringLength: {
                            max:100 ,
                            message: 'The description should be of length 100 character'
                        },
                        notEmpty: {
                            message: 'Please supply your descriptions'
                        }
                    }
                },
                url: {
                    validators: {
                        uri: {
                            message: 'The url is not valid'
                        },
                        notEmpty: {
                            message: 'Please supply your url'
                        }
                    }
                }
            }
        });
    });

        $('#video-edit-form').bootstrapValidator({
            // To use feedback icons, ensure that you use Bootstrap v3.1.0 or later
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                title: {
                    validators: {
                        stringLength: {
                            max:40 ,
                            message: 'The title should be of length 40 character'
                        },
                        notEmpty: {
                            message: 'Please fill your Title'
                        }
                    }
                },
                description: {
                    validators: {
                        stringLength: {
                            max:100 ,
                            message: 'The description should be of length 100 character'
                        },
                        notEmpty: {
                            message: 'Please supply your descriptions'
                        }
                    }
                },
                url: {
                    validators: {
                        uri: {
                            message: 'The url is not valid'
                        },
                        notEmpty: {
                            message: 'Please supply your url'
                        }
                    }
                }
            }
        });
    

    $('#video-form').on('submit', function (e) {
        e.preventDefault();
        $('#loading-image').show();
        var data = $('#video-form').serialize();
        $.ajax({
            type: "POST",
            url: "{{ url('business-video') }}",
            data: data,
            success: function( result ) {
                $(".error-message").hide();
                $('#loading-image').hide();
                if(result.status == 'success') {
                $("#createVideoModal").modal('hide');
                document.getElementById("video-form").reset();
                $("#video-error").html('<div class="notifications"><div class="alert alert-success alert-block"><button type="button" class="close" data-dismiss="alert">&times;</button><h4>Success</h4>Video added successfully</div></div>');
                $(".videos").html(result.response); 
            } else {
                console.log(result.response);
                $(".error-message").show();
                $(".error-message").html('*'+result.response);
                $("#createVideoModal").modal('show');
            }
            }
        });
        return false;
    });

    function getVideoData(id)
    {
        $.ajax({
            url: "{{ url('business-video')}}"+"/"+id+"/edit",
            type: "GET",
            async: false,
            success: function(result) {
                if(result.status == 'success') {
                    console.log(result.response.url);
                    $("#videoId").val(result.response.id);
                    $("#userId").val(result.response.user_id);
                    $("#video_url").val(result.response.url);
                    $("#title").val(result.response.title);
                    $("#description").val(result.response.description);

                    //$('.modal-body').html(result.response);
                    $('#editVideo').modal('show');
                }
            }
        })
    }

    function videoModal (title, src) {
        var url = src +"?autoplay=1";
                            
    /* Remove iframe src attribute on page load to

    prevent autoplay in background */

    
        $("#watchVideo").modal('show');
    /* Assign the initially stored url back to the iframe src

    attribute when modal is displayed */

    $("#watchVideo").on('shown.bs.modal', function(){
        $('.video-title').html(title);

        $("#video").attr('src', url);

    });

    /* Assign empty url value to the iframe src attribute when

    modal hide, which stop the video playing */
    
    $("#watchVideo").on('hide.bs.modal', function(){

        $("#video").attr('src', '');

    });
    }



    $('#video-edit-form').on('submit', function (e) {
        e.preventDefault();
        $('#loading-image').show();
        var id = $('#videoId').val();
        var data = $('#video-edit-form').serialize();
        console.log(data);
        $.ajax({
            type: "PUT",
            url: "{{ url('business-video') }}"+"/"+id,
            data: data,
            success: function( result ) {
                $('#loading-image').hide();
                if(result.status == 'success') {
                    $("#editVideo").modal('hide');
                    $(".error-message").hide();
                    document.getElementById("video-edit-form").reset();
                    
                    $("#video-error").html('<div class="notifications"><div class="alert alert-success alert-block"><button type="button" class="close" data-dismiss="alert">&times;</button><h4>Success</h4>Video updated successfully</div></div>');


                        
                    $(".videos").html(result.response); 
                    $('.modal-backdrop.in').css('opacity','0');
                    $('.modal-backdrop.in').css('z-index','-9999');
                    
                } else {
                    $("#error-message").html(result.response);
                    $("#editVideo").modal('show');
                }
            }
        });
    });

    function deleteVideo(id, title, event,form) {   
    
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
