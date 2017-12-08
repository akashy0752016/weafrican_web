@extends('layouts.app')
@section('title', $pageTitle)
@section('content')
<div class="container row_pad">
    <h5 class="text-left">Product Details</h5>
    <hr>
    @if(Auth::user()->user_role_id == 3 && $products->count()>=5)
        <p class="text-left">Please upgrade your plan to add more products or more images.</p> 
    @endif
    @if(Auth::user()->user_role_id == 3 && $products->count()< 5)
    
        <p class="text-left">You can add Upto 5 products. You have {{5-$products->count()}} products left.</p> 
    @endif
    @if(Auth::user()->user_role_id == 5)
        <p class="text-left">You can add unlimited products.</p> 
    @endif
    
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
    @if(Auth::user()->user_role_id == 3 && $products->count() < 5)
    <p class="text-right"><a href="{{url('business-product/create')}}"><button type="button" class="btn btn-info">Add Product</button></a></p>
    @endif
    @if(Auth::user()->user_role_id == 3 && $products->count() == 5)
        <p class="text-right"><a href="{{url('business-premium-membership-plans')}}"><button type="button" class="btn btn-info">Upgrade premium</button></a></p>
    @endif
    @if(Auth::user()->user_role_id == 5)
        <p class="text-right"><a href="{{url('business-product/create')}}"><button type="button" class="btn btn-info">Add Product</button></a></p>
    @endif

    <div class="panel panel-default table_set">
        <table class="table">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Product Name</th>
                    <th width="40%">Description</th>
                    <th>Price(in {{Auth::user()->currency}})</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @if($products->count()) 
                @foreach($products as $product)
                    <tr>
                        <td>
                            @if(isset($product->business_product_images->featured_image))
                                <img class="event_img" src="{{ asset(config('image.product_image_url').'thumbnails/small/'.$product->business_product_images->featured_image)}}">
                            @else
                                <p>No image found.</p>
                            @endif
                        </td>
                        <td>{{$product->title}}</td>
                        <td>{{$product->description}}</td>
                        <td>{{$product->price}}</td>
                        <td>
                            <ul class="list-inline">
                                <li>
                                    <a href="{{url('business-product/'.$product->id)}}"><button type="button" class="btn btn-success btn_fix" title="View Product"><i class="fa fa-eye" aria-hidden="true"></i></button></a>
                                </li>
                                <li>
                                    <a href="{{url('business-product/'.$product->id.'/edit')}}"><button type="button" class="btn btn-default btn_fix" title="Edit Product"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></a>
                                </li>
                                <li>
                                    <form action="{{url('business-product/'.$product->id)}}" method="POST" onsubmit="deleteProduct('{{$product->id}}', '{{$product->title}}', event,this)">
                                        {{csrf_field()}}
                                        <button type="submit" class="btn btn-danger btn_fix" title="Delete Product"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                                    </form>
                                </li>
                            </ul>
                        </td>
                    <tr>
                @endforeach

            @else
                <tr>
                    <td>No products found</td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>
     {{ $products->links()}}
</div>
@endsection
@section('scripts')
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    function deleteProduct(id, title, event,form)
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