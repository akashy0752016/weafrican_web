@if(Session::has('eventId')) 

    <nav class="navbar navbar-default event_nav">
        <div class="container">
            <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#eventNavbar">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        </button>  
              <a class="navbar-brand" href="{{url('/')}}"><img src="{{asset('images/logo.png')}}"></a>
            </div> 
            <div class="collapse navbar-collapse" id="eventNavbar">

            <ul class="nav navbar-nav">
                <li><a href="{{ url('event/dashboard') }}">Home</a></li>
                <li><a href="{{ url('event/search') }}">Event Tickets</a></li>
                <li><a href="{{ url('event-logout') }}"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
            </ul>
            </div>
        </div>
    </nav>
@else
    
    <nav class="navbar navbar-default event_nav">
        <div class="container">
            <div class="navbar-header">  
              <a class="navbar-brand" href="{{url('/')}}"><img src="{{asset('images/logo.png')}}"></a>
            </div> 
        </div>
    </nav>

@endif
