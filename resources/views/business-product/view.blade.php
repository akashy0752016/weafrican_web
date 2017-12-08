@extends('layouts.app')
@section('styles')
    <link href="{{ asset('css/lightgallery/lightgallery.css')}}" rel="stylesheet">
    <style>
        .list-unstyled>li:first-child{
            display: block;
        }
        .list-unstyled>li{
        display:none;
    }
    </style>
@endsection
@section('header-scripts')
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
@endsection
@section('content')
<div class="main-container row">
    <div class="center-box">
        <h5 class="text-left">View Product</h5>
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
        <div class="panel panel-default document view_product">
            <div class="container">
                <div class="col-md-5 col-sm-5">
                <div class="row">
                    <div class="product service-image-left">
                        <!-- Images View template -->
                        <div class="demo-gallery">
                            <ul id="lightgallery" class="list-unstyled row">
                            @foreach($product->business_product_images->images() as $key => $image)
                                <li class="col-xs-6 col-sm-4 col-md-3 featured_image" data-responsive="{{ asset(config('image.product_image_url').'thumbnails/medium/'.$image)}} 375, {{ asset(config('image.product_image_url').'thumbnails/medium/'.$image)}} 480, {{ asset(config('image.product_image_url').'thumbnails/medium/'.$image)}} 800" data-src="{{ asset(config('image.product_image_url').'thumbnails/medium/'.$image)}}" data-sub-html="<h4>{{$product->title}}</h4><p>{{$product->description}}</p>">
                                    <img class="img-responsive" src="{{ asset(config('image.product_image_url').'thumbnails/medium/'.$image)}}">
                                    <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>
                                </li>
                            @endforeach
                            </ul>
                        </div>
                        <!-- <div class="owl-carousel owl-theme">
                            @if($product->business_product_images->image && strpos($product->business_product_images->image , '|'))
                                <img src="{{ asset(config('image.product_image_url').'thumbnails/small/'.explode('|',$product->business_product_images->image)[1])}}" onclick="javascript:showImages();">
                            @elseif($product->business_product_images->image)
                                <img  src="{{ asset(config('image.product_image_url').'thumbnails/small/'.$product->business_product_images->image)}}" onclick="javascript:showImages();">
                            @else
                                <p>No image found.</p>
                            @endif
                            
                        </div> -->
                    </div>
                    </div>
                </div>
                <div class="col-md-7 col-sm-7">
                <div class="row">
                    <div class="product-title"><label>Title:&nbsp;&nbsp;</label>{{$product->title}}</div>
                    <div class="product-desc"><label>Description:&nbsp;&nbsp;</label>{{$product->description}}</div>
                    <div class="product-price"><label>Price:&nbsp;&nbsp;</label>{{Auth::user()->currency}} {{$product->price}}</div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/picturefill/2.3.1/picturefill.min.js"></script>
<script src="{{ asset('js/lightgallery/lightgallery-all.min.js')}}"></script>
<script src="{{ asset('js/lightgallery/lib/jquery.mousewheel.min.js') }}"></script>
<script type="text/javascript">

$(document).ready(function(){
    $('#lightgallery').lightGallery();
});  
</script>
@endsection