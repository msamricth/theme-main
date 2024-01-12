import { debuglog } from "./identifiers.js";

function foldDebug(action, color, elemID = null, elemClassList = null, topTA = null, bottomTA = null , error = null, customBG = null, customText = null){
  if(debuglog){
        let handlerMessage = "The Fold (main) Var Dump:\n";
        if(error){handlerMessage = "** Fold ran into error.** \n"+"Error message posted below var dump. \n" + handlerMessage}
        if(elemID){
            handlerMessage = handlerMessage + ' - Element ID: '+elemID +"\n";
        }
        if(elemClassList){
            handlerMessage = handlerMessage + ' - Element ClassList: '+elemClassList + '\n';
        }
        if(color){
            handlerMessage = handlerMessage + " - Requested Color: "+ color + "\n";
        }
        handlerMessage = handlerMessage + " - Action/Event that made the request:"+ action +"\n";
        if(customBG){
            handlerMessage = handlerMessage + " - Custom BG Color: " + customBG;
            if(customText){
                handlerMessage = handlerMessage + " Custom Text Color: " + customText;
            }
            handlerMessage = handlerMessage + "\n";
        }
        if(topTA){
            handlerMessage = handlerMessage + " - Top Trigger Area: " + topTA +"\n";
        }
        if(bottomTA){
            handlerMessage = handlerMessage + " - Bottom Trigger Area: " + bottomTA;
        }
        if(error){
            handlerMessage = handlerMessage + "\n Error Message: " + error;
        }
        console.log(handlerMessage);
   }
}


function loadVideoErrorHandler(videoTitle, videoID, errorMessage=null, action=null, vaction=null, sTIIV=null, sTPIV=null) {
    if(debuglog){
        let handlerMessage = "Video Var Dump: ";
        if(errorMessage){
            handlerMessage = "** Video Framework ran into error.** \n"+"Error message posted below var dump. \n" + handlerMessage;
        }
        if(videoTitle) handlerMessage = handlerMessage + "Video Title: " + videoTitle + "\n - ";
         handlerMessage = handlerMessage+ "Video ID: "+videoID+'\n';

        if(vaction) handlerMessage = handlerMessage + ' - ' + vaction + '\n';
        if(action) handlerMessage = handlerMessage + ' - Action:' + action + '\n';
        if(sTIIV) handlerMessage = handlerMessage + ' - Is video in viewport:' + sTIIV + '\n';
        if(sTPIV) handlerMessage = handlerMessage + ' - video|scroll position:' + sTPIV + '\n';
        if(errorMessage) handlerMessage = handlerMessage + ' - Error Message:' + errorMessage;

        console.log(handlerMessage);
    }
}

export{ foldDebug, loadVideoErrorHandler }