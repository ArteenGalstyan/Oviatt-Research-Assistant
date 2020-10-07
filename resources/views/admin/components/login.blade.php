<section class="panel important">
    <h2>Please Login</h2>
    <div class="onethird">
    <form>
        @csrf
            <label>Username:</label>
            <input id="username" type="text" placeholder="Enter Username" name="username" required>
            <label>Password:</label>
            <input id="password" type="password" placeholder="Enter Password" name="password" required>
            <span id="error-span"></span>
    </form>
        <button id="submit" onclick="adminLogin()"/>Submit</button>
    </div>
</section>
<script>
    function adminLogin() {
       post('login', {
           username: $('#username').val(),
           password: $('#password').val(),
       }, () => {window.location = "/admin"}, (response) => {
           $('#error-span').html(JSON.parse(response).reason)
       } );
    }
</script>




