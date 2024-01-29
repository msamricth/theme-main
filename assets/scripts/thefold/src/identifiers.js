const articleInteriorPage = document.querySelector(".blog-posts");
const sidebar = document.querySelector(".sidbar-meta");
const vimeoPlaceholder = document.querySelector(".vimeo-placeholder");
const foldON = document.body.classList.contains('fold_on');
const Wrapper = document.getElementById('wrapper');
const bodyOG  = Wrapper.dataset.og_class;
const dotsON = document.body.classList.contains('dots_on');
const lazy_load_videos = document.body.classList.contains('lazy_load_videos');
const lazy_loaded_video = document.querySelectorAll("video.selfhosted.lazy")
const caseStudy = document.body.classList.contains('single-case-studies');
const header = document.getElementById('header');
const navOG = header.dataset.ogScheme;
const navbarNav = header.querySelector('.navbar-nav');
const sections = [...document.querySelectorAll('.fold')];
const selfhosted = document.body.classList.contains('dots_on');
const scrollRoot = document.querySelector('[data-scroller]')
const headerLinks = [...document.querySelectorAll('[data-link]')]
const debuglog = scrollRoot.hasAttribute("debuglog");
const hasCustomTxtColor = Wrapper.hasAttribute("data-color");
const hasCustomBGColor = Wrapper.hasAttribute("data-bg");
const nav_compression = document.body.classList.contains('nav_compression');
const debugMarker = scrollRoot.hasAttribute("debugmarker");
const videoMarker = scrollRoot.hasAttribute("videoMarker");
const isHeaderNavTransDark  = document.body.classList.contains('nav-bg-transparent-dark');
const isHeaderNavTransLight  = document.body.classList.contains('nav-bg-transparent-light');
let $videoI = 0;
const videos = document.querySelectorAll(".videofx.vimeo");
export { articleInteriorPage, sidebar, foldON, Wrapper, bodyOG, dotsON, lazy_load_videos, caseStudy, header, sections, selfhosted, scrollRoot, headerLinks, debuglog, hasCustomTxtColor, hasCustomBGColor, nav_compression, debugMarker, videoMarker, lazy_loaded_video, $videoI, videos, navbarNav, isHeaderNavTransLight, isHeaderNavTransDark, vimeoPlaceholder, navOG };