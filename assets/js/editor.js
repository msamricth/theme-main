//import '../scripts/theme';
import { editorFold } from '../scripts/thefold/src/wordpress.editor.js'; //not the actual wordpress.editor and doesnt pull anything from @wordpress in the event of debugging.
//import './scripts/navbar';
//import './scripts/posts';
//import { get_slider } from '../scripts/carousel.js';
import { get_wordfumbler } from '../textAnimation.js';
import { get_stats } from '../scripts/content.js';
import { forms } from '../scripts/forms.js';
//import { editorStuff } from '../scripts/editor.js'



import '../scripts/final';

document.addEventListener('DOMContentLoaded', function () {
    //editorStuff();
    setTimeout(
        function () {
            editorFold();
            forms();
            //get_slider();
            get_wordfumbler();
            get_stats();
            setTimeout(
                function () {
                    const headerImageButton = document.querySelector('#open-feat-img-module');
                    // featuredImageButtonContainer = document.querySelector('.editor-post-featured-image__container');
                    // featuredImageButton = featuredImageButtonContainer.querySelector('.components-button.editor-post-featured-image__toggle');
                    //document.querySelector('.editor-post-featured-image__container button.components-button.editor-post-featured-image__toggle').click()
                    if (headerImageButton) {
                        headerImageButton.addEventListener('click', function (e) {
                            // wp.media.featuredImage.frame().open();
                            wp.media.editor.open('featured-image');
                        });
                    }
                }, 9000);


        }, 1000);
});

acf.addFilter('acfe/fields/button/data/name=set_featured_image', function (data, $el) {
    const headerImageButton = document.querySelector('#open-feat-img-module');
    // featuredImageButtonContainer = document.querySelector('.editor-post-featured-image__container');
    // featuredImageButton = featuredImageButtonContainer.querySelector('.components-button.editor-post-featured-image__toggle');
    //document.querySelector('.editor-post-featured-image__container button.components-button.editor-post-featured-image__toggle').click()
    if (headerImageButton) {
        headerImageButton.addEventListener('click', function (e) {
            // wp.media.featuredImage.frame().open();
            wp.media.editor.open('featured-image');
            console.log('dice')
        });
    }

    // return
    console.log(data);
    return data;

});