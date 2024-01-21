import { lazy_load_videos, lazy_loaded_video, $videoI, vimeoPlaceholder} from "./identifiers.js";
import { loadVideoErrorHandler } from "./console.js"; 
import { foldRefresh } from "./gsap.js";
//import videojs from 'video.js/dist/alt/video.core.novtt.js';
var action, vaction, sTIIV, sTPIV;
function LazyLoad() {
      document.addEventListener("DOMContentLoaded", function() {
		var lazyVideos = [].slice.call(document.querySelectorAll("video.selfhosted.lazy"));
	  
		if ("IntersectionObserver" in window) {
		  var lazyVideoObserver = new IntersectionObserver(function(entries, observer) {
			entries.forEach(function(video) {
			  if (video.isIntersecting) {
				for (var source in video.target.children) {
				  var videoSource = video.target.children[source];
				  if (typeof videoSource.tagName === "string" && videoSource.tagName === "SOURCE") {
					videoSource.src = videoSource.dataset.src;
				  }
				}
	  
				video.target.load();
				video.target.classList.remove("lazy");
				lazyVideoObserver.unobserve(video.target);
			  }
			});
		  });
	  
		  lazyVideos.forEach(function(lazyVideo) {
			lazyVideoObserver.observe(lazyVideo);
		  });
		}
	  });

}





function videoInit(){
    LazyLoad();
}


function fetchAndPlay(video){
    let videoURL;

    for (var source in video.children) {
        let videoSource = video.children[source];
        if (typeof videoSource.tagName === "string" && videoSource.tagName === "SOURCE") {
            videoURL = videoSource.dataset.src;
        }
    }
    function loadVideo(src) {
        return new Promise(function(resolve, reject) {
            let videoSource;
            for (var source in video.children) {
                videoSource = video.children[source];
                if (typeof videoSource.tagName === "string" && videoSource.tagName === "SOURCE") {
                    //videoURL = videoSource.dataset.src;
                    
                }
            }
            videoSource.src = src;
            video.onload = () => {resolve(video);
                video.load();
             }
            video.onerror = () => reject(new Error(`video load error for ${src}`));
      
         // document.head.append(script);
         
        });
    }
    let promise = loadVideo(videoURL);

    promise.then(
        video => {
            if(video.classList.contains('error')){
                video.classList.remove('error');
            }
            video.classList.remove("lazy");
            if(video.classList.contains('paused')){
                video.classList.remove('paused');
            }
            video.classList.add('playing');
        },
        error => console.log(`Error: ${error.message}`)
    );
    



}

function updateVideo() {
    //const isVideoInView =  ScrollTrigger.isInViewport(video);
    if(isVideoInView == 'true') {
        playVimeo();
    } else {
        pauseVimeo();
    }
    loadVideoErrorHandler(videoTitle, sTIIV, sTPIV,videoID);
}
function playVimeo(player, video, videoTitle, videoID, sTIIV = null, sTPIV = null){
    var isPlaying = player.currentTime > 0 && !player.paused && !player.ended && player.readyState > player.HAVE_CURRENT_DATA;
    if(video.classList.contains('loaded')){
        if(vimeoPlaceholder){
            let hidePlaceholder = vimeoPlaceholder.classList + ' d-none';
            vimeoPlaceholder.classList = hidePlaceholder;
        }
        if (!isPlaying) {
            var playPromise = player.play();
            if (playPromise !== undefined) {
                if (!isPlaying) {
                    playPromise.then(_ => {
                        if(video.classList.contains('error')){
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
                    if(video.classList.contains('error')){
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
function playVideo(player, video, videoTitle, videoID, sTIIV = null, sTPIV = null){
      // Show loading animation.
  var playPromise = video.play();
  if(video.classList.contains('paused')){
        if (playPromise !== undefined) {
            playPromise.then(_ => {
                if(video.classList.contains('error')){
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
function pauseVimeo(player, video){
    var isPlaying = player.currentTime > 0 && !player.paused && !player.ended && player.readyState > player.HAVE_CURRENT_DATA;
    var hasPlayed = player.currentTime > 0;
    if ($videoI != 0 ) { 
        if (isPlaying) {
            player.pause();
        } else {
            if (hasPlayed) {
                player.pause();
            } else {
                if(video.classList.contains('loaded')){
                    player.pause();
                }
            }
        }
    }
}

function pauseVideo(player, video, videoTitle, videoID, sTIIV = null, sTPIV = null){

    var playPromise = video.play();
 
    if(video.classList.contains('playing')){
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
    if ($videoI != 0 ) { 
        if (isPlaying) {
            player.pause();
        } else {
            if (hasPlayed) {
                player.pause();
            } else {
                if(video.classList.contains('loaded')){
                    player.pause();
                }
            }
        }
    }
}


export{ videoInit, updateVideo, playVimeo, pauseVimeo, playVideo, pauseVideo }