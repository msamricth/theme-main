
const scrollRoot = document.querySelector('[data-scroller]');
const nav_compression = document.body.classList.contains('nav_compression');
var lastScrollTop = 0; // This Varibale will store the top position
var newScroll;
const main = document.querySelector('main');
navbarMain = document.getElementById('header'); // Get The NavBar
navcontainer = document.getElementById('nav-header');
navbarToggler = document.querySelector('.navbar-toggler');
navbarCollapse = document.querySelector('.navbar-collapse');
if (nav_compression) {

    window.addEventListener('scroll', function () {
        //on every scroll this funtion will be called

        var scrollTop = window.scrollY || document.documentElement.scrollTop;
        //This line will get the location on scroll

        //This line will get the location on scroll
        if (scrollTop < 250) {


            navbarMain.style.top = '0';

        } else {
            // if (scrollTop > 0 && scrollTop < main.innerHeight - window.innerHeight) {
            if (scrollTop > lastScrollTop) { //if it will be greater than the previous
                navbarMain.style.top = '-120px';
                //set the value to the negetive of height of navbar 
                newScroll = scrollTop - 2; //  - added the '- 2' as a work around since sometimes small scrolls aren't recored
            }

            else {
                navbarMain.style.top = '0';
                newScroll = scrollTop + 2;
            }
        }
        lastScrollTop = newScroll; //New Position Stored
    });
}
function hideNav() {
    navcontainer.classList.remove("is-visible");
    // navcontainer.classList.add("is-hidden");
}

function showNav() {
    navcontainer.classList.remove("is-hidden");
    //navcontainer.classList.add("is-visible", "scrolling");
}

navbarCollapse.addEventListener('show.bs.collapse', event => {
    setTimeout(
        function () {
            navbarToggler.classList.add('is-active');
        }, 100);
});


navbarCollapse.addEventListener('hide.bs.collapse', event => {
    setTimeout(
        function () {
            navbarToggler.classList.remove('is-active');
        }, 100);
})
