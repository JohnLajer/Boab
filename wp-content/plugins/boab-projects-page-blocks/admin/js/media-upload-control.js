/**
 * Callback function for the 'click' event of the 'Set Content Block Image'
 * anchor in its meta box.
 *
 * Displays the media uploader for selecting an image.
 *
 * @since 0.1.0
 */
function renderMediaUploaderProjects($, $ref) {
    'use strict';

    var file_frame,
        image_data,
        json,
        imgNo = $ref.data('no'),
        blockNo = $ref.closest('div.block-container').data('block-no');

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
        $( '#img-' + imgNo + '-blockno-' + blockNo + '-thumbnail-src' ).val( json.url );
        $( '#img-' + imgNo + '-blockno-' + blockNo + '-thumbnail-title' ).val( json.title );
        $( '#img-' + imgNo + '-blockno-' + blockNo + '-thumbnail-alt' ).val( json.title );

    });

    // Now display the actual file_frame
    file_frame.open();

}

(function( $ ) {
    'use strict';

    $(function() {
        $('div#accordion').on( 'click', 'input.set-image', function( evt ) {

            // Stop the anchor's default behavior
            evt.preventDefault();

            // Display the media uploader
            renderMediaUploaderProjects($, $(this));

        });

        $('div#accordion').on( 'click', 'a.remove-img', function( evt ) {

            // Stop the anchor's default behavior
            evt.preventDefault();

            // Remove the image, toggle the anchors
            resetUploadFormProjects($, $(this));

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
        function resetUploadFormProjects($, $ref) {
            'use strict';

            var imgNo   = $ref.data('no'),
                blockNo = $ref.closest('div.block-container').data('block-no');

            // First, we'll hide the image
            $ref.closest( 'div' ).hide();

            // Then display the previous container
            $ref.closest( 'div' ).siblings('div').show();

            // Finally, we reset the meta data input fields
            $( '#img-' + imgNo + '-blockno-' + blockNo + '-thumbnail-src' ).val( '' );
            $( '#img-' + imgNo + '-blockno-' + blockNo + '-thumbnail-title' ).val( '' );
            $( '#img-' + imgNo + '-blockno-' + blockNo + '-thumbnail-alt' ).val( '' );

        }

        // Go through all existing blocks and show the images that's set!
        $('div#accordion').find('table.images td').each(function() {
            // Does this td have a set image?
            if($.trim($(this).find('img').attr('src')) != '') {
                $(this).find('div.set-button').hide();
                $(this).find('div.image').show();
            }
        })

    });

})( jQuery );