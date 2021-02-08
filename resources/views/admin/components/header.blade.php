<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="{{asset('css/admin/admin_main.css')}}">
<script src="{{asset('js/jquery-3.5.1.min.js')}}"></script>
<script src="{{asset('js/api.js')}}"></script>
<header role="banner">
    <h1>Admin Panel</h1>
    <ul class="utilities">
        @if(Auth::user())
            <li class="users"><a href="#">Welcome {{Auth::user()->username}}</a></li>
            <li class="logout warn"><a href="/logout">Log Out</a></li>
        @endif
    </ul>
</header>

