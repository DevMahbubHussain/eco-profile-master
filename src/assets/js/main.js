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
        // $("#tabs").tabs();

        // $('#epm_form_heading_name').change(function () {
        //     if (this.checked) {
        //         $('#name_heading_container').hide();
        //         $('#name_heading').val('');
        //     }
        //     else {
        //         $('#name_heading_container').show();
        //     }
        // })

        // Initialize the visibility based on the initial state of the checkbox
        // if ($('#epm_form_heading_name').prop('checked')) {
        //     $('#name_heading_container').hide();
        // }

        // // Listen for changes to the checkbox
        // $('#epm_form_heading_name').change(function () {
        //     if (this.checked) {
        //         $('#name_heading_container').fadeOut();
        //     } else {
        //         $('#name_heading_container').fadeIn();
        //     }
        // });

        $('#epm_form_heading_name').change(function () {
            if (this.checked) {
                $('#name_heading_container').fadeOut();
            } else {
                $('#name_heading_container').fadeIn();
            }
        });

        // Trigger the change event on page load if needed
        $('#epm_form_heading_name').trigger('change');


        // $("#accordion").accordion({
        //     collapsible: true, // Allow closing sections
        //     active: false, // Start with all sections collapsed
        //     heightStyle: "content" // Adjust height based on content
        // })

        //  image

        // $('#epm_user_avatar').on('change', function () {
        //     var input = this;
        //     if (input.files && input.files[0]) {
        //         var reader = new FileReader();
        //         reader.onload = function (e) {
        //             $('#uploaded-image').attr('src', e.target.result);
        //         };
        //         reader.readAsDataURL(input.files[0]);
        //     }
        // });


    });


})(jQuery);
