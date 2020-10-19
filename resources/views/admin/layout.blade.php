@include('admin.components.header')
@include('admin.components.navigation')
<main role="main">

    @if(Auth::user() && Auth::user()->admin)
        @switch($page)
            @case('home')
                @include('admin.components.dashboard.messages')
                @include('admin.components.dashboard.log_statistics')
                @break
            @case('logs')
                @include('admin.components.logs.logviewer')
                @break
        @endswitch
    @else
        @include('admin.components.login')
    @endif



</main>
@include('admin.components.footer')
