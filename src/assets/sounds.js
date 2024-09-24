const silence = new Howl({
    src: ['assets/static/sounds/silence.mp3']
});

function playSilence() {
    silence.play();
}