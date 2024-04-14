
import { Wrapper, bodyOG, header, isHeaderNavTransLight, isHeaderNavTransDark, navOG, isHeaderNavTransprimary } from "./identifiers.js";
// import {OGbg, OGtxt, topTA, bottomTA, customOn} from "./utils.js";
import { clearchemes, playFoldAnimation } from "./extras.js";
import { initCustom } from "./init.js";
import { foldDebug } from "./console.js";
var scrollActions, foldColor, foldBG;;


function setFoldLegacy(theme) {
	let scheme = navOG;
	let bgScheme = navOG;
	switch (theme) {
		case 'bg-header':
			clearchemes();
			Wrapper.classList = bodyOG + ' bg-header';


			bgScheme = scheme;
			if (isHeaderNavTransprimary) {
				bgScheme = 'var(--theme-main-translucent)';
				scheme = 'primary';
			}
			if (isHeaderNavTransLight) {
				bgScheme = 'transparent';
				scheme = 'light';
			}
			if (isHeaderNavTransDark) {
				bgScheme = 'var(--bs-border-color-translucent)';
				scheme = 'dark';
			}
			setNavBG(bgScheme);
			setNavcolor(scheme);
			setNavDrawal(scheme);
			break;
		case 'bg-play-animation':
			playFoldAnimation();
			break;
		case 'bg-footer':
			Wrapper.classList = 'bg-dark';
			break;
		case 'header':
			Wrapper.classList = bodyOG + ' bg-header';
			scheme = navOG;
			bgScheme = scheme;

			if (isHeaderNavTransprimary) {
				bgScheme = 'var(--theme-main-translucent)';
				scheme = 'primary';
			}
			if (isHeaderNavTransLight) {
				bgScheme = 'transparent';
				scheme = 'light';
			}
			if (isHeaderNavTransDark) {
				bgScheme = 'var(--bs-border-color-translucent)';
				scheme = 'dark';
			}
			setNavBG(bgScheme);
			setNavcolor(scheme);
			setNavDrawal(scheme);
			break;
		case 'undefined':
			Wrapper.classList = bodyOG;
			console.log('No trigger detected');
			break;
		case 'bg-pattern':
			if (Wrapper.classList.contains(theme)) {
				if (Wrapper.classList.contains('bg-header')) {
					Wrapper.classList = 'bg-light';
					setTimeout(
						function () {
							Wrapper.classList = 'bg-light ' + theme;
						}, 400);
				}
			} else {
				Wrapper.classList = 'bg-light';
				setTimeout(
					function () {
						Wrapper.classList = 'bg-light ' + theme;
					}, 600);
			}
			break;
		//case 'bg-custom':
		//foldSwitch(theme, bg, txt, foldBG = null, foldColor = null);
		//break;
		default:
			Wrapper.classList = theme;
			scheme = theme.replace('bg-', '');

			setNavBG(scheme)
			setNavcolor(scheme);
			setNavDrawal(scheme);

	}
	if (theme == null) {
		Wrapper.classList = bodyOG;
		scheme = bodyOG.replace('bg-', '');

		setNavBG(scheme)
		setNavcolor(scheme);
		setNavDrawal(scheme);
	}
}
function matchNav(elem) {
	let elemClasses = elem.classList,
		headerBG, headerColor;

	elemClasses.forEach((elemClass, i) => {

		if (elemClass.includes('match_')) {
			headerBG = elemClass.replace('match_', '');
			setNavBG(headerBG)
			Wrapper.classList = headerBG + '-color-scheme ' + bodyOG;
			if (headerColor) { } else {
				setNavcolor(headerBG);
			}
			setNavBG(headerBG)

			setNavDrawal(headerBG);
		}

		if (elemClass.includes('colorMatch_')) {
			headerColor = elemClass.replace('colorMatch_', '');
			header.style.setProperty('--theme-main-nav-link-color', 'var(--bs-' + headerColor + ')');
			header.style.setProperty('--theme-main-navDdropdown-color', 'var(--bs-' + headerColor + ')');
		}
	})

}
function setNavBGVar(headerBG) {
	header.style.setProperty('--theme-main-nav-bg', headerBG);
	header.style.setProperty('--theme-main-nav-dropdown-bg', headerBG);
	setTimeout(() => {
		const navBgColor = getComputedStyle(header).getPropertyValue('--theme-main-nav-bg');
		const isLight = isColorLight(navBgColor);

		if (isLight) {

			if (header.classList.contains('dark-scheme')) {
				header.classList.remove('dark-scheme');
			}
			header.classList.add('light-scheme');
		} else {
			if (header.classList.contains('light-scheme')) {
				header.classList.remove('light-scheme');
			}
			header.classList.add('dark-scheme');
		}
	}, 800);
}

function setNavBG(headerBG) {
	if (headerBG.includes('transparent')) {
		setNavBGVar('transparent');
	} else if (headerBG.includes('var')) {
		setNavBGVar(headerBG);
	} else {
		setNavBGVar('var(--bs-' + headerBG + ')');
	}

}
function setNavcolor(headerColor) {
	header.style.setProperty('--theme-main-nav-link-color', 'var(--theme-main-contrasting-text-' + headerColor + ')');
	header.style.setProperty('--theme-main-navDdropdown-color', 'var(--theme-main-contrasting-text-' + headerColor + ')');
}
function setNavDrawal(scheme) {
	//header.style.setProperty('--theme-main-nav-drawer-open-color', 'var(--theme-main-contrasting-text-' + scheme + ')');
	header.style.setProperty('--theme-main-nav-drawer-open-bg', 'var(--bs-' + scheme + ')');
	header.style.setProperty('--theme-main-nav-drawer-open-color', 'var(--theme-main-contrasting-text-' + scheme + ')');
}
function animationOn(elem) {
	if (elem.classList.contains('animate')) {

	} else {
		elem.classList.add('animate');
	}

	setTimeout(
		function () {
			elem.classList.remove('animation-on');
		}, 600);

}
function isColorLight(hexColor) {
	// Convert hex to RGB
	const r = parseInt(hexColor.slice(1, 3), 16);
	const g = parseInt(hexColor.slice(3, 5), 16);
	const b = parseInt(hexColor.slice(5, 7), 16);

	// Calculate luminance
	const luminance = (0.299 * r + 0.587 * g + 0.114 * b) / 255;

	// Choose a threshold (0.5 is commonly used) and return true if light, false if dark
	return luminance > 0.5;
}
function isElemInView(elem, ScrollAction) {
	let elemID = elem.id;

	if (ScrollAction) {
		switch (ScrollAction) {
			case 'onEnter':
				elem.classList.add('is-in-view'), elemInView(elemID);
				break;
			case 'onEnterBack':
				elem.classList.add('is-in-view'), elemInView(elemID);
				break;
			case 'onLeave':
				elem.classList.remove('is-in-view');
				elemOutView(elemID);
				break;
			case 'onLeaveBack':
				elem.classList.remove('is-in-view');
				elemOutView(elemID);
				break;
			//case 'bg-custom':
			//foldSwitch(theme, bg, txt, foldBG = null, foldColor = null);
			//break;
			default:
		}
	}

	function elemInView(elemID) {
		if (elemID) {
			document.body.classList.add(elemID + '-inView')
		}
	}
	function elemOutView(elemID) {
		if (elemID) {
			document.body.classList.add(elemID + '-leavingView');
			document.body.classList.remove(elemID + '-inView');
			setTimeout(
				function () {
					document.body.classList.remove(elemID + '-leavingView');
				},
				1000);
		}
	}
}
export { matchNav, animationOn, setFoldLegacy, isElemInView };