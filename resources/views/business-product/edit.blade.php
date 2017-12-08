@extends('layouts.app')
@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/fineuploader/fine-uploader.css') }}"/>
@endsection

@section('content')
<div class="main-container row">
    <div class="col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1">
        <h5 class="text-left">Edit Product</h5>
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
            <form id="form" class="form-horizontal" action="{{ url('business-product/'.$product->id) }}" method="POST" enctype='multipart/form-data'>
                {{csrf_field()}}
                {{ method_field('PUT') }}
                <div class="form-group ">
                    <label for="category" class="col-md-2 col-sm-2 required control-label">Product Name</label>
                    <div class="col-md-4 col-sm-4">
                        <input type="text" class="form-control" placeholder="Title" name="title" value="{{ $product->title }}" required>
                        @if($errors->has('title'))
                        <span class="help-block">
                        <strong>{{ $errors->first('title') }}</strong>
                        </span>
                        @endif
                    </div>
                    <label for="price" class="col-md-2 col-sm-2 required control-label">Price</label>
                    <div class="col-md-4 col-sm-4">
                        <input type="number" min=1 step=".01" class="form-control" placeholder="Price" name="price" value="{{ $product->price }}">
                        @if($errors->has('price'))
                        <span class="help-block">
                        <strong>{{ $errors->first('price') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="form-group ">
                    <label for="description" class="col-md-2 col-sm-2 required control-label">Description</label>
                    <div class="col-md-10 col-sm-10">
                        <textarea required type="text" class="form-control" placeholder="Description" name="description">{{ $product->description }}</textarea>
                        @if($errors->has('description'))
                        <span class="help-block">
                        <strong>{{ $errors->first('description') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>

                @if(Auth::user()->user_role_id == 3)
                <div class="form-group ">
                    <label for="description" class="col-md-2 col-sm-2 required control-label">Images</label>
                    <div class="col-md-10 col-sm-10">
                        @if($product->business_product_images->featured_image != null)
                        <div class="wrap-border">
                        <div class="image_wrap-div">
                            <img src="{{ asset(config('image.product_image_url').'thumbnails/small/'.$product->business_product_images->featured_image) }}">
                            <a  onclick="javascript:destroy('{{ route("product.deleteImage", [$product->id, $product->business_product_images->featured_image]) }}');"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                        </div>
                        </div>
                        @else
                            <p>No Image Found.Please upload an image.</p>
                        @endif
                    </div>
                </div>
                @else
                <div class="form-group ">
                    <label for="description" class="col-md-2 col-sm-2 required control-label"> Upload Image</label>
                    <div class="col-md-10 col-sm-10">
                        @if($product->business_product_images->featured_image != null)
                        <div class="delete-all-btn"><a class="btn btn-danger" onclick="javascript:destroy('{{ route("product.deleteAllImage", [$product->id]) }}');">
                        Delete all</a></div>
                        <div class="wrap-border">
                            @foreach($product->business_product_images->images() as $image)
                            <div class="image_wrap-div">
                                <img src="{{ asset(config('image.product_image_url').'thumbnails/small/'.$image) }}">
                                <a  onclick="javascript:destroy('{{ route("product.deleteImage", [$product->id, $image]) }}');"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                            </div>
                            @endforeach
                            </div>
                        @else
                            <p>No Image Found.Please upload an image.</p>
                        @endif
                    </div>
                </div>
                @endif

                @if(Auth::user()->user_role_id == 3 && $product->business_product_images->featured_image == null )
                <div class="form-group ">
                    <label for="description" class="col-md-2 col-sm-2 required control-label">Images</label>
                    <div class="col-md-10 col-sm-10">
                        <div class="caption">
                            <div id="fine-uploader"></div>
                        </div>
                            <input type="hidden" id="fileArray" name="fileArray" value="">
                            <input type="hidden" name="featured_image" id="featured_image" value="">
                            <p><strong>*You can upload single image of product.</strong></p>
                    </div> 
                </div>
                @endif
                @if(Auth::user()->user_role_id == 5 && count($product->business_product_images->images()) < 5 )
                 <div class="form-group ">
                    <label for="description" class="col-md-2 col-sm-2 required control-label">Images</label>
                    <div class="col-md-10 col-sm-10">
                        <div class="caption">
                            <div id="fine-uploader"></div>
                        </div>
                        <input type="hidden" id="fileArray" name="fileArray" value="">
                        <input type="hidden" name="featured_image" id="featured_image" value="">
                        @if($product->business_product_images->image) 
                        <p><strong>*You can upload maximum {{5-count($product->business_product_images->images())}} images of product.</strong></p>
                        @else
                        <p><strong>*You can upload maximum 5 images of product.</strong></p>
                        @endif
                    </div> 
                </div>
                @endif

                @if(Auth::user()->user_role_id == 5)
                <div class="form-group">
                    <label class="col-md-2 col-sm-2 control-label">Select featured Image:</label>
                    <div class="col-md-10 col-sm-10" id="img-preview">
                    @if($product->business_product_images->featured_image)
                            @foreach($product->business_product_images->images() as $image)
                                <label id="{{ $image }}">
                                    <input type="radio" value="{{$image}}" name="featured_image" id="featured_image" @if($image == $product->business_product_images->featured_image) checked @endif>
                                    <img src="{{ asset(config('image.product_image_url').'thumbnails/small/'.$image) }}" id="thumbnail">
                                </label>
                            @endforeach
                        @endif
                    </div>
                </div>
                @endif

                <div class="form-group">
                    <div class="col-md-12 col-sm-12 text-right">
                        <button type="submit" class="btn btn-primary">
                        Submit
                        </button>
                    </div>
                </div>
            </form>
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
                            max:35,
                            message:' Product Title should not be less than 5 or greater than 35 characters'
                        },
                            notEmpty: {
                            message: 'Please fill your product title'
                        }
                    }
                },
                description: {
                    validators: {
                        stringLength: {
                            min: 10,
                            max:200,
                            message:' Product description should not be less than 10 or greater than 200 characters'
                        },
                        notEmpty: {
                            message: 'Please supply your product description'
                        }
                    }
                },
                price: {
                    validators: {
                        /*notEmpty: {
                            message: 'Please supply product price'
                        },*/
                        regexp: {
                            regexp: /^\d{0,8}(\.\d{1,2})?$/,
                            message: 'The price can only consist of numbers with two decimal'
                        },
                        greaterThan: {
                            value: 1,
                            message: 'The value must be greater than or equal to 1'
                        }
                    }
                },
                @if($product->business_product_images->image == null)
                fileArray: {
                    validators: {
                        notEmpty: {
                            message: 'Please supply your product image'
                        }
                    }
                }
                @endif
            }
        });
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function destroy(url)
        {
            swal({
                title: "Are you sure?",
                text: "You want to delete the product images?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#36adb5",
                confirmButtonText: "Yes, delete!",
                cancelButtonText: "No, cancel pls!",
                closeOnConfirm: false,
                closeOnCancel: false,
                allowEscapeKey: false,
            },
            function(isConfirm){
                if(isConfirm) {
                    $.ajax({
                        url: url,
                        type: "Post",
                        success: function(data) {
                            if (data['status']) {
                                swal({
                                    title: data['message'],
                                    text: "Press ok to continue",
                                    type: 'success',
                                    showCancelButton: false,
                                    confirmButtonColor: '#36adb5',
                                    confirmButtonText: 'Ok',
                                    closeOnConfirm: false,
                                    allowEscapeKey: false,
                                },
                                function(isConfirm) {
                                    if (isConfirm) {
                                        window.location.reload();
                                    }
                                });
                            } else {
                                swal("Error", data['message'], "error");
                            }
                        }
                    });
                } else {
                    swal("Cancelled", "Images delete operation is cancelled.", "error");
                }
            });
        }

    
</script>
@endsection