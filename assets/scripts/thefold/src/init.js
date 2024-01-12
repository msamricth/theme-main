
import { Wrapper, bodyOG, scrollRoot, hasCustomBGColor } from "./identifiers.js";
import {customOn} from "./utils.js";
import { customFold } from "./custom.js";

function initCustom(theme){
    if(customOn){
        if(theme != 'bg-custom') {
            Wrapper.style.removeProperty('--supply-fold-color');
            Wrapper.style.removeProperty('--bgcustom');
        } else {
            if(bodyOG != 'bg-custom ') {
                Wrapper.style.removeProperty('--supply-fold-color');
                Wrapper.style.removeProperty('--bgcustom');
            }
        }
    }
}

function init() {
    if(hasCustomBGColor){
        if(bodyOG == 'bg-custom ') {customFold()};
    }
}

export{ init, initCustom };