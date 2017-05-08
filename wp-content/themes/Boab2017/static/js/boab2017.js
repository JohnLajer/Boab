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