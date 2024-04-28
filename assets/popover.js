import * as bootstrap from 'bootstrap';


const popoverContent = document.querySelector('.theme-main-popover-content');
if (popoverContent) {
    document.addEventListener('click', function (event) {
        var isClickInsideCollapse = popoverContent.contains(event.target);
        var isClickInsideButton = event.target.closest('[data-toggle="collapse"]');
        if (!isClickInsideCollapse && !isClickInsideButton) {
            var collapse = document.querySelector('.theme-main-popover-content');
            if (collapse.classList.contains('show')) {
                var collapseInstance = new bootstrap.Collapse(collapse);
                collapseInstance.hide();
            }
        }
    });
}

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