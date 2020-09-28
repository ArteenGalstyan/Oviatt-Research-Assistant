const title = $('#title');
const text = $('#text');
const icon = $('#icon');
const queries = new URLSearchParams(new URL(window.location.href).search);

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

function success() {

    title.html("Success!");
    icon.removeClass('fa-spinner');
    icon.removeClass('rotate');
    icon.addClass('fa-check');

    text.html("Email was successfully verified!");
}

function failed(reason = null) {
    title.html("Failed!");

    icon.removeClass('fa-spinner');
    icon.removeClass('rotate');
    icon.addClass('fa-exclamation');

    text.html(
        reason ? JSON.parse(reason).reason
        : "Invalid email or token supplied"
    );
}
