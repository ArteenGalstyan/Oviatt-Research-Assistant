<div class="footer">
    <a href="/" class="footer-icons">Home</a>
    <a href="https://github.com/ArteenGalstyan/Oviatt-Research-Assistant" class="footer-icons">GitHub</a>
    @if (Auth::user())
        <a href="/profile"  class="footer-icons">Profile</a>
        <a href="/history"  class="footer-icons">Search History</a>
        <a href="/favorites"  class="footer-icons">Favorites</a>
        <a href="/logout"  class="footer-icons">Logout</a>
    @else
        <a href="/login"  class="footer-icons">Login</a>
    @endif
    @if (Auth::user() && Auth::user()->admin)
        <a href="/admin"  class="footer-icons">Admin</a>
    @endif
</div>
<script src="{{asset('js/home.js')}}"></script>
