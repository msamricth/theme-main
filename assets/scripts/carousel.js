function get_slider() {
    function getSplideOptions(slider) {
        let slidrGap = slider.hasAttribute('data-gap') ? slider.getAttribute('data-gap') : '40px';
        let slidrDrag = slider.hasAttribute('data-drag') ? slider.getAttribute('data-drag') : null;
        let slidrPerMove = slider.hasAttribute('data-per_move') ? slider.getAttribute('data-per_move') : null;
        let ifCustomHeight = slider.hasAttribute('data-custom_height');
        let ifSameHeight = slider.hasAttribute('data-same-height');
        let s320 = slider.hasAttribute('data-s320') ? slider.getAttribute('data-s320') : null;
        let s768 = slider.hasAttribute('data-s768') ? slider.getAttribute('data-s768') : null;
        let s1024 = slider.hasAttribute('data-s1024') ? slider.getAttribute('data-s1024') : null;
        let s1290 = slider.hasAttribute('data-s1290') ? slider.getAttribute('data-s1290') : null;
        let s1440 = slider.hasAttribute('data-s1440') ? slider.getAttribute('data-s1440') : null;
        let s1920 = slider.hasAttribute('data-s1920') ? slider.getAttribute('data-s1920') : null;
        let s2400 = slider.hasAttribute('data-s2400') ? slider.getAttribute('data-s2400') : null;
        let slidrArrows = slider.hasAttribute('data-arrows') ? slider.getAttribute('data-arrows') : null;

        let slideOptions;
        let multipleSlides = slider.hasAttribute('data-multiple-slides') ? slider.getAttribute('data-multiple-slides') : false;

        if (slidrArrows == 'false') {
            slidrArrows = false;
        }
        //let multipleSlides = 'false'; // tempoary until we finish addressing the php bug
        if (multipleSlides == 'false') {
            slideOptions = {
                arrows: slidrArrows,
                pagination: false,
                drag: slidrDrag
            };
        } else {

            if (multipleSlides == 'true') {
                let slidrPerMoveDefault = 1;
                slidrPerMove = slidrPerMove ? slidrPerMove : slidrPerMoveDefault;

                //slidrGap = parseInt(slidrGap);

                var $largePaging = 3,
                    $mediumPaging = 2,
                    $smallPaging = 1,
                    sldrMaxHeight = 400;
                if (s320) { } else { s320 = $smallPaging; }
                if (s768) { } else { s768 = $mediumPaging; }
                if (s1024) { } else { s1024 = $mediumPaging; }
                if (s1290) { } else { s1290 = $mediumPaging; }
                if (s1440) { } else { s1440 = $mediumPaging; }
                if (s1920) { } else { s1920 = $largePaging; }
                if (s2400) { } else { s2400 = $largePaging; }
                var max = getMaxHeight('.splide__slide');
                document.body.style.setProperty('--theme-main-carousel-height', max + 'px');
                if (ifSameHeight) {
                    let smallHeight = '177px',
                        smallMediumHeight = '405px',
                        mediumHeight = '562px',
                        largeHeight = '705px';
                    if (ifCustomHeight) {
                        const CustomHeight = slider.getAttribute('data-custom_height');
                        document.body.style.setProperty('--theme-main-carousel-height', CustomHeight / 2 + 'px');
                        document.body.style.setProperty('--theme-main-carousel-maxheight', CustomHeight + 'px');
                        smallHeight = CustomHeight,
                            smallMediumHeight = CustomHeight,
                            mediumHeight = CustomHeight,
                            largeHeight = CustomHeight;
                    }

                    slideOptions = {
                        arrows: slidrArrows,
                        gap: slidrGap,
                        pagination: false,
                        drag: slidrDrag,
                        autoWidth: true,
                        mediaQuery: 'min',
                        breakpoints: {
                            1920: {
                               // padding: { left: 120, right: 120 },
                                fixedHeight: largeHeight,
                            },
                            1024: {
                                //padding: { left: 92, right: 92 },
                                fixedHeight: mediumHeight,
                            },
                            768: {
                                //padding: { left: 72, right: 76 },
                                fixedHeight: smallMediumHeight,
                            },
                            320: {
                                //padding: { left: 40, right: 77 },
                                fixedHeight: smallHeight,
                            }
                        }
                    };
                } else {
                    window.addEventListener('resize', function (event) {

                        var max = getMaxHeight('.splide__slide');
                        document.body.style.setProperty('--theme-main-carousel-height', max + 'px');
                    });

                    slideOptions = {
                        arrows: slidrArrows,
                        gap: slidrGap,
                        pagination: false,
                        perPage: 2,
                        drag: slidrDrag,
                        perMove: slidrPerMove,
                        mediaQuery: 'min',
                        breakpoints: {
                            2400: {
                                padding: { left: 156, right: 156 },
                                perPage: s2400,
                            },
                            1920: {
                                padding: { left: 156, right: 156 },
                                perPage: s1920,
                            },
                            1440: {
                                padding: { left: 120, right: 120 },
                                perPage: s1440,
                            },
                            1290: {
                                padding: { left: 104, right: 104 },
                                perPage: s1290,
                            },
                            1024: {
                                padding: { left: 92, right: 92 },
                                perPage: s1024,
                                autoWidth: false
                            },
                            868: {
                                autoWidth: true
                            },
                            768: {
                                padding: { left: 72, right: 76 },
                                perPage: s768,
                                autoWidth: false
                            },
                            420: {
                                autoWidth: true
                            },
                            320: {
                                padding: { left: 38, right: 77 },
                                perPage: s320,
                            },
                            0: {
                                padding: { left: 38, right: 77 },
                                perPage: $smallPaging

                            }
                        }
                    };
                }
            }
        }

        return slideOptions;
    }



    function getMaxHeight(className) {
        var max = 0;
        document.querySelectorAll(className).forEach(
            function (el) {
                if (el.scrollHeight > max) {
                    max = el.scrollHeight;
                }
            }
        );

        return max;
    }


    function splider(splideBlock) {
        var sliderID = splideBlock.id;
        var slider = document.getElementById(sliderID);

        var splideOptions = getSplideOptions(slider);
        var sliderID = '#' + sliderID;

        document.addEventListener('DOMContentLoaded', function () {
            var splide = new Splide(sliderID, splideOptions);
            disableSlideJsPagination(sliderID)
            // Other initialization code

            splide.mount();

            splide.on('moved', function () {
                var activeSlide = splide.Components.Elements.slides[splide.index];

                if (activeSlide) {
                    if (slider.classList.contains('is-in-view')) {
                        var classList = Array.from(activeSlide.classList);
                        var backgroundColorClass = classList.find(function (className) {
                            // return className.startsWith('has-') && className.endsWith('-background-color');
                        });

                        var textColorClass = classList.find(function (className) {
                            return className.startsWith('has-') && className.endsWith('-color');
                        });
                        textColorClass = textColorClass ? textColorClass.replace(/^has-|-color$/g, '') : null;
                        if (textColorClass) {
                            header.style.setProperty('--theme-main-nav-link-color', 'var(--bs-' + textColorClass + ')');
                            header.style.setProperty('--theme-main-navDdropdown-color', 'var(--bs-' + textColorClass + ')');
                            slider.style.setProperty('--theme-main-arrow-color', 'var(--bs-' + textColorClass + ')');
                        }
                    }
                }
            });

        });
    }

    let splideBlocks = document.getElementsByClassName("splide");
    if (splideBlocks.length > 0) {
        for (var i = 0; i < splideBlocks.length; i++) {
            splider(splideBlocks[i]);
        }

        document.addEventListener("DOMContentLoaded", function () {
            var lazyVideos = document.querySelectorAll(".splide__slide  video.selfhosted.lazy");
            lazyVideos.forEach((element) => {
                loadVid(element);
            });
        });
    }
    function loadVid(video) {
        for (var source in video.children) {
            var videoSource = video.children[source];
            if (typeof videoSource.tagName === "string" && videoSource.tagName === "SOURCE") {
                videoSource.src = videoSource.dataset.src;
            }
        }

        video.load();
        video.classList.remove("lazy");
    }
    function disableSlideJsPagination(sliderId) {
        var slider = document.getElementById(sliderId);

        // Check if the slider element exists
        if (slider) {
            // Access the SlideJS API for the slider
            var api = slider.slidejs;

            // Check if the API is available
            if (api) {
                // Disable pagination by setting it to an empty function
                api.option('paginationCallback', function () { });

                // Remove the existing pagination HTML
                var paginationElement = slider.querySelector('.slidejs-pagination');
                if (paginationElement) {
                    paginationElement.parentNode.removeChild(paginationElement);
                }
            }
        }
    }

}

get_slider();
export { get_slider }