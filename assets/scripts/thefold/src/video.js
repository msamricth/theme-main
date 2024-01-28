import { lazy_load_videos, lazy_loaded_video, $videoI, vimeoPlaceholder } from "./identifiers.js";
import { loadVideoErrorHandler } from "./console.js";
import { foldRefresh } from "./gsap.js";
//import videojs from 'video.js/dist/alt/video.core.novtt.js';
var action, vaction, sTIIV, sTPIV;
function LazyLoad() {
    return new Promise(function (resolve, reject) {
        document.addEventListener("DOMContentLoaded", function () {
            var lazyVideos = [].slice.call(document.querySelectorAll("video.selfhosted.lazy"));

            if ("IntersectionObserver" in window) {
                var lazyVideoObserver = new IntersectionObserver(function (entries, observer) {
                    entries.forEach(function (video) {
                        if (video.isIntersecting) {
                            for (var source in video.target.children) {
                                var videoSource = video.target.children[source];
                                if (typeof videoSource.tagName === "string" && videoSource.tagName === "SOURCE") {
                                    videoSource.src = videoSource.dataset.src;

                                    loadVideo(video.target).then(() => {
                                        video.target.classList.remove("lazy");
                                        lazyVideoObserver.unobserve(video.target);
                                    }).catch(error => {
                                        loadVideoErrorHandler('Video with error', video.id, error, 'PlayVideo', `Error playing video for ${videoSource.src}: ${error.message}`, sTIIV, sTPIV);
                                    });
                                }
                            }
                        }
                    });
                    resolve(); // Resolve the promise once lazy loading is complete
                });

                lazyVideos.forEach(function (lazyVideo) {
                    lazyVideoObserver.observe(lazyVideo);
                });
            } else {
                resolve(); // Resolve the promise if IntersectionObserver is not supported
            }
        });
    });
}

function loadVideo(video, videoTitle, videoID, sTIIV, sTPIV) {
    return new Promise(function (resolve, reject) {
        video.load();

        video.addEventListener('canplaythrough', function onCanPlayThrough() {
            video.play().then(() => {
                resolve();
                video.removeEventListener('canplaythrough', onCanPlayThrough);
            }).catch(error => {
                loadVideoErrorHandler(videoTitle, videoID, error, 'PlayVideo', `Error playing video for ${video.currentSrc}: ${error.message}`, sTIIV, sTPIV);
                reject(error);
            });
        });

        video.addEventListener('error', function onError(event) {
            if (event.target.error && event.target.error.code === 4) {
                // Media decode error
                loadVideoErrorHandler(videoTitle, videoID, event.target.error, 'LoadVideo', `Video decode error for ${event.target.currentSrc}: ${event.target.error.message}`, sTIIV, sTPIV);
            } else {
                // Other loading errors
                loadVideoErrorHandler(videoTitle, videoID, event, 'LoadVideo', `Error loading video for ${event.target.currentSrc}: ${event.message}`, sTIIV, sTPIV);
                reject(event);
            }
        });
    });
}




function videoInit() {
    LazyLoad();
}


function fetchAndPlay(video) {
    let videoURL;

    for (var source in video.children) {
        let videoSource = video.children[source];
        if (typeof videoSource.tagName === "string" && videoSource.tagName === "SOURCE") {
            videoURL = videoSource.dataset.src;
        }
    }
    function loadVideo(src) {
        return new Promise(function (resolve, reject) {
            let videoSource;
            for (var source in video.children) {
                videoSource = video.children[source];
                if (typeof videoSource.tagName === "string" && videoSource.tagName === "SOURCE") {
                    //videoURL = videoSource.dataset.src;
                }
            }

            videoSource.src = src;
            video.load();

            video.oncanplaythrough = () => {
                resolve(video);
            };

            video.onerror = (error) => {
                reject(new Error(`Video load error for ${src}: ${error.message}`));
                loadVideoErrorHandler('Video with error', video.id, error, 'loadVideo', `Video load error for ${src}: ${error.message}`, sTIIV, sTPIV);
            };
        });
    }

    let promise = loadVideo(videoURL);

    promise.then(
        video => {
            if (video.classList.contains('error')) {
                video.classList.remove('error');
            }
            video.classList.remove("lazy");
            if (video.classList.contains('paused')) {
                video.classList.remove('paused');
            }
            video.classList.add('playing');
        },
        error => {
            loadVideoErrorHandler('Video with error', video.id, error, 'loadVideo', `Video load error for ${src}: ${error.message}`, sTIIV, sTPIV);

        }
    );




}

