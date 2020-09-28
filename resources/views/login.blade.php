<link rel="stylesheet" href="/css/login.css">
<div id="particles"></div>
<script async="" defer="" src="https://buttons.github.io/buttons.js"></script>
<script src="https://cdn.jsdelivr.net/npm/tsparticles@1.17.0-beta.7/dist/tsparticles.min.js"></script>

<div class="container" id="container">
    <div class="form-container sign-up-container">
        <form action="#">
            <h1>Create Account</h1>
            <input type="text" autocomplete="" placeholder="Username" />
            <input type="email" autocomplete="" placeholder="Email" />
            <input type="password" autocomplete="" placeholder="Password" />
            <input type="password-confirm" autocomplete="" placeholder="Confirm Password" />
            <button>Sign Up</button>
        </form>
    </div>
    <div class="form-container sign-in-container">
        <form action="#">
            <h1>Sign in</h1>
            <div class="social-container">
            </div>
            <input type="email" placeholder="Email" />
            <input type="password" placeholder="Password" />
            <a href="#">Forgot your password?</a>
            <button>Sign In</button>
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
<script src="/js/login.js"></script>
