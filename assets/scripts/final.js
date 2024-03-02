let headerBlock = document.querySelector('.header-block'), headerBlockAnimations;
if (headerBlock) {
    headerBlockAnimations = headerBlock.querySelectorAll('.animation-on');
}

setTimeout(() => {
    if (headerBlockAnimations) {
        headerBlockAnimations.forEach(function (headerBlockAnimation) {
            if (headerBlockAnimation.classList.contains('animate')) {

            } else {
                headerBlockAnimation.classList.add('animate');
            }
        });
    }

    document.body.classList.add('page-loaded');
}, 800);