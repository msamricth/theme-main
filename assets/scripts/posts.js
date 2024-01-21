document.addEventListener('DOMContentLoaded', function () {
    var page = 2; // Initial page number

    // Load more posts on button click
    document.getElementById('load-more').addEventListener('click', function () {
        var xhr = new XMLHttpRequest();
        var data = new FormData();
        data.append('action', 'load_more_posts');
        data.append('page', page);

        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                document.getElementById('posts-container').insertAdjacentHTML('beforeend', xhr.responseText);
                page++;
            }
        };

        xhr.open('POST', ajax_object.ajax_url, true);
        xhr.send(data);
    });
});