@extends('layouts.app')
@section('title', $pageTitle)
@section('content')
	<div class="main-container row">
		<h3 class="text-center">Search Subsription Plans</h3>
		<div class="col-md-10 col-md-offset-1">
			<div class="hide-on-mobile">
			@if(isset($plans) and count($plans)>0)
				<div class="row hidden-xs">
					<div class="col-md-3">
					</div>
					@php
					$i=0
					@endphp
					@foreach($plans as $plan)
						<div class="col-md-2 @if($i%2==0) qode-bg-adwords-color-even @else qode-bg-adwords-color-odd @endif">
							<div class="qode-adwords-header">	
								<p class="qode-adwords-price-title">{{$plan->title}}</p>
								<p class="qode-price-top-adwords"><sup></sup><span class="qode-price-adwords">$ {{$plan->price}}</span><span class="qode-mo">/mo</span></p>
								<!-- <p class="qode-minimum-time-adwords">50 Keywords</p> -->
							</div>
						</div>
						@php
						$i++
						@endphp
					@endforeach
				</div>
				<div class="row row-color-adwords-price ">
					<div class="col-md-3 col-sm-12 bg-222">
						<h5 class="header-row-adwords">Setup and social media</h5>
					</div><!-- column -->
					<div class="col-md-2 bg-222 border-top-padding display-none-sm">
						<h5 class="adwords-column-content"></h5>
					</div><!-- column -->
					<div class="col-md-2 bg-222 border-top-padding display-none-sm">
						<h5 class="adwords-column-content"></h5>
					</div><!-- column -->
					<div class="col-md-2 bg-222 border-top-padding display-none-sm">
						<h5 class="adwords-column-content"></h5>
					</div><!-- column -->
					<div class="col-md-1 display-none-sm"></div>
				</div>
				<div class="row row-color-adword row-sub-heading">
					<div class="col-md-3 col-sm-3 padding-l-adwords-column-15 bg-f3f3f3">
						<h5 class="seo-section-adwords adwords-left-content adwords-column-content">OPTIMIZATION SETUP &amp; TOOLS</h5>
					</div><!-- column -->
					<div class="col-md-2 col-sm-2 padding-lf-adwords-column-0 text-center bg-eee">
						<h5 class="adwords-column-content"></h5>
					</div><!-- column -->
					<div class="col-md-2 col-sm-2 padding-lf-adwords-column-0 text-center border-right-left bg-f3f3f3">
						<h5 class="adwords-column-content"></h5>
					</div><!-- column -->
					
					<div class="col-md-2 col-sm-2 padding-lf-adwords-column-0 text-center bg-eee">
						<h5 class="adwords-column-content"></h5>
					</div><!-- column -->
					<div class="col-md-2 col-sm-2 padding-lf-adwords-column-0 text-center>
						<h5 class="adwords-column-content"></h5>
					</div><!-- column -->
				</div>
				<div class="row row-adwords-price row-special-md-down row-seo-plan-special">
					<div class="col-md-3 col-sm-3  padding-l-adwords-column-15 bg-f3f3f3">
						<h5 class="seo-section-adwords adwords-left-content adwords-column-content">Google Webmaster Tools</h5>	
					</div><!-- column -->
					<div class="col-md-2 col-sm-2 padding-lf-adwords-column-0 text-center bg-eee">
						<h5 class="adwords-column-content"><i class="fa fa-check" aria-hidden="true"></i></h5>
					</div><!-- column -->
					<div class="col-md-2 col-sm-2 padding-lf-adwords-column-0 text-center border-right-left bg-f3f3f3">
						<h5 class="adwords-column-content"><i class="fa fa-check" aria-hidden="true"></i></h5>
					</div><!-- column -->
					
					<div class="col-md-2 col-sm-2 padding-lf-adwords-column-0 text-center bg-eee">
						<h5 class="adwords-column-content"><i class="fa fa-check" aria-hidden="true"></i></h5>
					</div><!-- column -->
				</div>
				<div class="row row-adwords-price row-special-md-down row-seo-plan-special">
					<div class="col-md-3 col-sm-3  padding-l-adwords-column-15 bg-f3f3f3">
						<h5 class="seo-section-adwords adwords-left-content adwords-column-content">Meta Tags &amp; Content Optimization</h5>	
					</div><!-- column -->
					<div class="col-md-2 col-sm-2 padding-lf-adwords-column-0 text-center bg-eee">
						<h5 class="adwords-column-content"><i class="fa fa-check" aria-hidden="true"></i></h5>
					</div><!-- column -->
					<div class="col-md-2 col-sm-2 padding-lf-adwords-column-0 text-center border-right-left bg-f3f3f3">
						<h5 class="adwords-column-content"><i class="fa fa-check" aria-hidden="true"></i></h5>
					</div><!-- column -->
					
					<div class="col-md-2 col-sm-2 padding-lf-adwords-column-0 text-center bg-eee">
						<h5 class="adwords-column-content"><i class="fa fa-check" aria-hidden="true"></i></h5>
					</div><!-- column -->
				</div>
				<div class="row row-adwords-price row-special-md-down row-seo-plan-special">
					<div class="col-md-3 col-sm-3  padding-l-adwords-column-15 bg-f3f3f3">
						<h5 class="seo-section-adwords adwords-left-content adwords-column-content">XML Sitemap, Robots.txt Validation</h5>	
					</div><!-- column -->
					<div class="col-md-2 col-sm-2 padding-lf-adwords-column-0 text-center bg-eee">
						<h5 class="adwords-column-content"><i class="fa fa-check" aria-hidden="true"></i></h5>
					</div><!-- column -->
					<div class="col-md-2 col-sm-2 padding-lf-adwords-column-0 text-center border-right-left bg-f3f3f3">
						<h5 class="adwords-column-content"><i class="fa fa-check" aria-hidden="true"></i></h5>
					</div><!-- column -->
					
					<div class="col-md-2 col-sm-2 padding-lf-adwords-column-0 text-center bg-eee">
						<h5 class="adwords-column-content"><i class="fa fa-check" aria-hidden="true"></i></h5>
					</div><!-- column -->
				</div>
				<div class="row row-adwords-price row-special-md-down row-seo-plan-special">
					<div class="col-md-3 col-sm-3  padding-l-adwords-column-15 bg-f3f3f3">
						<h5 class="seo-section-adwords adwords-left-content adwords-column-content">Google Places &amp; Maps Setup</h5>	
					</div><!-- column -->
					<div class="col-md-2 col-sm-2 padding-lf-adwords-column-0 text-center bg-eee">
						<h5 class="adwords-column-content"><i class="fa fa-check" aria-hidden="true"></i></h5>
					</div><!-- column -->
					<div class="col-md-2 col-sm-2 padding-lf-adwords-column-0 text-center border-right-left bg-f3f3f3">
						<h5 class="adwords-column-content"><i class="fa fa-check" aria-hidden="true"></i></h5>
					</div><!-- column -->
					
					<div class="col-md-2 col-sm-2 padding-lf-adwords-column-0 text-center bg-eee">
						<h5 class="adwords-column-content"><i class="fa fa-check" aria-hidden="true"></i></h5>
					</div><!-- column -->
				</div>
				<div class="row row-adwords-price row-special-md-down row-seo-plan-special">
					<div class="col-md-3 col-sm-3  padding-l-adwords-column-15 bg-f3f3f3">
						<h5 class="seo-section-adwords adwords-left-content adwords-column-content">Bing, Yahoo Listings &amp; YELP</h5>	
					</div><!-- column -->
					<div class="col-md-2 col-sm-2 padding-lf-adwords-column-0 text-center bg-eee">
						<h5 class="adwords-column-content"><i class="fa fa-check" aria-hidden="true"></i></h5>
					</div><!-- column -->
					<div class="col-md-2 col-sm-2 padding-lf-adwords-column-0 text-center border-right-left bg-f3f3f3">
						<h5 class="adwords-column-content"><i class="fa fa-check" aria-hidden="true"></i></h5>
					</div><!-- column -->
					
					<div class="col-md-2 col-sm-2 padding-lf-adwords-column-0 text-center bg-eee">
						<h5 class="adwords-column-content"><i class="fa fa-times" aria-hidden="true"></i></h5>
					</div><!-- column -->
				</div>
				<div class="row row-color-adwords-price ">
					<div class="col-md-3"></div>
					@php
					$i=0
					@endphp
					@foreach($plans as $plan)
						<div class="col-md-2 @if($i%2==0) qode-bg-adwords-color-even @else qode-bg-adwords-color-odd @endif">
							<p class="set-up-fees">
							<span>ONE-TIME SETUP FEE $999</span>
							<span>(No setup fee with</span>
							<span>6 month contract)</span>
						</p>
						<h5 class="adwords-start-now">
							@if(Auth::check())
								<a href="#">BUY NOW</a>
							@else
								<a href="{{ url('login') }}">START NOW</a>
							@endif
						</h5>
						</div>
						@php
						$i++
						@endphp
					@endforeach
				</div>
			@else
				<div class="col-md-12">
					<p>No Plans have been added.</p>
				</div>
			@endif
			</div>
			<div class="hide-on-desktop">
                <section class="qode-ppc-price-section">
	
		@if(isset($plans) and count($plans)>0)
			@php
			$i=0
			@endphp
			@foreach($plans as $plan)
				<!--.plan start 1-->
				<div class="row">
					<div class="col-xs-12 qode-bg-adwords-color-even">
						<div class="qode-adwords-header">	
							<p class="qode-adwords-price-title">{{$plan->title}}</p>
							<p class="qode-price-top-adwords"><sup></sup><span class="qode-price-adwords">$ {{$plan->price}}</span><span class="qode-mo">/mo</span></p>
						</div><!-- qode-adwards-header -->
					</div>
				</div><!-- row -->
				@if($i==0)
					<!-- Plan 1 -->
					<!-- setup -->
					<div class="row row-color-adwords-price ">
						<div class="col-xs-12 col-md-offset-1 bg-222">
							<h5 class="header-row-adwords">Setup and social media</h5>
						</div><!-- column -->
					</div><!-- row --> 
					<div class="row row-color-adword row-sub-heading">
						<div class="col-sm-12 padding-l-adwords-column-15 bg-f3f3f3">
							<h5 class="seo-section-adwords adwords-left-content adwords-column-content">OPTIMIZATION SETUP &amp; TOOLS</h5>
						</div><!-- column -->			
					</div>

					<div class="row row-adwords-price row-price-xs">
						<div class="col-xs-8 bg-f3f3f3">
							<h5 class="seo-section-adwords adwords-left-content adwords-column-content">Google+, Facebook, Linkedin, Twitter Business Page Creation</h5>	
						</div><!-- column -->
						<div class="col-xs-4  text-center bg-eee">
							<h5 class="adwords-column-content"><i class="fa fa-check" aria-hidden="true"></i></h5>
						</div><!-- column -->
					</div><!-- row -->
					<div class="row row-adwords-price row-price-xs-down">
						<div class="col-xs-8 bg-f3f3f3">
							<h5 class="seo-section-adwords adwords-left-content adwords-column-content">Google Webmaster Tools</h5>	
						</div><!-- column -->
						<div class="col-xs-4 text-center bg-eee">
							<h5 class="adwords-column-content"><i class="fa fa-check" aria-hidden="true"></i></h5>
						</div><!-- column -->
					</div><!-- row -->
					<div class="row row-adwords-price heightManage">
						<div class="col-xs-8  bg-f3f3f3">
							<h5 class="seo-section-adwords adwords-left-content adwords-column-content">Meta Tags &amp; Content Optimization</h5>	
						</div><!-- column -->
						<div class="col-xs-4 text-center bg-eee height65">
							<h5 class="adwords-column-content"><i class="fa fa-check" aria-hidden="true"></i></h5>
						</div><!-- column -->
					</div><!-- row -->
						<div class="row row-adwords-price heightManage">
						<div class="col-xs-8  bg-f3f3f3">
							<h5 class="seo-section-adwords adwords-left-content adwords-column-content">XML Sitemap, Robots.txt Validation</h5>	
						</div><!-- column -->
						<div class="col-xs-4 text-center bg-eee height65">
							<h5 class="adwords-column-content"><i class="fa fa-check" aria-hidden="true"></i></h5>
						</div><!-- column -->
					</div><!-- row -->
						<div class="row row-adwords-price heightManage">
						<div class="col-xs-8  bg-f3f3f3">
							<h5 class="seo-section-adwords adwords-left-content adwords-column-content">Google Places &amp; Maps Setup</h5>	
						</div><!-- column -->
						<div class="col-xs-4 text-center bg-eee height65">
							<h5 class="adwords-column-content"><i class="fa fa-check" aria-hidden="true"></i></h5>
						</div><!-- column -->
					</div><!-- row -->
					<div class="row row-adwords-price heightManage">
						<div class="col-xs-8  bg-f3f3f3">
							<h5 class="seo-section-adwords adwords-left-content adwords-column-content">Bing, Yahoo Listings &amp; YELP</h5>	
						</div><!-- column -->
						<div class="col-xs-4 text-center bg-eee height65">
							<h5 class="adwords-column-content"><i class="fa fa-check" aria-hidden="true"></i></h5>
						</div><!-- column -->
					</div><!-- row -->
				@elseif($i==1)
					<!-- Plan 2 -->
					<!-- setup -->
					<div class="row row-color-adwords-price ">
						<div class="col-xs-12 col-md-offset-1 bg-222">
							<h5 class="header-row-adwords">Setup and social media</h5>
						</div><!-- column -->
					</div><!-- row --> 
					<div class="row row-color-adword row-sub-heading">
						<div class="col-sm-12 padding-l-adwords-column-15 bg-f3f3f3">
							<h5 class="seo-section-adwords adwords-left-content adwords-column-content">OPTIMIZATION SETUP &amp; TOOLS</h5>
						</div><!-- column -->			
					</div>

					<div class="row row-adwords-price row-price-xs">
						<div class="col-xs-8 bg-f3f3f3">
							<h5 class="seo-section-adwords adwords-left-content adwords-column-content">Google+, Facebook, Linkedin, Twitter Business Page Creation</h5>	
						</div><!-- column -->
						<div class="col-xs-4  text-center bg-eee">
							<h5 class="adwords-column-content"><i class="fa fa-check" aria-hidden="true"></i></h5>
						</div><!-- column -->
					</div><!-- row -->
					<div class="row row-adwords-price row-price-xs-down">
						<div class="col-xs-8 bg-f3f3f3">
							<h5 class="seo-section-adwords adwords-left-content adwords-column-content">Google Webmaster Tools</h5>	
						</div><!-- column -->
						<div class="col-xs-4 text-center bg-eee">
							<h5 class="adwords-column-content"><i class="fa fa-check" aria-hidden="true"></i></h5>
						</div><!-- column -->
					</div><!-- row -->
					<div class="row row-adwords-price heightManage">
						<div class="col-xs-8  bg-f3f3f3">
							<h5 class="seo-section-adwords adwords-left-content adwords-column-content">Meta Tags &amp; Content Optimization</h5>	
						</div><!-- column -->
						<div class="col-xs-4 text-center bg-eee height65">
							<h5 class="adwords-column-content"><i class="fa fa-check" aria-hidden="true"></i></h5>
						</div><!-- column -->
					</div><!-- row -->
						<div class="row row-adwords-price heightManage">
						<div class="col-xs-8  bg-f3f3f3">
							<h5 class="seo-section-adwords adwords-left-content adwords-column-content">XML Sitemap, Robots.txt Validation</h5>	
						</div><!-- column -->
						<div class="col-xs-4 text-center bg-eee height65">
							<h5 class="adwords-column-content"><i class="fa fa-check" aria-hidden="true"></i></h5>
						</div><!-- column -->
					</div><!-- row -->
						<div class="row row-adwords-price heightManage">
						<div class="col-xs-8  bg-f3f3f3">
							<h5 class="seo-section-adwords adwords-left-content adwords-column-content">Google Places &amp; Maps Setup</h5>	
						</div><!-- column -->
						<div class="col-xs-4 text-center bg-eee height65">
							<h5 class="adwords-column-content"><i class="fa fa-check" aria-hidden="true"></i></h5>
						</div><!-- column -->
					</div><!-- row -->
					<div class="row row-adwords-price heightManage">
						<div class="col-xs-8  bg-f3f3f3">
							<h5 class="seo-section-adwords adwords-left-content adwords-column-content">Bing, Yahoo Listings &amp; YELP</h5>	
						</div><!-- column -->
						<div class="col-xs-4 text-center bg-eee height65">
							<h5 class="adwords-column-content"><i class="fa fa-check" aria-hidden="true"></i></h5>
						</div><!-- column -->
					</div><!-- row -->
				@endif
				<!--.Reporting end-->
				<!--.start now start-->
				<div class="row row-color-adwords-price ">
					<div class="col-md-2 col-md-offset-3 col-sm-2 col-sm-offset-3 qode-bg-adwords-color-odd">
						<p class="set-up-fees">
							<span>ONE-TIME SETUP FEE $999</span>
							<span>(No setup fee with</span>
							<span>6 month contract)</span>
						</p>
						<h5 class="adwords-start-now">
							@if(!Auth::check())
								<a href="{{ url('login') }}">START NOW</a>
							@else
								<a href="#">BUY NOW</a>
							@endif
						</h5>
					</div><!-- column -->
				</div><!--.row-->
				<!--.start now end-->
				<!--.plan end 1-->
				@php
				$i++
				@endphp
			@endforeach
		@else
			<div class="col-md-12">
				<p>No Plans have been added.</p>
			</div>
		@endif
		</section><!-- qode-ppc-price-section -->

                </div>
		</div>
	</div>
		</div>
	</div>
@endsection