<header class="admin-header">
    <div class="container-fluid">
        <div class="col-md-6 col-xs-6 left-side">
            <ul class="left-menu list-inline">
                <li><a href="#" class="site-logo"><img src="{{asset('images/admin_logo.png')}}"></a></li>
            </ul>
        </div>
        <div class="col-md-6 right-side">
            <ul class="list-inline">
                <li class="login"><a class="btn btn-success top_btn" href="{{url('/')}}" target="_blank">Visit Site</a></li>
                <li><a class="btn btn-danger top_btn" href="{{ url('logout') }}"><i class="fa fa-power-off"></i> Logout</a></li>
            </ul>
        </div>
    </div>
</header>