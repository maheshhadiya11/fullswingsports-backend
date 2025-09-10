jQuery(document).ready(function ($) {
    function showZenDeskWidget() {
        if (window.zE) {
            window.zE('webWidget', 'show');
            window.zE('webWidget', 'open');
        } else {
        }
    }

    function hideZenDeskWidget() {
        if (window.zE) {
            window.zE('webWidget', 'hide');
        } else {
        }
    }

    hideZenDeskWidget();

    if (window.zE) {
        window.zE('webWidget:on', 'close', function() {
            hideZenDeskWidget();
        });
    }

    $('a[href*="#support"]').on('click', function (event) {
        event.preventDefault();
        showZenDeskWidget();
    });
});
