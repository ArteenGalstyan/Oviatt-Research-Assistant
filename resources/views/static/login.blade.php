<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="/css/login.css">
<div id="particles"></div>
<script async="" defer="" src="https://buttons.github.io/buttons.js"></script>
<script src="https://cdn.jsdelivr.net/npm/tsparticles@1.17.0-beta.7/dist/tsparticles.min.js"></script>

<div class="container" id="container">
    <div class="form-container sign-up-container">
        <form id="register-form" onsubmit="return false;">
            @csrf
            <h1>Create Account</h1>
            <input id="r-username" type="text" autocomplete="" placeholder="Username" />
            <input id="r-email" type="email" autocomplete="" placeholder="Email" />
            <input id="r-password" type="password" autocomplete="" placeholder="Password" />
            <input id="r-password-confirm" type="password" autocomplete="" placeholder="Confirm Password" />
            <span id="register-error"></span>
            <button id="register">Sign Up</button>
        </form>
        <span id="register-success-span" style="display: none">Success!</span>
        <span id="register-success-subspan" style="display: none">Check your email for the verification link!</span>
    </div>
    <div class="form-container sign-in-container">
        <form id="login-form" onsubmit="return false;">
            @csrf
            <h1>Sign in</h1>
            <div class="social-container">
            </div>
            <input id="l-username" type="username" placeholder="Username" />
            <input id="l-password" type="password" placeholder="Password" />
            <a href="#">Forgot your password?</a>
            <span id="login-error"></span>
            <button id="login" onclick="login()">Sign In</button>
        </form>
    </div>
    <div class="overlay-container">
        <div class="overlay">
            <div class="overlay-panel overlay-left">
                <h1>Already Registered?</h1>
                <p>Sign in instead</p>
                <button class="ghost" id="signIn">Sign In</button>
            </div>
            <div class="overlay-panel overlay-right">
                <h1>No account?</h1>
                <p>Sign up today to get the full benefits of our Machine Learning algorithms!</p>
                <button class="ghost" id="signUp">Sign Up</button>
            </div>
        </div>
    </div>
</div>
<script src="/js/jquery-3.5.1.min.js"></script>
<script src="/js/api.js"></script>
<script src="/js/login-register.js"></script>
