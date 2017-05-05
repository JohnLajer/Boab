$( document ).ready(function() {

    var isFirstPointerHover = true;
    $('ul#menu-business-challanges li a').on('mouseover', function() {
        var position = $(this).position(),
            pointer = $('div.landingPageListContainer img#pointer');

        if(isFirstPointerHover) {

            pointer.css('display', 'block').css('top', (position.top + 3)).css('left', (position.left - 15));

            isFirstPointerHover = false;
        } else {
            // cancel previous animation and make a new one.
            pointer.stop();
            pointer.css('left', (position.left - 15));
            pointer.animate({top: (position.top + 2)}, 150);
        }
    });

    function positionSocialMedia() {
        // How far down is the very bottom pixel of this window?
        var bottomPixel = $(window).height() + $(window).scrollTop();

        if(bottomPixel > 850) {
            if($('ul.socialMedia').css('position') != 'absolute') {
                $('ul.socialMedia').css('position', 'absolute').css('top', 650).css('bottom', '');
            }
        } else {
            if($('ul.socialMedia').css('position') != 'fixed') {
                $('ul.socialMedia').css('position', 'fixed').css('bottom', 0).css('top', '');
            }
        }
    }

    // Make the social media stuff stay at the right point
    $(window).scroll(function(){
        positionSocialMedia();
    });
    $(window).resize(function(){
        positionSocialMedia();
    });

    // Run this when page is loaded
    positionSocialMedia();
});