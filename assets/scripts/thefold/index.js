/**
 * --------------------------------------------------------------------------
 * The fold index.js
 * --------------------------------------------------------------------------
 */

import { theFoldScrollTrigger, foldRefresh } from "./src/gsap.js";
import { init } from "./src/init.js";


function theFold() {
	theFoldScrollTrigger();
	foldRefresh();

}


init();
window.onresize = foldRefresh();
export { theFold };