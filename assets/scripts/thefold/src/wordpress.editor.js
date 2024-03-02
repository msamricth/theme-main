import { loadVideoErrorHandler } from "./console.js";

function editorFold() {

    let theFolds = document.querySelectorAll('.animation-on'),
        theSelfHostedVideos = document.querySelectorAll('.videofx.selfhosted'),
        theVimeoVideos = document.querySelectorAll(".videofx.vimeo"),
        sTIIV = 'in the editor scroll trigger is disabled',
        sTPIV = 'in the editor scroll trigger is disabled',
        videoIndex = 0;
    theFolds.forEach(function (theFold) {
        theFold.classList.add('animate');
        setTimeout(
            function () {
                theFold.classList.remove('animation-on');
            }, 600);

    });

    theSelfHostedVideos.forEach(function (video, i) {
        const vimeoFrame = document.getElementById(video.id);
        const videoID = video.id;
        const player = video;
        const videoTitle = video.getAttribute('data-videotitle');
        playVideo(player, video, videoTitle, videoID, sTIIV, sTPIV);
        loadVideoErrorHandler(videoTitle, videoID, '', 'play', 'onEnter', sTIIV, sTPIV);
    });

    theVimeoVideos.forEach(function (video, i) {
        const vimeoFrame = document.getElementById(video.id);
        const player = vimeoFrame;
        const videoTitle = video.getAttribute('data-videotitle');
        const videoID = video.id;

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
                    playVimeo(player, video, videoTitle, videoID, sTIIV, sTPIV),
                        loadVideoErrorHandler(videoTitle, videoID, '', 'play', 'onEnter', sTIIV, sTPIV)
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
    video.muted = true;
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


export { editorFold }