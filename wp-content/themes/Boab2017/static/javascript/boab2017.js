$( document ).ready(function() {

    var isFirstPointerHover = true;
    $('ul.landingPageList li a').on('mouseover', function() {
        var position = $(this).offset(),
            pointer = $('div.landingTop img#pointer');

        if(isFirstPointerHover) {

            pointer.css('display', 'block').css('top', (position.top + 2)).css('left', (position.left - 10));

            isFirstPointerHover = false;
        } else {
            // cancel previous animation and make a new one.
            pointer.stop();
            pointer.animate({top: (position.top + 2)}, 150);
        }
    });
});