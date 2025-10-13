/* global ajaxurl */
(function (wp, $) {
    'use strict';

    if (!wp) {
        return;
    }

    $(function () {
        // Dismiss notice
        $(document).on('click', '.square-notice-nux .notice-dismiss', function () {
            $.ajax({
                type: 'POST',
                url: ajaxurl,
                data: {
                    nonce: squareNUX.nonce,
                    action: 'square_dismiss_notice'
                },
                dataType: 'json'
            });
        });
    });
})(window.wp, jQuery);