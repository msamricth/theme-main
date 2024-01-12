import { Wrapper, bodyOG, hasCustomTxtColor } from "./identifiers.js";
import {OGbg, OGtxt, customOn} from "./utils.js";

function customFold(foldBG = null, foldColor = null){
	
	if(foldBG){
		if(foldBG == 'undefined'){
			ogFold();
		} else {
			document.body.style.setProperty('--bgcustom', foldBG);
			
			if(foldBG){
				if(foldColor == null){
					checkFoldColor(foldBG);
				} else {
					document.body.style.setProperty('--supply-fold-color', foldColor);
				}
			} else {checkFoldColor(foldBG);}
		}

	} else {
		ogFold()
	}
	function ogFold(){
		var ogBGColor;
		if (OGbg.indexOf("#") > -1){ 
			ogBGColor = OGbg;
		} else {
			ogBGColor = '#'+OGbg;
		}
		Wrapper.classList = bodyOG + ' bg-header';
		if(hasCustomTxtColor){
			if (OGtxt.indexOf("#") > -1){ 
				OGtxt = OGtxt;
			} else {
				OGtxt = '#' + OGtxt;
			}
			document.body.style.setProperty('--supply-fold-color', OGtxt);
		} else {
			checkFoldColor(OGbg);
		}
		document.body.style.setProperty('--bgcustom', ogBGColor);
	}
}

// checks custom fold type colors - soon to be sunlighted due to PHP fold template upgrades(but may come if we go headless)
function checkFoldColor(color){
	var r, g, b, hsp;
	if (color.match(/^rgb/)) {
	  color = color.match(/^rgba?\((\d+),\s*(\d+),\s*(\d+)(?:,\s*(\d+(?:\.\d+)?))?\)$/);
  
	  r = color[1];
	  g = color[2];
	  b = color[3];
	} 
	else {
		color = +("0x" + color.slice(1).replace( 
			color.length < 5 && /./g, '$&$&'
		)
		);
	  r = color >> 16;
	  g = color >> 8 & 255;
	  b = color & 255;
	}
	hsp = Math.sqrt(
	  0.299 * (r * r) +
	  0.587 * (g * g) +
	  0.114 * (b * b)
	);
	if (hsp>127.5) {
		document.body.style.setProperty('--supply-fold-color', '#111512');
		if(document.body.classList.contains('page-scheme-dark')){
			document.body.classList.remove('page-scheme-dark');
		}
		document.body.classList.add('page-scheme-light');

	} 
	else {
		document.body.style.setProperty('--supply-fold-color', '#fff');
		if(document.body.classList.contains('page-scheme-light')){
			document.body.classList.remove('page-scheme-light');
		}
		document.body.classList.add('page-scheme-dark');
	}
}

function foldSwitch(theme, bg = null, txt = null, foldBG = null, foldColor = null){
    if(customOn){
        Wrapper.classList = theme;
        var foldColorPreChck;
        if(txt != 'default'){
            foldColorPreChck = txt;
        } 
        const foldBGPrecheck = bg;
        if(foldColorPreChck){
            if (foldColorPreChck.indexOf("#") > -1){ 
                foldColor = foldColorPreChck;
            } else {
                foldColor = '#'+foldColorPreChck;
            }
        }
        if(foldBGPrecheck){
            if (foldBGPrecheck.indexOf("#") > -1){ 
                foldBG = foldBGPrecheck;
            } else {
                foldBG = '#'+foldBGPrecheck;
            }
        }
        customFold(foldBG, foldColor);
    }
}
export { customFold, checkFoldColor, foldSwitch};