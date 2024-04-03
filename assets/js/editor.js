import '../scripts/theme';
import { editorFold } from '../scripts/thefold/src/wordpress.editor.js'; //not the actual wordpress.editor and doesnt pull anything from @wordpress in the event of debugging.
//import './scripts/navbar';
//import './scripts/posts';
import { get_slider } from '../scripts/carousel.js';
import { get_wordfumbler } from '../scripts/blocks';
import { get_stats } from '../scripts/content.js';
import { forms } from '../scripts/forms.js';
//import { editorStuff } from '../scripts/editor.js'



import '../scripts/final';

document.addEventListener('DOMContentLoaded', function () {
    editorStuff();
    setTimeout(
        function () {
            editorFold();
            forms();
            get_slider();
            get_wordfumbler();
            get_stats();
        }, 1000);
});