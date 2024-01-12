import { Wrapper, scrollRoot, hasCustomBGColor } from "./identifiers.js";

// Custom BG and Type colors
function customBackgroundColorScheme(){
    if(hasCustomBGColor){
        const orginalBackgroundColor = Wrapper.getAttribute('data-bg');
        return orginalBackgroundColor;
    }
}
function customTypeColorScheme(){
    if(hasCustomBGColor){
        const orginalTextColor = Wrapper.getAttribute('data-color');
        if(orginalTextColor){ return orginalTextColor; }
    }
}
const OGbg = customBackgroundColorScheme(); 
const OGtxt = customTypeColorScheme();

function scrollActionsSettingFunction(){
    var scrollActionsSetting;
    if (!scrollRoot.hasAttribute("scroll-actions")) {
        // data attribute doesn't exist
        scrollActionsSetting = 'onEnter onEnterBack';
    } else {
        scrollActionsSetting = scrollRoot.getAttribute('scroll-actions');
    }
    return scrollActionsSetting;
}
const scrollActions = scrollActionsSettingFunction();


//Target area of window viewport for fold trigger

function topTargetArea(){
    var topTargetAreaSetting;
    if (!scrollRoot.hasAttribute("data-topta")) {
        // data attribute doesn't exist
        topTargetAreaSetting = 'top 35%';
    } else {
        topTargetAreaSetting = 'top ' + scrollRoot.getAttribute('data-topta');
    } 
    return topTargetAreaSetting; 
}

function bottomTargetArea(){
    var bottomTargetAreaSetting;
    if (!scrollRoot.hasAttribute("data-bottomta")) {
        // data attribute doesn't exist
        bottomTargetAreaSetting = 'bottom 35%';
    } else {
        bottomTargetAreaSetting = 'bottom ' + scrollRoot.getAttribute('data-bottomta');
    }
        
    return bottomTargetAreaSetting; 
}

const topTA = topTargetArea();
const bottomTA = bottomTargetArea();


//If fold is set to custom
function isCustomFold(){
    var isCustomFoldOn;
    if(scrollRoot.hasAttribute("data-custom")) {
        isCustomFoldOn = true;
    }
    return isCustomFoldOn;
}

const customOn = isCustomFold();






//if(nav_compression) {
    /* 
    
const showAnim = gsap.from('#header.navbar', { 
   y: -150,
   duration: 0.19
 }).progress(.19);
 
ScrollTrigger.create({
   start: "top top",
   end: 99999,
   onUpdate: (self) => {
     const scrollVelocity = self.getVelocity();
     if(scrollVelocity < -950) {
     self.direction === -1 ? showAnim.play() : showAnim.reverse();
     }
     if(self.progress < 0.25) {
       showAnim.play();
     }
     if(scrollVelocity > 100) {
       self.direction === -1 ? showAnim.play() : showAnim.reverse();
       }
   }
 }); */
//}





export{OGbg, OGtxt, topTA, bottomTA, customOn, scrollActions}