function updateVideo() {
    //const isVideoInView =  ScrollTrigger.isInViewport(video);
    if (isVideoInView == 'true') {
        playVimeo();
    } else {
        pauseVimeo();
    }
    loadVideoErrorHandler(videoTitle, sTIIV, sTPIV, videoID);
}
function playVimeo(player, video, videoTitle, videoID, sTIIV = null, sTPIV = null) {
    var isPlaying = player.currentTime > 0 && !player.paused && !player.ended && player.readyState > player.HAVE_CURRENT_DATA;
    if (video.classList.contains('loaded')) {
        if (vimeoPlaceholder) {
            let hidePlaceholder = vimeoPlaceholder.classList + ' d-none';
            vimeoPlaceholder.classList = hidePlaceholder;
        }
        if (!isPlaying) {
            var playPromise = player.play();
            if (playPromise !== undefined) {
                if (!isPlaying) {
                    playPromise.then(_ => {
                        if (video.classList.contains('error')) {
                            video.classList.remove('error');
                        }
                    })
                        .catch(error => {
                            video.classList.add('error');
                            loadVideoErrorHandler(videoTitle, videoID, error, 'playPromise (Previously played)', 'loaded with error', sTIIV, sTPIV);

                        });
                }
            }
        }
    } else {
        var playPromise = player.play();
        if (playPromise !== undefined) {
            if (!isPlaying) {
                playPromise.then(_ => {
                    if (video.classList.contains('error')) {
                        video.classList.remove('error');
                    }
                })
                    .catch(error => {
                        video.classList.add('error');
                        loadVideoErrorHandler(videoTitle, videoID, error, 'playPromise', 'loaded with error', sTIIV, sTPIV);
                    });
            }
        }
        video.classList.add('loaded');
        foldRefresh();
    }
}
function playVideo(player, video, videoTitle, videoID, sTIIV = null, sTPIV = null) {
    // Show loading animation.
    var playPromise = video.play();
    if (video.classList.contains('paused')) {
        if (playPromise !== undefined) {
            playPromise.then(_ => {
                if (video.classList.contains('error')) {
                    video.classList.remove('error');
                }
                video.classList.remove('paused');
                video.classList.add('playing');
            })
                .catch(error => {
                    video.classList.add('error');
                    loadVideoErrorHandler(videoTitle, videoID, error, 'playPromise (Previously played)', 'loaded with error', sTIIV, sTPIV);
                });
        }
    }
}








function pauseVimeo(player, video) {
    var isPlaying = player.currentTime > 0 && !player.paused && !player.ended && player.readyState > player.HAVE_CURRENT_DATA;
    var hasPlayed = player.currentTime > 0;
    if ($videoI != 0) {
        if (isPlaying) {
            player.pause();
        } else {
            if (hasPlayed) {
                player.pause();
            } else {
                if (video.classList.contains('loaded')) {
                    player.pause();
                }
            }
        }
    }
}

function pauseVideo(player, video, videoTitle, videoID, sTIIV = null, sTPIV = null) {

    var playPromise = video.play();

    if (video.classList.contains('playing')) {
        if (playPromise !== undefined) {
            playPromise.then(_ => {
                // Automatic playback started!
                // Show playing UI.
                // We can now safely pause video...

                video.classList.add('paused');
                video.classList.remove('playing');
                video.pause();
            })
                .catch(error => {
                    video.classList.add('error');
                    loadVideoErrorHandler(videoTitle, videoID, error, 'playPromise (Previously played)', 'loaded with error', sTIIV, sTPIV);

                });
        }
    }
    var isPlaying = player.currentTime > 0 && !player.paused && !player.ended && player.readyState > player.HAVE_CURRENT_DATA;
    var hasPlayed = player.currentTime > 0;
    if ($videoI != 0) {
        if (isPlaying) {
            player.pause();
        } else {
            if (hasPlayed) {
                player.pause();
            } else {
                if (video.classList.contains('loaded')) {
                    player.pause();
                }
            }
        }
    }
}


export { videoInit, updateVideo, playVimeo, pauseVimeo, playVideo, pauseVideo, LazyLoad }