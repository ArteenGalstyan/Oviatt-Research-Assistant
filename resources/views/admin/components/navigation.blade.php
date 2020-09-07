<nav role="navigation">
    <ul class="main">
        <li class="dashboard"><a href="/admin">Dashboard</a></li>
        @if(Auth::user() && Auth::user()->admin)
            <li class="write"><a href="/admin?page=logs">Logs</a></li>
            <li class="edit"><a href="#">SQL Editor</a></li>
            <li class="comments"><a href="#">Messages</a></li>
            <li class="users"><a href="#">Users</a></li>
        @endif
    </ul>
</nav>
