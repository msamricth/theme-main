function ISiOS() {
	return [
		'iPad Simulator',
		'iPhone Simulator',
		'iPod Simulator',
		'iPad',
		'iPhone',
		'iPod'
	].includes(navigator.platform)
		// iPad on iOS 13 detection
		|| (navigator.userAgent.includes("Mac") && "ontouchend" in document)
}
var ua = navigator.userAgent || navigator.vendor || window.opera;
var isInstagram = (ua.indexOf('Instagram') > -1) ? true : false;

var iOS = !!ua.match(/iPad/i) || !!ua.match(/iPhone/i);
var webkit = !!ua.match(/WebKit/i);
var iOSSafari = iOS && webkit && !ua.match(/CriOS/i);


var isSafari = (ua.indexOf('Safari') > -1) ? true : false;
if (document.documentElement.classList) {
	if (isInstagram) {
		window.document.body.classList.add('instagram-browser');
		// alert("debugging within the Instagram in-app browser");
	}
	if (isSafari) {
		window.document.body.classList.add('Safari');
		// alert("debugging within the Instagram in-app browser");
	} else if (iOSSafari) {
		window.document.body.classList.add('Safari');
	}
	if (ISiOS()) {
		window.document.body.classList.add('ios');
	}
}