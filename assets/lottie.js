let lottieInstance = document.querySelector('.lottiedottie');
if (lottieInstance) {
    lottieInstance.addEventListener("ready", () => {
        // if Supply ever goes the direction for multiple animations on a page unmute the muted lines and mute the next line

        //lottieHeight();

    });
}
//window.onresize = lottieHeight; 
function lottieHeight() {
    let lottieInstanceHeight = lottieInstance.offsetHeight + 28 + 'px';

    let lottie_master_container = lottieInstance.closest('.lottie-master-container');
    lottie_master_container.style.height = lottieInstanceHeight;
}

