@if(Auth::check())
    @if(isset($flag) and $flag==0)
    	<div class="col-md-3 col-sm-3 my-account-sidebar">
		    <nav>
			    <ul class="nav">
				    <li><a class="{{ Request::path() == 'my-account' ? 'active' : '' }}"  href="{{ url('my-account') }}">My Account</a></li>
				    <li><a class="{{ Request::path() == 'account-details' ? 'active' : '' }}"  href="{{ url('account-details') }}">Bank Account Details</a></li>
				    @if(Auth::user()->user_role_id == 5)
				    <li ><a class="plan-color">Subscription Plan</a>
					    <ul class="nav" id="submenu1" role="menu" aria-labelledby="btn-1">
								<li><i class="fa fa-angle-right" aria-hidden="true"></i><a class="{{ Request::path() == 'premium-plan-details' ? 'active' : '' }}"  href="{{ url('premium-plan-details')}}">Premium Plan Details</a></li>
						</ul>
					</li>
				    @endif
					<li><a class="plan-color">Advertisements Packages</a>
						<ul class="nav" id="submenu1" role="menu" aria-labelledby="btn-1">
							<li>
								<i class="fa fa-angle-right" aria-hidden="true"></i>
							<a class="{{ strpos(Request::path(), 'sponsor-banner') !== false ? 'active' : '' }}" href="{{ url('sponsor-banner') }}">Sponsor Banners</a></li>
							<li>
							<i class="fa fa-angle-right" aria-hidden="true"></i>
							<a class="{{ strpos(Request::path(), 'business-banner') !== false ? 'active' : '' }}" href="{{ url('business-banner') }}">Business Ads Package</a></li>
							
							<li>
							<i class="fa fa-angle-right" aria-hidden="true"></i>
							<a class="{{ strpos(Request::path(), 'event-banner') !== false ? 'active' : '' }}" href="{{ url('event-banner') }}">Event Ads Package</a></li>
						</ul>
					</li>
					<hr>
					<li><a href="{{ url('subscription-plans') }}">Subscription History</a></li>
				</ul>
			</nav>
		</div>
	@endif
@endif