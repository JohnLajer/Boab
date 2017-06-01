$(window).ready(function() {
    $('input#carousel-use-in-carousel').on('click', function() {
        toggleUseInCarousel($(this));
    });

    function toggleUseInCarousel($checkbox) {
        if($checkbox.is(':checked')) {
            $('div#carousel-options').show(500);
        } else {
            $('div#carousel-options').hide(500);
        }
    }

    toggleUseInCarousel($('input#carousel-use-in-carousel'));

    $('select#carousel-sub-headline').on('change', function() {
       toggleSubHeadlineRow($(this));
    });

    function toggleSubHeadlineRow($subHeadlineSelect) {
        if($subHeadlineSelect.val() == 'custom-text') {
            $('tr#carousel-custom-sub-headline-row').show(300);
        } else {
            $('tr#carousel-custom-sub-headline-row').hide(300);
        }
    }

    toggleSubHeadlineRow($('select#carousel-sub-headline'));

    $('select#carousel-graphics').on('change', function() {
        toggleAdditionalSettings($(this));
    });

    function toggleAdditionalSettings($graphicsSelect) {
        if($graphicsSelect.val() == 'custom-image') {

            $('tr#carousel-graphics-custom-icon-row').hide(300, function() {
                $('tr#carousel-custom-background-color-row').hide(300, function() {
                    $('tr#carousel-graphics-custom-image-row').show(300);
                });
            });

        }else if($graphicsSelect.val() == 'icon') {

            $('tr#carousel-graphics-custom-image-row').hide(300, function() {
                $('tr#carousel-custom-background-color-row').show(300, function() {
                    $('tr#carousel-graphics-custom-icon-row').show(300);
                });
            });

        } else if($graphicsSelect.val() == 'none') {

            $('tr#carousel-graphics-custom-icon-row').hide(300, function() {
                $('tr#carousel-graphics-custom-image-row').hide(300, function() {
                    $('tr#carousel-custom-background-color-row').show(300);
                });
            });

        } else {

            $('tr#carousel-graphics-custom-image-row').hide(300);
            $('tr#carousel-graphics-custom-icon-row').hide(300);
            $('tr#carousel-custom-background-color-row').hide(300);

        }
    }

    toggleAdditionalSettings($('select#carousel-graphics'));

    $('div#boab-carousel-settings table td a#default-background-color').on('click', function() {
        var $input = $(this).closest('tr').find('td input[type=text]');
        $input.val('F5F0E8');

        // Update field hack :)
        $input.focus();
        $input.blur();
    });
});