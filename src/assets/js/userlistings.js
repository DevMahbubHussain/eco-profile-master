; (function ($) {
    $(document).ready(function () {
        $('.view-profile-btn').on('click', function () {
            const userId = $(this).data('user-id');
            $.ajax({
                type: 'GET',
                url: epmUsersListing.ajaxurl,
                data: {
                    action: 'epm_ajax_action',
                    user_id: userId
                },
                success: function (response) {
                    console.log(response);
                    response = response.trim(); // Trim whitespace
                    $('#userDetails').html(response);
                    $('#userDetails').contents().filter(function () {
                        return this.nodeType === 3; // Node.TEXT_NODE
                    }).last().remove();
                },
                error: function () {
                    console.error(epmUsersListing.error);
                },
            });
        });






    });
})(jQuery);

