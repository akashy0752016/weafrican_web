@extends('layouts.app')
@section('title', $pageTitle)
@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/fineuploader/fine-uploader.css') }}"/>
@endsection

@section('content')
<div class="container row_pad">
    <div class="col-md-12">
    <div class="row">
        <h5 class="text-left">Create new Portfolio</h5>
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
        <div class="panel panel-default document">
            <form id="form" class="form-horizontal" action="{{ url('portfolio') }}" method="POST">
                {{csrf_field()}}
                <div class="form-group ">
                    <label for="category" class="col-md-3 col-sm-3 required control-label">Title</label>
                    <div class="col-md-9 col-sm-9">
                        <input type="text" class="form-control" name="title" value="{{ old('title') }}" required>
                        @if($errors->has('title'))
                            <span class="help-block">
                            <strong>{{ $errors->first('title') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group ">
                    <label for="description" class="col-md-3 col-sm-3 required control-label">Description</label>
                    <div class="col-md-9 col-sm-9">
                        <textarea required type="text" class="form-control" name="description"></textarea>
                        @if($errors->has('description'))
                            <span class="help-block">
                            <strong>{{ $errors->first('description') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group ">
                    <label for="description" class="col-md-3 col-sm-3 required control-label">Images</label>
                    <div class="col-md-9 col-sm-9">
                        <div class="caption">
                            <div id="fine-uploader"></div>   
                        </div>
                        <input type="hidden" id="fileArray" name="fileArray" value="">
                        @if(Auth::user()->user_role_id == 3)
                            <input type="hidden" name="featured_image" id="featured_image" value="">
                            <p><strong>*You can upload single image of portfolio.</p>
                        @else
                            <p><strong>*You can upload maximum 5 images of portfolio.</p>
                        @endif
                    </div>
                </div>
                @if(Auth::user()->user_role_id == 5)
                <div class="form-group">
                    <label class="col-md-3 col-sm-3 control-label">Select featured Image:</label>
                    <div class="col-md-9 col-sm-9" id="img-preview">
                    </div>
                </div>
                @endif
                <div class="form-group">
                    <div class="col-md-12 text-right">
                        <button type="submit" class="btn btn-primary">
                        Submit
                        </button>
                    </div>
                </div>
            </form>
        </div>
        </div>
    </div>
</div>
@include('fine-uploader.base-template')
@endsection
@section('scripts')
<script type="text/javascript" src="{{ asset('js/fine-uploader/jquery.fine-uploader.js') }}"></script>
@if(Auth::user()->user_role_id == 3)
<script type="text/javascript" src="{{ asset('js/fine-uploader/upload_single.js') }}"></script>
@else
<script type="text/javascript" src="{{ asset('js/fine-uploader/setup.js') }}"></script>
@endif
<script src='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-validator/0.4.5/js/bootstrapvalidator.min.js'></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/jquery.formvalidation/0.6.1/css/formValidation.min.css">

<script src='https://cdn.jsdelivr.net/jquery.formvalidation/0.6.1/js/formValidation.min.js'></script>
<script src='https://cdn.jsdelivr.net/jquery.formvalidation/0.6.1/js/framework/bootstrap.min.js'></script>
<script type="text/javascript">

    function showImage(uuid, fileName) {
        $( "#img-preview" ).append('<label id="'+uuid+'"></label>'); 

        var x = document.createElement("INPUT");
        x.setAttribute("type", "radio");
        x.value = fileName;
        x.name = "featured_image";
        x.id = "featured_image";

        var img = document.createElement("IMG");
        img.src = '{{ asset("uploads/temp")}}'+'/'+uuid+'/'+fileName;
        img.id= 'thumbnail';

        document.getElementById(uuid).appendChild(x);
        document.getElementById(uuid).appendChild(img);  

        document.querySelectorAll('[name=featured_image]')[0].checked = true;      
    }

    $('#fileArray').change(function(){

        //alert("changed");
         $('#form').bootstrapValidator('revalidateField', 'fileArray');
    });

    previousVal = "";
    function InputChangeListener()
    {
        if($('#fileArray').val()!= previousVal)
        {
            previousVal  = $('#fileArray').val();
            $('#fileArray').change();    
        }
    }

    setInterval(InputChangeListener, 500);

    //Bootstarp validation on form
    $(document).ready(function() {
        $('#form').bootstrapValidator({
            excluded: [],
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
                            min: 5,
                        },
                            notEmpty: {
                            message: 'Please fill your portfolio title'
                        }
                    }
                },
                description: {
                    validators: {
                        notEmpty: {
                            message: 'Please supply your portfolio description'
                        }
                    }
                },
                featured_image: {
                    validators: {
                        notEmpty: {
                            message: 'Please select featured image'
                        }
                    }
                },
                fileArray: {
                    validators: {
                        notEmpty: {
                            message: 'Please supply your portfolio image'
                        }
                    }
                }
            }
        });
    });

    
</script>
@endsection