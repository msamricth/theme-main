
import { Wrapper, bodyOG, panelsSection} from "./identifiers.js";
import { theFoldScrollTrigger, videoScrollTrigger, scrollingCarousel } from "./gsap.js";
import { videoInit } from "./media.js"; 


function init() {
    if(panelsSection){scrollingCarousel();}
	theFoldScrollTrigger();
    videoInit();
    videoScrollTrigger();
}

export{ init };
