<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="css/admin/main.css">
<script src="js/api.js"></script>
<header role="banner">
    <h1>Admin Panel</h1>
    <ul class="utilities">
        @if(Auth::user())
            <li class="users"><a href="#">My Account</a></li>
            <li class="logout warn"><a href="/logout">Log Out</a></li>
        @endif
    </ul>
</header>

