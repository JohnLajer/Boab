/**
 * Callback function for the 'click' event of the 'Set Footer Image'
 * anchor in its meta box.
 *
 * Displays the media uploader for selecting an image.
 *
 * @since 0.1.0
 */
function renderMediaUploader($, type) {
    'use strict';

    var file_frame,
        image_data,
        json;

    type = (type == 'before') ? 'before' : 'after';

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
        $( '.' + type + '-boab-logo-container' )
            .children( 'img' )
            .attr( 'src', json.url )
            .attr( 'alt', json.caption )
            .attr( 'title', json.title )
            .show()
            .parent()
            .removeClass( 'hidden' );

        // Next, hide the anchor responsible for allowing the user to select an image
        $( '.' + type + '-boab-logo-container' )
            .prev()
            .hide();

        // Display the anchor for the removing the featured image
        $( '.' + type + '-boab-logo-container' )
            .next()
            .show();

        // Store the image's information into the meta data fields
        $( '#' + type + '-thumbnail-src' ).val( json.url );
        $( '#' + type + '-thumbnail-title' ).val( json.title );
        $( '#' + type + '-thumbnail-alt' ).val( json.title );

    });

    // Now display the actual file_frame
    file_frame.open();

}

(function( $ ) {
    'use strict';

    $(function() {
        $( '.change-logo' ).on( 'click', function( evt ) {

            // Stop the anchor's default behavior
            evt.preventDefault();

            // Display the media uploader
            renderMediaUploader($, $(this).data('type'));

        });

        $( '.remove-logo' ).on( 'click', function( evt ) {

            // Stop the anchor's default behavior
            evt.preventDefault();

            // Remove the image, toggle the anchors
            resetUploadForm($, $(this).data('type'));

        });

        /**
         * Callback function for the 'click' event of the 'Remove Footer Image'
         * anchor in its meta box.
         *
         * Resets the meta box by hiding the image and by hiding the 'Remove
         * Footer Image' container.
         *
         * @param    object    $    A reference to the jQuery object
         * @since    0.2.0
         */
        function resetUploadForm($, type) {
            'use strict';

            type = (type == 'before') ? 'before' : 'after';

            // First, we'll hide the image
            $( '.' + type + '-boab-logo-container' )
                .children( 'img' )
                .hide();

            // Then display the previous container
            $( '.' + type + '-boab-logo-container' )
                .prev()
                .show();

            // We add the 'hidden' class back to this anchor's parent
            $( '.' + type + '-boab-logo-container' )
                .next()
                .hide()
                .addClass( 'hidden' );

            // Finally, we reset the meta data input fields
            $( '#' + type + '-boab-inputs-container' )
                .children()
                .val( '' );

        }

        /**
         * Checks to see if the input field for the thumbnail source has a value.
         * If so, then the image and the 'Remove featured image' anchor are displayed.
         *
         * Otherwise, the standard anchor is rendered.
         *
         * @param    object    $    A reference to the jQuery object
         * @since    1.0.0
         */
        function renderFeaturedImage($, type) {

            type = (type == 'before') ? 'before' : 'after';

            /* If a thumbnail URL has been associated with this image
             * Then we need to display the image and the reset link.
             */
            if ( '' !== $.trim ( $( '#' + type + '-thumbnail-src' ).val() ) ) {

                $( '.' + type + '-boab-logo-container' ).removeClass( 'hidden' );

                $( '.set-' + type + '-boab-logo' )
                    .parent()
                    .hide();

                $( '.remove-' + type + '-boab-logo' )
                    .parent()
                    .removeClass( 'hidden' );

            }

        }

        renderFeaturedImage( $, 'before' );
        renderFeaturedImage( $, 'after' );

    });

})( jQuery );