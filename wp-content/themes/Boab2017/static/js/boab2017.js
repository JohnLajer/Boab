$( document ).ready(function() {

    // Search function
    //.form-expand
    $('form.search-form').on('mouseover', function() {
       $(this).find('input').focus();
/*
        background-color: #fff;
        box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset;
        border-radius: 5px;
        border: 1px solid #ccc;*/
/*
        $(this).find('input')
        .animate({
            borderTopLeftRadius: 5,
            borderTopRightRadius: 5,
            borderBottomLeftRadius: 5,
            borderBottomRightRadius: 5,
            WebkitBorderTopLeftRadius: 5,
            WebkitBorderTopRightRadius: 5,
            WebkitBorderBottomLeftRadius: 5,
            WebkitBorderBottomRightRadius: 5,
            MozBorderRadius: 5,
            backgroundColor: '#99FFFF !important'
        }, 900);*/
    });
    $('form.search-form').on('click', function() {
        if($(this).find('input').val() != '') {
            $(this).submit();
        }
    });

    $('form.search-form input').on('focus', function() {
        $(this).parents('div.form-group').addClass('form-expand');
    });
    $('form.search-form input').on('blur', function() {
        $(this).parents('div.form-group').removeClass('form-expand');
    });

    // Landing page sub menu
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

    // Landing page Social Media
    function positionSocialMedia() {
        // How far down is the very bottom pixel of this window?
        var bottomPixel                 = $(window).height() + $(window).scrollTop(),
            footerTopPx                 = $(document).height() - $('div.footer').height(),
            socialMediaContainerHeight  = $('ul.socialMedia').height();

        // So we know that the social media container is fixed 200px from the top, and we know how tall it is, that means that we can know when it is approaching the page footer
        var bottomOfSocialMediaToVPBottom = (200 + socialMediaContainerHeight - $(window).height()) * -1;

        if((bottomPixel - bottomOfSocialMediaToVPBottom) >= footerTopPx) {
            if($('ul.socialMedia').css('top') != (footerTopPx - 200)) {
                $('ul.socialMedia').css('position', 'absolute').css('top', (footerTopPx - 200));
            }
        } else {
            if($('ul.socialMedia').css('position') != 'fixed') {
                $('ul.socialMedia').css('position', 'fixed').css('top', 200);
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

    // Landing typer scrips
    function pushTypo(typo, iTypoePos) {
        var typos = JSON.parse(localStorage.getItem("typos"));

        typos.push({
            typoAt: iTypoePos,
            typo: typo
        });

        localStorage.setItem("typos", JSON.stringify(typos));
    }

    function resetTyperWords() {
        localStorage.setItem("typos", JSON.stringify([]));

        var arrProblems = [];
        $('ul#menu-business-challanges li a').each(function() {

            var elem = $(this),
                text = elem.html();
            if(text == 'Attract new customers?') {
                text = 'Attract customers?';
            }

            // So, let's add a chance of typos on individual lines
            var chanceOfType    = 10, // percent
                typo            = '';
            if(Math.floor(Math.random() * 100) <= chanceOfType) {


                // Okay, so we're generating a typo. Find out which stage we're at and generate an appropriate typo
                if(text == 'Stand out?') {

                    // Generate two typos
                    if(Math.floor(Math.random() * 100) < 50) {
                        typo = 'Stamd ou';

                        pushTypo(typo, 3);
                    } else {
                        typo = 'Stand opt';

                        pushTypo(typo, 8);
                    }
                }

                if(text == 'Spread the word?') {

                    // Generate two typos
                    if(Math.floor(Math.random() * 100) < 50) {
                        typo = 'Spread teh wo';

                        pushTypo(typo, 8);
                    } else {
                        typo = 'Spresd the';

                        pushTypo(typo, 4);
                    }
                }

                if(text == 'Connect with people?') {

                    // Generate two typos
                    if(Math.floor(Math.random() * 100) < 50) {
                        typo = 'Connect whit ';

                        pushTypo(typo, 9);
                    } else {
                        typo = 'Cpnn';

                        pushTypo(typo, 1);
                    }
                }

                if(text == 'Grow your business?') {

                    // Generate two typos
                    if(Math.floor(Math.random() * 100) < 50) {
                        typo = 'Grow yiur ';

                        pushTypo(typo, 6);
                    } else {
                        typo = 'Grow your busu';

                        pushTypo(typo, 13);
                    }
                }

                if(text == 'Attract customers?') {

                    // Generate two typos
                    if(Math.floor(Math.random() * 100) < 50) {
                        typo = 'Attraxt ';

                        pushTypo(typo, 5);
                    } else {
                        typo = 'Attract custpm';

                        pushTypo(typo, 12);
                    }
                }

                if(text == 'Be better understood?') {

                    // Generate two typos
                    if(Math.floor(Math.random() * 100) < 50) {
                        typo = 'Be vet';

                        pushTypo(typo, 3);
                    } else {
                        typo = 'Be bettwr';

                        pushTypo(typo, 7);
                    }
                }

                arrProblems.push(typo);
            }
            arrProblems.push(text);
        });

        arrProblems.push('');

        return arrProblems;
    }

    function resetTyper() {
        Typed.new('div.typer', {
            strings: resetTyperWords(),
            typeSpeed: 100,
            startDelay: 400,
            loop: false,
            callback: function() {



                resetTyper();
            }
        });
    }

    resetTyper();
});