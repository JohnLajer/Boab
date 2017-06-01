/**
 * Callback function for the 'click' event of the 'Set Content Block Image'
 * anchor in its meta box.
 *
 * Displays the media uploader for selecting an image.
 *
 * @since 0.1.0
 */
function renderMediaUploaderCarousel($, $ref) {
    'use strict';

    var file_frame,
        image_data,
        json;


    /**
     * If an instance of file_frame already exists, then we can open it
     * rather than creating a new instance.
     */
    if ( undefined !== file_frame ) {

        file_frame.open();
        return;

    }

    /**
     * If we're this far, then an instance does not exist, so we need to
     * create our own.
     *
     * Here, use the wp.media library to define the settings of the Media
     * Uploader. We're opting to use the 'post' frame which is a template
     * defined in WordPress core and are initializing the file frame
     * with the 'insert' state.
     *
     * We're also not allowing the user to select more than one image.
     */
    file_frame = wp.media.frames.file_frame = wp.media({
        frame:    'post',
        state:    'insert',
        multiple: false
    });

    /**
     * Setup an event handler for what to do when an image has been
     * selected.
     *
     * Since we're using the 'view' state when initializing
     * the file_frame, we need to make sure that the handler is attached
     * to the insert event.
     */
    file_frame.on( 'insert', function() {

        // Read the JSON data returned from the Media Uploader
        json = file_frame.state().get( 'selection' ).first().toJSON();

        // First, make sure that we have the URL of an image to display
        if ( 0 > $.trim( json.url.length ) ) {
            return;
        }

        // After that, set the properties of the image and display it
        $ref.closest('td').find('div.image img')
            .attr( 'src', json.url )
            .attr( 'alt', json.caption )
            .attr( 'title', json.title )
            .show()
            .parent();

        // Next, hide the anchor responsible for allowing the user to select an image
        $ref.closest('td').find('div.set-button').hide();

        // Display the anchor for the removing the featured image
        $ref.closest('td').find('div.image').show();

        // Store the image's information into the meta data fields
        $ref.closest('td').find('div.image-values input.carousel-graphics-custom-src').val( json.url );
        $ref.closest('td').find('div.image-values input.carousel-graphics-custom-title').val( json.title );
        $ref.closest('td').find('div.image-values input.carousel-graphics-custom-alt').val( json.alt );

    });

    // Now display the actual file_frame
    file_frame.open();

}

(function( $ ) {
    'use strict';

    $(function() {
        $('div#carousel-options table tr input[type=button].add-custom-graphics').on( 'click', function( evt ) {

            // Stop the anchor's default behavior
            evt.preventDefault();

            // Display the media uploader
            renderMediaUploaderCarousel($, $(this));

        });

        $('div#carousel-options table tr a.remove-img').on( 'click', function( evt ) {

            // Stop the anchor's default behavior
            evt.preventDefault();

            // Remove the image, toggle the anchors
            resetUploadFormCarousel($, $(this));

        });

        /**
         * Callback function for the 'click' event of the 'Remove Image'
         * anchor in its meta box.
         *
         * Resets the meta box by hiding the image and by hiding the 'Remove
         *
         * @param    object    $    A reference to the jQuery object
         * @since    0.2.0
         */
        function resetUploadFormCarousel($, $ref) {
            'use strict';

            // First, we'll hide the image
            $ref.closest( 'div' ).hide();

            // Then display the previous container
            $ref.closest( 'div' ).siblings('div.set-button').show();

            // Finally, we reset the meta data input fields
            // Store the image's information into the meta data fields
            $ref.closest('td').find('div.image-values input.carousel-graphics-custom-src').val( '' );
            $ref.closest('td').find('div.image-values input.carousel-graphics-custom-title').val( '' );
            $ref.closest('td').find('div.image-values input.carousel-graphics-custom-alt').val( '' );

        }


        // Go through all existing blocks and show the images that's set!
        function showOrHideImage($ref) {

            if($ref.find('input.carousel-graphics-custom-src').val() != '') {

                var src     = $ref.find('input.carousel-graphics-custom-src').val(),
                    alt     = $ref.find('input.carousel-graphics-custom-alt').val(),
                    title   = $ref.find('input.carousel-graphics-custom-title').val();

                // After that, set the properties of the image and display it
                $ref.closest('td').find('div.image img')
                    .attr( 'src', src )
                    .attr( 'alt', alt )
                    .attr( 'title', title )
                    .show()
                    .parent();

                // Next, hide the anchor responsible for allowing the user to select an image
                $ref.closest('td').find('div.set-button').hide();

                // Display the anchor for the removing the featured image
                $ref.closest('td').find('div.image').show();
            }
        }

        showOrHideImage($('tr#carousel-graphics-custom-icon-row div.image-values'));
        showOrHideImage($('tr#carousel-graphics-custom-image-row div.image-values'));

    });

})( jQuery );