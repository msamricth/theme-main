import gsap from "gsap";
import ScrollTrigger from "gsap/ScrollTrigger";
import Flip from "gsap/Flip";
import { articleInteriorPage, scrollRoot, debugMarker, debuglog, videoMarker, pinElement, pinEnd, pinTrigger } from "./identifiers.js";
import { topTA, bottomTA } from "./utils.js";
import { foldDebug, loadVideoErrorHandler } from "./console.js";
import { playVimeo, pauseVimeo, playVideo, pauseVideo, LazyLoad } from "./video.js";
import { matchNav, animationOn, setFoldLegacy, isElemInView } from "./main.js";
gsap.registerPlugin(ScrollTrigger);

function videoScrollTriggerFunction(video, player, videoTitle, videoID = null, sTIIV = null, sTPIV = null, vimeoFrame = null) {


}

function scrollingCarousel() {
    let scrollingCarouselHeader = document.querySelector("#logo-carousel-header");


    let cont = document.querySelector(".scroll-slider-container");
    gsap.to(".scroll-slide", {
        ease: "none",
        x: () => -(cont.scrollWidth - window.innerWidth),
        scrollTrigger: {
            trigger: cont,
            pin: cont,
            start: "center center",
            end: () => "+=" + (cont.scrollWidth - window.innerWidth),
            scrub: true,
            invalidateOnRefresh: true,
            onLeave: () => {
                if (scrollingCarouselHeader) {
                    scrollingCarouselHeader.classList.add("fadeTopOut");
                }
            },
            onEnterBack: () => {
                if (scrollingCarouselHeader) {

                    scrollingCarouselHeader.classList.remove("fadeTopOut");
                }
            }
        }
    });
}



function vimeoGSAP() {
    let videoIndex = 0;

    gsap.utils.toArray(".videofx.vimeo").forEach(function (video, i) {
        const vimeoFrame = document.getElementById(video.id);
        const player = vimeoFrame;
        const videoTitle = video.getAttribute('data-videotitle');
        const videoID = video.id;
        var sTIIV = ScrollTrigger.isInViewport(video),
            sTPIV = ScrollTrigger.positionInViewport(video, "center").toFixed(2);

        // Check if player is an HTMLMediaElement
        if (player instanceof HTMLMediaElement) {
            var playPromise = player.play();

            if (playPromise !== undefined) {
                playPromise.then(_ => {
                    if (videoIndex != 0) {
                        player.pause();
                    } else {
                        video.loading = 'eager';
                    }
                    ScrollTrigger.create({
                        trigger: video,
                        start: 'top 100%',
                        end: 'bottom 15%',
                        markers: videoMarker,
                        onEnter: () => (
                            playVimeo(player, video, videoTitle, videoID, sTIIV, sTPIV),
                            loadVideoErrorHandler(videoTitle, videoID, '', 'play', 'onEnter', sTIIV, sTPIV)
                        ),
                        onLeave: () => (pauseVimeo(player, video), loadVideoErrorHandler(videoTitle, videoID, '', 'Pause', 'onLeave', sTIIV, sTPIV)),
                        onLeaveBack: () => (pauseVimeo(player, video), loadVideoErrorHandler(videoTitle, videoID, '', 'Pause', 'onLeaveBack', sTIIV, sTPIV)),
                        onEnterBack: () => (playVimeo(player, video, videoTitle, videoID, sTIIV, sTPIV), loadVideoErrorHandler(videoTitle, videoID, '', 'Play', 'onEnterBack', sTIIV, sTPIV)),
                        //onUpdate: updateVideo()
                    });
                })
                    .catch(error => {
                        // Auto-play was prevented
                        // Show paused UI.
                        video.classList.add('error');
                        loadVideoErrorHandler(videoTitle, videoID, error, 'player.pause', 'Paused with error', sTIIV, sTPIV);
                    });
            }
        }

        videoIndex++;
    });
}



