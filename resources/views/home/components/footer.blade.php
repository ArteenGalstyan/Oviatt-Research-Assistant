<div class="footer">
    <a href="#" class="footer-icons">About</a>
    <a href="https://github.com/ArteenGalstyan/Oviatt-Research-Assistant" class="footer-icons">GitHub</a>
    @if (Auth::user())
        <a href="/logout"  class="footer-icons">Logout</a>
    @else
        <a href="/login"  class="footer-icons">Login</a>
    @endif
    <a href="/admin"  class="footer-icons">Admin</a>
</div>
<script src="{{asset('js/home.js')}}"></script>
