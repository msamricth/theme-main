
import { Wrapper, bodyOG, sidebar} from "./identifiers.js";
import {OGbg} from "./utils.js";
import {checkFoldColor} from "./custom.js";

function clearchemes(){
	
	document.body.style.removeProperty('--supply-fold-color');
	document.body.style.removeProperty('--bgcustom');
	
	
	if(document.body.classList.contains('page-scheme-dark')){
		document.body.classList.remove('page-scheme-dark');
	}

	if(document.body.classList.contains('page-scheme-light')){
		document.body.classList.remove('page-scheme-light');
	}
	if(document.body.classList.contains('customScheme')){
		document.body.style.setProperty('--bgcustom', OGbg);
		checkFoldColor(OGbg);
	}
}


function playFoldAnimation(){
    Wrapper.classList = bodyOG + ' bg-header';
    let lottieInstance = document.querySelector('.lottiedottie'); 
    let lottieInstanceContainer = document.querySelector('.non-autoplay');
    if(lottieInstance){
        //lottieInstance.addEventListener("ready", () => { //doesnt seem to work
        lottieInstance.addEventListener("rendered", () => {
            lottieInstance.play();
            if(lottieInstanceContainer) lottieInstanceContainer.classList.add('show');
        });
        setTimeout(
            function() {
                if(lottieInstanceContainer && !lottieInstanceContainer.classList.contains('show')) lottieInstance.play(),lottieInstanceContainer.classList.add('show'),console.log("lottie is having a error on the fold load - timeout");
        }, 400);
        lottieInstance.addEventListener("error", (error) => {
          console.log("lottie is having a error on the fold load  "+error);
          if(lottieInstanceContainer) lottieInstance.play(),lottieInstanceContainer.classList.add('show');
        });
    }
}
function fadeintop(){
	if(sidebar.classList.contains('fadeOut')){
		sidebar.classList.remove('fadeOut');
	}
	sidebar.classList.add('fade-in-top');
}

function fadeOut(){
	if(sidebar.classList.contains('fade-in-top')){
		sidebar.classList.remove('fade-in-top');
	}
}

export{ clearchemes, playFoldAnimation, fadeintop, fadeOut }