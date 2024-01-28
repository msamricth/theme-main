const scrollRoot = document.querySelector('[data-scroller]');
const nav_compression = document.body.classList.contains('nav_compression');
let lastScrollTop = 0;
let newScroll;
const main = document.querySelector('main');
const navbarMain = document.getElementById('header');
const navcontainer = document.getElementById('nav-header');
const navbarToggler = document.querySelector('.navbar-toggler');
const navbarCollapse = document.querySelector('.navbar-collapse');
const dropdownLinks = navbarCollapse.querySelectorAll('.dropdown-menu');
const dropdownToggles = navbarCollapse.querySelectorAll('.dropdown-toggle');

document.addEventListener('DOMContentLoaded', function () {
    if (nav_compression) {
        const navbarMainHeight = navbarMain.clientHeight;

        window.addEventListener('scroll', function () {
            const scrollTop = window.scrollY || document.documentElement.scrollTop;

            // Close any open dropdowns in navbarMain
            const openDropdowns = navbarMain.querySelectorAll('.show');
            openDropdowns.forEach(dropdown => dropdown.classList.remove('show'));
            navbarCollapse.classList.remove('subnav-open');
            navbarToggler.classList.remove('is-active');

            if (scrollTop < 250) {
                navbarMain.style.top = '0';
            } else {
                if (scrollTop > lastScrollTop) {
                    navbarMain.style.top = `-${navbarMainHeight}px`;
                    newScroll = scrollTop - 2;
                } else {
                    navbarMain.style.top = '0';
                    newScroll = scrollTop + 2;
                }
            }

            lastScrollTop = newScroll;
        });
    }

    function hideNav() {
        navcontainer.classList.remove("is-visible");
    }

    function showNav() {
        navcontainer.classList.remove("is-hidden");
    }

    navbarCollapse.addEventListener('show.bs.collapse', event => {
        setTimeout(() => {
            navbarToggler.classList.add('is-active');
            navbarMain.classList.add('mobile-nav-open');
        }, 100);
    });

    navbarCollapse.addEventListener('hide.bs.collapse', event => {
        setTimeout(() => {
            navbarToggler.classList.remove('is-active');
            navbarMain.classList.remove('mobile-nav-open');
            if (navbarCollapse.classList.contains('subnav-open')) {
                navbarCollapse.classList.remove('subnav-open');
            }
        }, 100);
    });

    dropdownToggles.forEach(dropdownToggle => {
        const dropdownMenu = dropdownToggle.nextElementSibling;

        if (dropdownMenu && dropdownMenu.matches('.dropdown-menu')) {
            const exitBTNCTR = dropdownMenu.querySelector('.close-nav-dropdown-li');
            const exitBTN = exitBTNCTR.querySelector('.close-nav-dropdown');

            exitBTN.addEventListener('click', event => {
                dropdownToggle.classList.remove('show');
                dropdownMenu.classList.remove('show');
                navbarCollapse.classList.remove('subnav-open');
                event.preventDefault();
            });
        }

        dropdownToggle.addEventListener('show.bs.dropdown', event => {
            navbarCollapse.classList.add('subnav-open');
        });

        dropdownToggle.addEventListener('hide.bs.dropdown', event => {
            navbarCollapse.classList.add('subnav-closing');
            setTimeout(() => {
                navbarCollapse.classList.remove('subnav-open');
            }, 300);
        });

        dropdownToggle.addEventListener('hidden.bs.dropdown', event => {
            navbarCollapse.classList.remove('subnav-closing');
            setTimeout(() => {
                navbarCollapse.classList.remove('subnav-closing');
            }, 100);
        });
    });
});
