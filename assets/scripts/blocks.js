import * as bootstrap from 'bootstrap';


const popoverContent = document.querySelector('.theme-main-popover-content');
if (popoverContent) {
    document.addEventListener('click', function (event) {
        var isClickInsideCollapse = popoverContent.contains(event.target);
        var isClickInsideButton = event.target.closest('[data-toggle="collapse"]');
        if (!isClickInsideCollapse && !isClickInsideButton) {
            var collapse = document.querySelector('.theme-main-popover-content');
            if (collapse.classList.contains('show')) {
                var collapseInstance = new bootstrap.Collapse(collapse);
                collapseInstance.hide();
            }
        }
    });
}
function get_wordfumbler() {

    document.addEventListener("DOMContentLoaded", function () {
        const wordFumblers = document.querySelectorAll(".word-fumbler-first-version");
        if (wordFumblers) {

            let intervalTime = 900; // Change this value as needed

            wordFumblers.forEach((wordFumbler) => {


                let observer = new MutationObserver(function (mutations) {
                    mutations.forEach(function (mutation) {
                        if (mutation.attributeName == "class") {
                            var containerAnimated = mutation.target.classList.contains('animate');
                            if (containerAnimated) {
                                wordFumblerAnimation();
                                observer.disconnect();
                            }

                        }
                    });
                });


                if (wordFumbler.classList.contains('animation-on')) {
                    observer.observe(wordFumbler, {
                        attributes: true
                    });
                } else {
                    wordFumblerAnimation()
                }
                function wordFumblerAnimation() {
                    const listContainer = wordFumbler.querySelector(".box");
                    const listItems = listContainer.querySelectorAll("li");
                    let currentIndex = 0;

                    function updateVisibleClass() {

                        listItems[currentIndex].classList.add("animate");
                        // Remove "visible" class from the previous item
                        const prevIndex =
                            currentIndex === 0 ? listItems.length - 1 : currentIndex - 1;
                        listItems[prevIndex].classList.remove("animate");

                        currentIndex = (currentIndex + 1) % listItems.length;

                    }

                    // Set the interval (in milliseconds)

                    setInterval(updateVisibleClass, intervalTime);
                    // Initial setup
                    updateVisibleClass();
                }
            });

        }

    });
}

function get_wordfumblerVersion2() {

    document.addEventListener("DOMContentLoaded", function () {
        const wordFumblers = document.querySelectorAll(".word-fumbler-second-version");
        if (wordFumblers) {
            let intervalTime = 3200; // Change this value as needed


            wordFumblers.forEach((wordFumbler) => {
                let observer = new MutationObserver(function (mutations) {
                    mutations.forEach(function (mutation) {
                        if (mutation.attributeName == "class") {
                            var containerAnimated = mutation.target.classList.contains('animate');
                            if (containerAnimated) {
                                wordFumblerAnimation();
                                observer.disconnect();
                            }

                        }
                    });
                });


                if (wordFumbler.classList.contains('animation-on')) {
                    observer.observe(wordFumbler, {
                        attributes: true
                    });
                } else {
                    wordFumblerAnimation()
                }
                function wordFumblerAnimation() {
                    const listContainer = wordFumbler.querySelector(".box");
                    const listItems = listContainer.querySelectorAll("li");
                    let currentIndex = 0;

                    function updateVisibleClass() {
                        listItems[currentIndex].classList.add("animate");

                        const prevIndex = currentIndex === 0 ? listItems.length - 1 : currentIndex - 1;
                        listItems[prevIndex].classList.remove("animate");

                        currentIndex = (currentIndex + 1) % listItems.length;

                        // Add a delay before the next iteration
                        setTimeout(updateVisibleClass, intervalTime);
                    }

                    // Initial setup
                    updateVisibleClass();
                }
            });

        }

    });
}


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

get_wordfumblerVersion2();
get_wordfumbler();

let allCollapsibles = document.querySelectorAll('.collapse');

allCollapsibles.forEach(function (allCollapsible) {
    allCollapsible.addEventListener('hide.bs.collapse', event => {
        allCollapsible.classList.add('closing')
    });
    allCollapsible.addEventListener('hidden.bs.collapse', event => {

        setTimeout(() => {
            allCollapsible.classList.remove('closing');
        }, 300);

    });
});


export { get_wordfumbler, get_wordfumblerVersion2 }