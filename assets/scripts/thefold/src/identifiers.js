const articleInteriorPage = document.querySelector(".blog-posts");
const sidebar = document.querySelector(".sidbar-meta");
const vimeoPlaceholder = document.querySelector(".vimeo-placeholder");
const foldON = document.body.classList.contains('fold_on');
const Wrapper = document.getElementById('wrapper');
let bodyOG;
if(Wrapper){
  bodyOG  = Wrapper.dataset.og_class;
} else {
  bodyOG  = 'bg-light';
}
const dotsON = document.body.classList.contains('dots_on');
const lazy_load_videos = document.body.classList.contains('lazy_load_videos');
const lazy_loaded_video = document.querySelectorAll("video.selfhosted.lazy")
const caseStudy = document.body.classList.contains('single-case-studies');
const header = document.getElementById('header');
const panelsSection = document.querySelector(".scroll-slider"),
  panelsContainer = document.querySelector(".scroll-slider-container");
const navOG = header ? header.dataset.ogScheme : 'bg-primary';
const navbarNav =  header ? header.querySelector('.navbar-nav') : null;
const sections = [...document.querySelectorAll('.fold')];
const selfhosted = document.body.classList.contains('dots_on');
const scrollRoot = document.querySelector('[data-scroller]');
const headerLinks = [...document.querySelectorAll('[data-link]')];
const debuglog = scrollRoot ? scrollRoot.hasAttribute("debuglog") : true;
const hasCustomTxtColor = Wrapper ? Wrapper.hasAttribute("data-color") : false;
const hasCustomBGColor = Wrapper ? Wrapper.hasAttribute("data-bg") : false;
const nav_compression = document.body.classList.contains('nav_compression');
const debugMarker = scrollRoot ? scrollRoot.hasAttribute("debugmarker") : false;
const videoMarker = scrollRoot ? scrollRoot.hasAttribute("videoMarker") : false;
const isHeaderNavTransDark  = document.body.classList.contains('nav-bg-transparent-dark');
const isHeaderNavTransLight  = document.body.classList.contains('nav-bg-transparent-light');
const isHeaderNavTransprimary  = document.body.classList.contains('nav-bg-transparent-primary');
let $videoI = 0;
const pinElement = document.querySelector(".pin-this");
const pinEnd = document.querySelector(".pin-end");
const pinTrigger = document.querySelector(".pin-trigger");
const videos = document.querySelectorAll(".videofx.vimeo");
export { articleInteriorPage, sidebar, foldON, Wrapper, bodyOG, dotsON, lazy_load_videos, caseStudy, header, sections, selfhosted, scrollRoot, headerLinks, debuglog, hasCustomTxtColor, hasCustomBGColor, nav_compression, debugMarker, videoMarker, lazy_loaded_video, $videoI, videos, navbarNav, isHeaderNavTransLight, isHeaderNavTransDark, vimeoPlaceholder, navOG, panelsSection, panelsContainer, isHeaderNavTransprimary, pinElement, pinEnd, pinTrigger };