/**
 * --------------------------------------------------------------------------
 * The fold index.js
 * --------------------------------------------------------------------------
 */

import { init } from "./src/init.js";
import { theFoldScrollTrigger, videoScrollTrigger, foldRefresh } from "./src/gsap.js";
import { videoInit } from "./src/video.js"; 

function theFold() {
	theFoldScrollTrigger();
}

//videoInit();
init();
theFold();
window.onresize = foldRefresh();
export { theFold };