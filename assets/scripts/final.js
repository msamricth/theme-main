//import { lazyloadImages } from './thefold/src/media.js';
let headerBlock = document.querySelector('.header-block'), headerBlockAnimations;
if (headerBlock) {
    headerBlockAnimations = headerBlock.querySelectorAll('.animation-on');
}
const lazyImages = document.querySelectorAll('.lazyLoad-image');
function lazyLoadImages(activeSlide) {
    var lazyImages = activeSlide.querySelectorAll('.lazyLoad-image');
    if (lazyImages) {
        lazyImages.forEach(function (image) {
            image.src = image.getAttribute('data-src');
            image.classList.remove('lazyLoad-image');
        });
    }
}

// Create a new intersection observer
const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
        // Check if the body has the "page-loaded" class
        if (entry.isIntersecting && entry.target.classList.contains('page-loaded')) {
            // Body has the "page-loaded" class, do something
            if (headerBlockAnimations) {
                headerBlockAnimations.forEach(function (headerBlockAnimation) {
                    if (headerBlockAnimation.classList.contains('animate')) {
                    } else {
                        headerBlockAnimation.classList.add('animate');
                    }
                });
            }
            lazyLoadImages(document);
            observer.disconnect();
        }
    });
});

// Start observing the body element
observer.observe(document.body);


document.addEventListener('DOMContentLoaded', function () {
    setTimeout(() => {
        document.body.classList.add('page-loaded');
    }, 800);
});