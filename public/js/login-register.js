const signUpButton = document.getElementById('signUp');
const signInButton = document.getElementById('signIn');
const container = document.getElementById('container');
const autoCompleteHack = document.getElementsByTagName('input');

const registerForm = $('#register-form');
const loginForm = $('#login-form');
const registerButton = $('#register');
const loginButton = $('#login');
const regSuccessSpan = $('#register-success-span');
const regSuccessSubSpan = $('#register-success-subspan');

function register() {
    const passwordConfirm = $('#r-password-confirm');
    const registerErrorSpan = $('#register-error');
    const elements = {
        username: $('#r-username'),
        password: $('#r-password'),
        email: $('#r-email'),
    }
    if (elements.password.val() !== passwordConfirm.val()) {
        registerErrorSpan.html("Passwords must match!")
        return;
    }

    post('/register', {
        username: elements.username.val(),
        password: elements.password.val(),
        email: elements.email.val(),
    }, () => {
        registerSuccessFadeout();
    }, (response) => {
        registerErrorSpan.html(JSON.parse(response).reason);
    });
}

function registerSuccessFadeout() {
    registerForm.fadeOut();
    loginForm.fadeOut();
    setTimeout(() => {
        regSuccessSpan.fadeIn();
        regSuccessSubSpan.fadeIn();
        setTimeout(() => {
            window.location.reload();
        }, 3500);

    }, 500);
}

    function login() {

    }

    setTimeout(() => {
        for (let field of autoCompleteHack) {
            field.value = "";
        }
    }, 800);

    signUpButton.addEventListener('click', () => {
    container.classList.add("right-panel-active");
});

signInButton.addEventListener('click', () => {
    container.classList.remove("right-panel-active");
});

registerButton.on('click', register);

tsParticles.load("particles", {
    fps_limit: 60,
    background: {
        color: "#d1d1d1"
    },
    interactivity: {
        detect_on: "canvas",
        events: {
            ondiv: {
                enable: true,
                elementId: "login",
                mode: "bubble",
                type: "rectangle"
            },
            resize: true
        },
        modes: {
            bubble: {
                distance: 400,
                duration: 2,
                opacity: 0.8,
                size: 5,
                speed: 3,
                color: ["#ff0000", "#ff7700", "2fdae0"]
            }
        }
    },
    particles: {
        color: {
            value: ["#6d6d6d", "#929292", "494949"]
        },
        links: {
            color: "random",
            distance: 150,
            enable: true,
            opacity: 0.4,
            width: 1
        },
        move: {
            collisions: true,
            direction: "none",
            enable: true,
            out_mode: "bounce",
            random: false,
            speed: 5,
            straight: false
        },
        number: { density: { enable: true, value_area: 800 }, value: 160 },
        opacity: {
            animation: { enable: true, minimumValue: 0.1, speed: 1, sync: false },
            random: true,
            value: 0.1
        },
        shape: {
            type: "square"
        },
        size: {
            animation: {
                enable: true,
                minimumValue: 2,
                speed: 1,
                sync: false
            },
            random: {
                enable: true,
                minimumValue: 2
            },
            value: 4
        }
    },
    retina_detect: true
});
