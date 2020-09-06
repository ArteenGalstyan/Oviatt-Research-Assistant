<link rel="stylesheet" href="css/admin/main.css">
<header role="banner">
    <h1>Admin Panel</h1>
    <ul class="utilities">
        @if(Auth::user())
            <li class="users"><a href="#">My Account</a></li>
            <li class="logout warn"><a href="">Log Out</a></li>
        @endif
    </ul>
</header>