function selfHostedGSAP() {
    // LazyLoad().then(() => {
    gsap.utils.toArray(".videofx.selfhosted").forEach(function (video, i) {
        const vimeoFrame = document.getElementById(video.id);
        const videoID = video.id;
        const player = video;
        const videoTitle = video.getAttribute('data-videotitle');
        var sTIIV = ScrollTrigger.isInViewport(video),
            sTPIV = ScrollTrigger.positionInViewport(video, "center").toFixed(2);
        ScrollTrigger.create({
            trigger: video,
            start: 'top 100%',
            end: 'bottom 15%',
            markers: videoMarker,
            onEnter: () => (
                playVideo(player, video, videoTitle, videoID, sTIIV, sTPIV), //player, video <- code debt
                loadVideoErrorHandler(videoTitle, videoID, '', 'play', 'onEnter', sTIIV, sTPIV, video)
            ),
            onLeave: () => (
                pauseVideo(player, video, videoTitle, videoID, sTIIV, sTPIV),
                loadVideoErrorHandler(videoTitle, videoID, '', 'Pause', 'onLeave', sTIIV, sTPIV, video)
            ),
            onLeaveBack: () => (
                pauseVideo(player, video, videoTitle, videoID, sTIIV, sTPIV),
                loadVideoErrorHandler(videoTitle, videoID, '', 'Pause', 'onLeaveBack', sTIIV, sTPIV, video)
            ),
            onEnterBack: () => (
                playVideo(player, video, videoTitle, videoID, sTIIV, sTPIV),
                loadVideoErrorHandler(videoTitle, videoID, '', 'Play', 'onEnterBack', sTIIV, sTPIV, video)
            ),
            //onUpdate: updateVideo()
        });
    });
    //  });
}
function videoScrollTrigger() {
    vimeoGSAP();
    selfHostedGSAP();
}

function experimental() {
    gsap.registerPlugin(Flip) 
    const grid = document.querySelector(".image-cloud");
    const items = gsap.utils.toArray(".image-cloud--item");
    
    function shuffleImages() {
      // Get the state
      const state = Flip.getState(items);
    
      // Do the actual shuffling
      for (let i = items.length; i >= 0; i--) {
        grid.appendChild(grid.children[(Math.random() * i) | 0]);
      }
    
      // Animate the change
      Flip.from(state, {
        absolute: true,
        scale: true,
        fade: true
      });
    }
    function randomInterval(min, max) {
      return Math.floor(Math.random() * (max - min + 1) + min);
    }
    function delayedShuffle() {
      setTimeout(() => {
        shuffleImages(); // Shuffle images
        delayedShuffle(); // Repeat the shuffle
      }, randomInterval(2000, 8000)); // Adjust the interval range as needed (from 5 to 10 seconds in this example)
    }
    
    // Initial shuffle
    shuffleImages();
    
    // Start the delayed shuffle
    delayedShuffle();
    
}
function theFoldScrollTrigger() {
    if (document.querySelector(".image-cloud")) {
        experimental();
    }
    if (!scrollRoot.hasAttribute("data-fold-reset")) {
        gsap.utils.toArray(".fold").forEach(function (elem) {

            var color = elem.getAttribute('data-class'),
                elemClassList = elem.classList,
                elemID = elem.id,
                bg, txt, error;
            if (color) { } else {
                error = 'Fold was called but No Color Schme was detected, this could be intentional or caused by an inproperly set fold';
            }

            ScrollTrigger.create({
                trigger: elem,
                start: topTA,
                end: bottomTA,
                markers: debugMarker,
                onEnter: () => foldTriggered('onEnter'),
                onLeave: () => foldTriggered('onLeave'),
                onLeaveBack: () => foldTriggered('onLeaveBack'),
                onEnterBack: () => foldTriggered('onEnterBack')
            });

            function foldTriggered(scrollAction) {
                setFold(elem, color, scrollAction);
                //foldDebug(scrollAction, color, elemID, elemClassList, topTA, bottomTA, error, bg, txt);
            }

        });


    } else {

    }

    gsap.utils.toArray(".animation-on").forEach(function (elem) {

        var color = elem.getAttribute('data-class');

        ScrollTrigger.create({
            trigger: elem,
            start: 'top 65%',
            end: 'bottom 35%',
            markers: debugMarker,
            onEnter: () => animationOn(elem)
        });
    });
    function setFold(elem, color = null, scrollAction = null) {
        let elemClassList = elem.classList;

        elem.getAttribute('data-class')
        if (elemClassList.contains('match-nav')) {
            matchNav(elem);
        }
        if (elem.hasAttribute('data-class')) {
            setFoldLegacy(color);
        }

        if (elemClassList.contains('view-type')) {
            isElemInView(elem, scrollAction);
        }

    }
    ScrollTrigger.refresh();
}
function foldRefresh() {

    ScrollTrigger.refresh();
    setTimeout(
        function () {
            ScrollTrigger.refresh();
        }, 1200);
}


export { theFoldScrollTrigger, foldRefresh, videoScrollTrigger, scrollingCarousel }