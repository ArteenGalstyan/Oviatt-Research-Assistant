<head>
    <link rel="stylesheet" href="{{asset('css/profile/profile.css')}}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body translate="no">
<div id="main">
    <div id="app" class="settings-toggled">
        <div class="button" id="settings-button"><i class="fas fa-cog"></i></div>
        <div id="app-logo"><i class="fas fa-rocket"></i></div>
        <div id="settings-panel">
            <div id="options">
                <div id="options-label">
                    <h1>USER SETTINGS</h1>
                </div>
                <div class="option" id="option-1">
                    <h1>Overview</h1>
                </div>
                <div class="option selected" id="option-2">
                    <h1>My Account</h1>
                </div>
            </div>
            <div id="details-view-wrapper">
                <div id="details-view">
                    <div id="details-view-label">
                        <h1>MY ACCOUNT</h1>
                    </div>
                    <div id="my-account-info-wrapper">
                        <div id="my-account-info">
                            <div id="profile-pic"></div>
                            <div id="account-fields">
                                <div class="account-field">
                                    <h1 class="label">USERNAME</h1>
                                    <input class="input" type="text" value="{{$username}}" disabled >
                                </div>
                                <div class="account-field">
                                    <h1 class="label">EMAIL</h1>
                                    <input class="input" type="text" value="{{$email}}" disabled>
                                </div>
                                <div class="account-field">
                                    <h1 class="label">NEW PASSWORD</h1>
                                    <input class="input password-change" type="password">
                                </div>
                                <div class="account-field">
                                    <h1 class="label">CONFIRM NEW PASSWORD</h1>
                                    <input class="input password-change" type="password">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="save-options">
                        <div class="save-option-button" id="cancel-button">
                            <h1>Cancel</h1>
                        </div>
                        <div class="save-option-button" id="save-button">
                            <h1>Save</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
<script>
const autoCompleteHack = document.getElementsByClassName('password-change');
// Disables autocomplete forcefully
setTimeout(() => {
        for (let field of autoCompleteHack) {
            field.value = "";
        }
    }, 800);
</script>

