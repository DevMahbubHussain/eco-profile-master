(function ($) {
    $(document).ready(function () {
        // Show the first panel's content and add the active class to its header
        $('.collapsible-panels .panel').first().find('.panel-header').addClass('active');
        $('.collapsible-panels .panel').first().find('.panel-content').show();

        // Collapsible Panels
        $('.collapsible-panels .panel-header').on('click', function () {
            if (!$(this).hasClass('active')) {
                // Hide the previously active panel
                $('.collapsible-panels .panel-header.active').removeClass('active');
                $('.collapsible-panels .panel-content').slideUp();

                // Show the clicked panel's content and add the active class to its header
                $(this).addClass('active');
                $(this).next('.panel-content').slideDown();
            }
        });

        // tabs 
        $("#tabs").tabs();





    });


})(jQuery);
