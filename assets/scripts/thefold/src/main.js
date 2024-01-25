
import { Wrapper, bodyOG, scrollRoot, hasCustomBGColor, header, navbarNav, isHeaderNavTransLight, isHeaderNavTransDark, navOG } from "./identifiers.js";
// import {OGbg, OGtxt, topTA, bottomTA, customOn} from "./utils.js";
import { clearchemes, playFoldAnimation } from "./extras.js";
import { initCustom } from "./init.js";
import { foldDebug } from "./console.js";
var scrollActions, foldColor, foldBG;;


function setFoldLegacy(theme) {

	switch (theme) {
		case 'bg-header':
			clearchemes();
			Wrapper.classList = bodyOG + ' bg-header';

			let scheme = navOG;
			let bgScheme = scheme;
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
	
	header.style.setProperty('--theme-main-navDdropdown-bg', headerBG);
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

export { matchNav, animationOn, setFoldLegacy };