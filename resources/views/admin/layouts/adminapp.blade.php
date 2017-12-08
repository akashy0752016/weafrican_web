<!DOCTYPE html>
<html lang="en">
    <head>
        @include('admin.includes.head')
    </head>
    <body id="app-layout">
        <div class="page-wrapper">
            
                @if (Auth::check())
                    @include('admin.includes.header')
                @endif
            <div class="head_content">
            <div class="row">
                <div class="main-content">
                @if(Auth::check())
                    <div class="col-md-2">
                        @include('admin.includes.leftmenu')
                    </div>
                @endif           
                    <div class="col-md-10">
                        @yield('content')
                    </div>
                    @yield('scripts')
                </div>
            </div>
            </div>
        </div>
    </body>
</html>