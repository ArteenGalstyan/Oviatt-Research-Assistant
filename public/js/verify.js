const title = $('#title');
const text = $('#text');
const icon = $('#icon');
const queries = new URLSearchParams(new URL(window.location.href).search);


// Make the API call to verify email with the given params from the verification link
setTimeout(() => {

    if (!(queries.has('email') && queries.has('token'))) {
        failed();
        return;
    }

    post('/verify_email', {
        email: queries.get('email'),
        token: queries.get('token'),
    }, () => {
        success();
    }, (response) => {
        failed(response);
    })

}, 800);

// Visual function for showing user verification has succeeded
function success() {

    title.html("Success!");
    icon.removeClass('fa-spinner');
    icon.removeClass('rotate');
    icon.addClass('fa-check');

    text.html("Email was successfully verified!");

    setTimeout(() => {
        window.location.href = window.location.origin;
    }, 2000);
}

// Visual function for showing user verification has failed
function failed(reason = null) {
    title.html("Failed!");

    icon.removeClass('fa-spinner');
    icon.removeClass('rotate');
    icon.addClass('fa-exclamation');

    text.html(
        reason ? JSON.parse(reason).reason
        : "Invalid email or token supplied"
    );

    setTimeout(() => {
        window.location.href = window.location.origin;
    }, 2000);
}
