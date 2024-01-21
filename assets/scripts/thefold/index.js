/**
 * --------------------------------------------------------------------------
 * The fold index.js
 * --------------------------------------------------------------------------
 */

import { theFoldScrollTrigger, videoScrollTrigger, foldRefresh } from "./src/gsap.js";
import { videoInit } from "./src/video.js"; 

function theFold() {
	theFoldScrollTrigger();
}
videoInit();
//init();
theFold();

videoScrollTrigger();
window.onresize = foldRefresh();
export { theFold };