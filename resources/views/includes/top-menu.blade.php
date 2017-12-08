@if(Auth::check() and (Auth::user()->user_role_id == 3 || Auth::user()->user_role_id == 5))
    @if(isset($flag) and $flag == 0)
    <div class="top-business-menu">
    <div class="container">
    <div class="row"> 
        <ul class="nav nav-pills">
            <li role="presentation"><a href="{{ url('register-business/'.Auth::id()) }}">Business Profile</a></li>
            <li role="presentation"><a href="{{ url('business-service') }}">Service</a></li>
            @if(isset($category_check) and ($category_check==1 or $category_check == 2))
                <li role="presentation"><a href="{{ url('portfolio') }}">Portfolio</a></li>
            @else
                <li role="presentation"><a href="{{ url('business-product') }}">Product</a></li>
            @endif
            @if(Auth::user()->user_role_id == 5)
            <li role="presentation"><a href="{{ url('business-video') }}">Video</a></li>
            @else
            <li role="presentation"><a href="#" data-toggle="modal" data-target="#premium-popup">Video</a></li>
            @endif
            
            <li role="presentation"><a href="{{ url('business-event') }}">Event</a></li>
            @if(Auth::user()->user_role_id == 5)
            <li role="presentation"><a href="{{ url('business-following') }}">Following</a></li>
            
            <li role="presentation"><a href="{{ url('business-follower') }}">Followers</a></li>
            @endif
            <li role="presentation"><a href="{{ url('my-account') }}">My Account</a></li>
            <!-- <li role="presentation"><a href="{{ url('banners') }}">Banners</a></li>
            <li role="presentation"><a href="{{ url('subscription-plans') }}">Subscription History</a> </li>-->
            <!-- <li role="presentation" class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                Dropdown <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <li role="presentation" class="active"><a href="#">Home</a></li>
                    <li role="presentation"><a href="#">Profile</a></li>
                    <li role="presentation"><a href="#">Messages</a></li>
                </ul>
            </li> -->
        </ul>
        </div>
        </div>
    </div>
    @endif
@endif

<!-- show message Modal -->
    <div class="modal fade" id="premium-popup" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h5 class="modal-title">Message</h5>
            </div>
            <div class="modal-body">
              <p>Please upgrade to premium plan to access video’s section. <p>
              <a href="{{url('business-premium-membership-plans')}}" class="btn btn-warning text-center">Buy Premium Plan</a>

            </div>
        </div>
    </div>
</div>