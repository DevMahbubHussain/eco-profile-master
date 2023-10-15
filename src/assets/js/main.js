(function ($) {
    $(document).ready(function () {
        $('#epm_user_avatar').on('change', function () {
            var fileInput = $(this)[0];
            var currentImage = $('#current-image');
            if (fileInput.files && fileInput.files[0]) {
                // A new image has been selected, hide the current image
                currentImage.hide();
            } else {
                // No new image selected, show the current image
                currentImage.show();
            }
        });

        $('#epm_user_cover_image').on('change', function () {
            var fileInput = $(this)[0];
            var currentImage = $('#current-cimage');
            if (fileInput.files && fileInput.files[0]) {
                // A new image has been selected, hide the current image
                currentImage.hide();
            } else {
                // No new image selected, show the current image
                currentImage.show();
            }
        });


    });
})(jQuery);
