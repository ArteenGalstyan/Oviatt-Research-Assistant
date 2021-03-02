
function changePassword() {
    const password = $('#password').val();
    const passwordConfirm = $('#password-confirm').val();

    if (password !== passwordConfirm) {
        alert('Passwords do not match');
        return;
    }
    post('/password/update', {new_password: password}, (res) => {
        alert('Successfully updated password');
        window.location.reload();
    }, () => {
        alert('Failed to update password');
    });
}
$('#save-button').click(() => {changePassword();})
