<nav role="navigation">
    <ul class="main">
        <li class="dashboard"><a href="#">Dashboard</a></li>
        @if(Auth::user())
            <li class="write"><a href="#">Logs</a></li>
            <li class="edit"><a href="#">SQL Editor</a></li>
            <li class="comments"><a href="#">Messages</a></li>
            <li class="users"><a href="#">Users</a></li>
        @endif
    </ul>
</nav>
