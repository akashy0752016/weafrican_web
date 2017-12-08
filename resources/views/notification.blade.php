@if ($message = Session::get('success'))

<div class="notifications">
    <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Success!</strong>
        @if(is_array($message))
            @foreach ($message as $m)
                {{ $m }}
            @endforeach
        @else
            {{ $message }}
        @endif
    </div>
</div>
@endif

@if ($message = Session::get('error'))

<div class="notifications">
    <div class="alert alert-danger alert-block">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Error!</strong>
        @if(is_array($message))
        @foreach ($message as $m)
        {{ $m }}
        @endforeach
        @else
        {!! $message !!}
        @endif
    </div>
</div>
@endif

@if ($message = Session::get('warning'))
<div class="notifications">
    <div class="alert alert-warning alert-block">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Warning!</strong>
        @if(is_array($message))
        @foreach ($message as $m)
        {{ $m }}
        @endforeach
        @else
        {{ $message }}
        @endif
    </div>
</div>
@endif

@if ($message = Session::get('alert'))
<div class="notifications">
    <div class="alert alert-warning alert-block">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Alert!</strong>
        @if(is_array($message))
        @foreach ($message as $m)
        {{ $m }}
        @endforeach
        @else
        {{ $message }}
        @endif
    </div>
</div>
@endif

@if ($message = Session::get('info'))
    <div class="alert alert-info alert-block">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <h4>Info</h4>
        @if(is_array($message))
        @foreach ($message as $m)
        {{ $m }}
        @endforeach
        @else
        {{ $message }}
        @endif
    </div>
@endif