$(document).ready(function() {

    $('input#boab_project_add_block_button').on('click', function() {

        var $this = $(this);
        $this.attr('disabled', true);

        // Get chosen content block type
        var contentBlockType = $this.parents('tr').find('td select#boab_projects_add_block').val();

        // Find the highest blockNo and add 1 to get a truely unique block no
        var contentBlocksNo = 0,
            foundAny        = false;

        $("#accordion div.block-container").each(function() {
            if($(this).data('block-no') > contentBlocksNo) {

                contentBlocksNo = $(this).data('block-no');
                foundAny = true;
            }
        });

        var data = {
            'action': 'add_content_block',
            'type': contentBlockType,
            'block_no': contentBlocksNo+1
        };

        $.ajax({
            url: ajaxurl,
            type: 'POST',
            dataType: 'json',
            data: data,
            success: function(response) {

                $('div#accordion').append(response.data)
                    .accordion('destroy').accordion({
                        header: "> div > h3",
                        heightStyle: 'content',
                        active: ($("#accordion div.group").length -1),
                        collapsible: true
                    }).sortable({
                        axis: "y",
                        handle: "h3",
                        stop: function( event, ui ) {
                            // IE doesn't register the blur when sorting
                            // so trigger focusout handlers to remove .ui-state-focus
                            ui.item.children( "h3" ).triggerHandler( "focusout" );

                            // Refresh accordion to handle new order
                            $( this ).accordion( "refresh" );
                        }
                    });
            },
            error: function(error) {
                console.log(error);
            },
            complete: function() {
                console.log($this);
                $this.attr('disabled', false);
            }
        });

    });

    $( function() {
        $( '#accordion' ).accordion({
            header: "> div > h3",
            heightStyle: 'content',
            active: ($("#accordion div.group").length -1),
            collapsible: true
        }).sortable({
            axis: "y",
            handle: "h3",
            stop: function( event, ui ) {
                // IE doesn't register the blur when sorting
                // so trigger focusout handlers to remove .ui-state-focus
                ui.item.children( "h3" ).triggerHandler( "focusout" );

                // Refresh accordion to handle new order
                $( this ).accordion( "refresh" );
            }
        })
    } );

    $.ui.accordion.prototype._keydown = function( event ) {
        // your new code for the "_keydown" function
    };
});