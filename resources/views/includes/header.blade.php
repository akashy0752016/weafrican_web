<header id="nav_anchor">
    <div class="header_section">
        <div class="container">
        <div class="row">
            <div class="col-md-3 col-sm-3 logo">
            <div class="row">
                <a href="{{url('/')}}"><img src="{{asset('images/logo.png')}}"></a>
                </div>
            </div>
            <div class="col-md-9 col-sm-9 menu_bar pull-right">
            <div class="row">
                <nav class="navbar mobilescreen_navbar"> 
                    <div class="container-fluid">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            </button>					  
                        </div>
                        <div class="collapse navbar-collapse" id="myNavbar">
                            <ul class="nav navbar-nav navbar-right">
                                <li class="@if(Request::is('/')) active @endif"><a href="{{url('/')}}"><i class="fa fa-home fa-lg" aria-hidden="true" title="Home"></i></a></li>
                                <li class="{{ strpos(Request::path(), 'about') !== false ? 'active' : '' }}"><a href="{{url('about')}}">About Us</a></li>
                                <li class=""><a href="{{url('services')}}">Services</a></li>
                                
                                <li class="subscript_link" class="dropdown-toggle subs_plans" aria-haspopup="true" aria-expanded="false">
                                    <a href="{{url('africa-events')}}" class="dropdown-toggle subs_plans" aria-haspopup="true" aria-expanded="false">Events </a>
                                    <span id="event_toggle" class="caret subscript"></span>
                                    <ul id="event_slide" class="dropdown-menu subsplan">
                                        <li><a href="{{ url('event-login') }}">Event Login</a></li>
                                    </ul>
                                </li>
                                <li class="subscript_link @if(Request::is('business-premium-membership-plans') or Request::is('banner-sponsorship-package') or Request::is('business-ads-packages')) or Request::is('events-plans'))active @endif">
                                    <a class="dropdown-toggle subs_plans" aria-haspopup="true" aria-expanded="false">Subscription Plans </a>
                                    <span id="subscription_toggle" class="caret subscript"></span>
                                    <ul id="subscription_slide" class="dropdown-menu subsplan">
                                        <li><a href="{{url('business-premium-membership-plans')}}">Premium Subscription Plan</a></li>
                                        <li><a href="{{url('banner-sponsorship-package')}}">Sponsor Banner Package</a></li>
                                        <li><a href="{{url('business-ads-packages')}}">Business Ads Package</a></li>
                                        <li><a href="{{url('events-plans')}}">Event Ads Package.</a></li>
                                    </ul>
                                </li>
                                @if(!Auth::check())
                                    <li class="{{ strpos(Request::path(), 'register-business/create') !== false ? 'active' : '' }}"><a href="{{ url('register') }}">Register Business </a>
                                    </li>
                                    </li>
                                    
                                    <li class="{{ strpos(Request::path(), 'login') !== false ? 'active' : '' }}"><a href="{{ url('login') }}">Login</a>
                                    
                                    <li class="{{ strpos(Request::path(), 'contact') !== false ? 'active' : '' }}"><a href="{{ url('contact') }}">Contact Us</a>
                                @elseif(Auth::check())
                                    <!-- <li class="{{ strpos(Request::path(), 'cms/privacy-policy') !== false ? 'active' : '' }}"> <a href="{{url('cms/privacy-policy')}}">Privacy Policy</a> </li> -->
                                    <!-- <li class="{{ strpos(Request::path(), 'cms/terms-of-use') !== false ? 'active' : '' }}"> <a href="{{url('cms/terms-of-use')}}">Terms of Use</a> </li>
                                    <li class="@if(Request::is('event') or Request::is('banner') or Request::is('sponsor'))active @endif">
                                        <a href="{{url('subscription')}}" class="dropdown-toggle subs_plans" aria-haspopup="true" aria-expanded="false">Subscription Plans </a>
                                        <span class="caret subscript"></span>
                                        <ul class="dropdown-menu subsplan">
                                            <li><a href="{{url('sponsor')}}">Sponsor Plans</a></li>
                                            <li><a href="{{url('banner')}}">Business Plans</a></li>
                                            <li><a href="{{url('event')}}">Event Plans</a></li>
                                        </ul>
                                    </li> -->
                                    <li class="{{ strpos(Request::path(), 'contact') !== false ? 'active' : '' }}"><a href="{{ url('contact') }}">Contact Us</a>
                                    @if(Auth::user()->user_role_id == 3 || Auth::user()->user_role_id == 5)
                                    <li>
                                        <div class="dropdown">
                                            <button class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown">{{Auth::user()->first_name}}
                                            <span class="caret"></span></button>
                                            <ul class="dropdown-menu">
                                                <li><a href="{{ url('register-business/'.Auth::id()) }}">Manage Account</a></li>
                                                <li><a href="{{ url('logout') }}">Logout</a></li>
                                            </ul>
                                        </div>
                                    </li>
                                    @else
                                     @if(Auth::user()->user_role_id == 4)
                                     <li><a href="{{ url('create-business') }}" class="download-link">Create business</a></li>
                                     @endif
                                    <li><a href="{{ url('logout') }}" class="download-link">Logout</a></li>
                                    @endif
                                @endif
                            </ul>
                        </div>
                    </div>
                </nav>
                </div>
            </div>
            </div>
        </div>
    </div>
</header>

