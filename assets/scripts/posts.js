import { theFold } from './thefold/index';
document.addEventListener('DOMContentLoaded', function () {
    // Check if required elements exist
    var loadMoreButton = document.getElementById('load-more');
    var postsContainer = document.getElementById('posts-container');

    if (loadMoreButton && postsContainer) {
        var page = 2; // Initial page number

        // Load more posts on button click
        loadMoreButton.addEventListener('click', function () {
            var xhr = new XMLHttpRequest();
            var data = new FormData();
            data.append('action', 'load_more_posts');
            data.append('page', page);

            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    postsContainer.insertAdjacentHTML('beforeend', xhr.responseText);
                    page++;

                    theFold();
                }
            };

            xhr.open('POST', ajax_object.ajax_url, true);
            xhr.send(data);
        });
    }
});
