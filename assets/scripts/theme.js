// Webpack Imports
import * as bootstrap from 'bootstrap';

(function () {
	'use strict';

	// Focus input if Searchform is empty
	[].forEach.call(document.querySelectorAll('.search-form'), (el) => {
		el.addEventListener('submit', function (e) {
			var search = el.querySelector('input');
			if (search.value.length < 1) {
				e.preventDefault();
				search.focus();
			}
		});
	});

	// Initialize Popovers: https://getbootstrap.com/docs/5.0/components/popovers
	var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
	var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
		return new bootstrap.Popover(popoverTriggerEl, {
			trigger: 'focus',
		});
	});
})();

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
if (document.documentElement.classList ){
	if (isInstagram) {
		window.document.body.classList.add('instagram-browser');
    // alert("debugging within the Instagram in-app browser");
	}
	if (isSafari) {
		window.document.body.classList.add('Safari');
    // alert("debugging within the Instagram in-app browser");
	} else if(iOSSafari){
		window.document.body.classList.add('Safari');
	}
	if(ISiOS()){
		window.document.body.classList.add('ios');
	}
}