@include('admin.components.header')
@include('admin.components.navigation')
<main role="main">

    @if(Auth::user())
        @include('admin.components.dashboard.messages')
        @include('admin.components.dashboard.log_statistics')
    @else
        @include('admin.components.login')
    @endif


</main>
@include('admin.components.footer')