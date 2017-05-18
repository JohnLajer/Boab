$(document).ready(function() {
   $('input#boab_project_add_block_button').on('click', function() {

       // Get chosen content block type
       var contentBlockType = $(this).siblings('select#boab_projects_add_block').val();

       var data = {
           'action': 'add_content_block',
           'type': contentBlockType
       };

        $.ajax({
            url: ajaxurl,
            type: 'POST',
            dataType: 'json',
            data: data,
            success: function(response) {
                console.log(response);
            },
            error: function(error) {
                console.log(error);
            }
        });

   });
});