jQuery(function($) {
    $('#load-more').on('click', function() {
        var button = $(this);
        var page = button.data('page');
        var maxPages = button.data('max');

        $.ajax({
            url: load_more_params.ajaxurl,
            data: {
                'action': 'load_more_posts',
                'query': load_more_params.query,
                'page': page,
            },
            type: 'POST',
            beforeSend: function() {
                button.text('Loading...'); // Change the button text
            },
            success: function(data) {
                if (data) {
                    $('#post-list').append(data);
                    button.data('page', page + 1);
                    button.text('Load More');

                    if (page + 1 == maxPages) {
                        button.remove();
                    }
                } else {
                    button.remove();
                }
            }
        });
    });
});