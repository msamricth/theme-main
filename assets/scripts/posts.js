import { theFold } from './thefold/index';

document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.filter-field').forEach(function (element) {
        element.addEventListener('change', function () {
            console.log('Filter field change event triggered');
            var category_id = this.value;
            var xhr = new XMLHttpRequest();
            var postId = element.getAttribute('data-post-id');
            xhr.open('POST', ajax_object.ajax_url);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function () {
                if (xhr.status === 200) {
                    console.log('Filter field AJAX response:', xhr.responseText);
                    document.getElementById('archive-posts-container').innerHTML = xhr.responseText;
                    theFold();
                } else {
                    console.log('Request failed. Returned status of ' + xhr.status);
                }
            };
            console.log('Filter field AJAX data:', 'action=theme_main_filter_posts&category_id=' + category_id);
            xhr.send('action=theme_main_filter_posts&category_id=' + category_id + '&post_id=' + postId);

        });
    });
    
    
    
    // Check if required elements exist
    var loadMoreButton = document.getElementById('load-more');
    var postsContainer = document.getElementById('posts-container');

    if (loadMoreButton && postsContainer) {
        var page = 2; // Initial page number

        // Load more posts on button click
        loadMoreButton.addEventListener('click', function () {
            console.log('Load more button click event triggered');
            var xhr = new XMLHttpRequest();
            var data = new FormData();
            data.append('action', 'load_more_posts');
            data.append('page', page);

            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    console.log('Load more posts AJAX response:', xhr.responseText);
                    postsContainer.insertAdjacentHTML('beforeend', xhr.responseText);
                    page++;
                    theFold();
                }
            };

            xhr.open('POST', ajax_object.ajax_url, true);
            console.log('Load more posts AJAX data:', data);
            xhr.send(data);
        });
    }
});
