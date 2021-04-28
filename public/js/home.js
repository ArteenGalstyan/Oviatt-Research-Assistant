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

function mobileMenuOpen() {
    document.getElementById("gmDropdown").classList.toggle("show");
}
