$(window).ready(function() {
    var chosenRelatedPostElem;
    $('table.related-posts-finder td input[type=button]').on('click', function() {

        activateSearch($(this));

    });
    $('table.related-posts-finder td img').on('click', function() {

        activateSearch($(this).closest('td').find('input[type=button]'));

    });

    function activateSearch($this) {
        // Remove the glow from all buttons, we might set a new glow class - but remove 'em all just in case
        $('table.related-posts-finder td input[type=button]').each(function() {
            $(this).removeClass('glowing-border');
            $(this).closest('td').find('div.chosen-related-post img').removeClass('glowing-border');
        });

        if($('div#related-post-chooser').css('display') == 'block' && chosenRelatedPostElem.attr('id') == $this.attr('id')) {
            $('div#related-post-chooser').hide(500);
        } else {
            $('div#related-post-chooser').show(500);
            chosenRelatedPostElem = $this;

            chosenRelatedPostElem.addClass('glowing-border');
            chosenRelatedPostElem.closest('td').find('div.chosen-related-post img').addClass('glowing-border');
        }
    }

    var excecuteSearch;
    $('div#related-post-chooser div#related-post-search input').on('keyup', function() {
        clearTimeout(excecuteSearch);

        var $this           = $(this);
        excecuteSearch = setTimeout(function() {

            var data = {
                'action': 'search_related_content',
                'search': $this.val(),
                'posttype': $this.closest('div#related-post-chooser').siblings('table').data('posttype')
            };

            $.ajax({
                url: ajaxurl,
                type: 'POST',
                dataType: 'json',
                data: data,
                success: function (response) {
                    var result = '';
                    if(response.data == '') {
                        var result = 'No posts found';
                    } else {
                        result = response.data;
                    }
                    var $selector       = $('div#related-posts-results'),
                        currentHeight   = $selector.height(),
                        iCurrentPosts   = $selector.find('div.related-post').length,
                        iRows           = Math.ceil(iCurrentPosts/5),
                        height          = 226.22 * iRows;



                    $selector.animate({
                        opacity: 0.25,
                        left: "+=50",
                        height: height+"px"
                    }, 500, function() {

                        iPosts = 0;
                        var iCurrentPosts = $($.parseHTML(result)).each(function() {
                            if($(this)[0].className == 'related-post') {
                                iPosts++;
                            }
                        });

                        var iRows           = Math.ceil(iPosts/5) > 0 ? Math.ceil(iPosts/5) : 1,
                            height          = 226.22 * iRows;

                        $selector.html(result).animate({
                            opacity: 1,
                            left: "-=50",
                            height: height+"px"
                        }, 500)
                    });

                }
            });

        }, 700);
    });

    $('#related-post-chooser').on('click', 'div.related-post', function() {
        var imageUrl    = $(this).find('div.related-post-viewer img').data('imageurl'),
            postID      = $(this).find('div.related-post-viewer img').data('post-id'),
            postTitle   = $(this).find('div.related-post-viewer img').data('post-title');

        setRelatedPost(imageUrl, postID, postTitle, chosenRelatedPostElem);
    });

    function setRelatedPost(imageUrl, postID, postTitle, chosenElement) {

        chosenElement.closest('td').find('div.chosen-related-post div div').html(postTitle);
        chosenElement.closest('td').find('div.chosen-related-post div img').attr('src', imageUrl);
        chosenElement.closest('td').find('div.chosen-related-post').removeClass('hidden');
        chosenElement.closest('div').addClass('hidden');

        chosenElement.closest('td').find('div.info-container input').val(postID);

        return;
    }

    // Check if we have some pre-set related posts

    if($('#related-post-id-1-post-id').val() != '' && $('#related-post-id-1-post-id').val() != 0) {
        setRelatedPost($('#related-post-id-1-post-id').data('img-src'), $('#related-post-id-1-post-id').val(), $('#related-post-id-1-post-id').data('post-title'), $('input#related-post-id-1'));
    }

    if($('#related-post-id-2-post-id').val() != '' && $('#related-post-id-2-post-id').val() != 0) {
        setRelatedPost($('#related-post-id-2-post-id').data('img-src'), $('#related-post-id-2-post-id').val(), $('#related-post-id-2-post-id').data('post-title'), $('input#related-post-id-2'));
    }
    if($('#related-post-id-3-post-id').val() != '' && $('#related-post-id-3-post-id').val() != 0) {
        setRelatedPost($('#related-post-id-3-post-id').data('img-src'), $('#related-post-id-3-post-id').val(), $('#related-post-id-3-post-id').data('post-title'), $('input#related-post-id-3'));
    }

    $('#boab-related-posts').on('click', 'div.chosen-related-post a', function() {

        $(this).closest('td').find('div.chosen-related-post img').attr('src', '');
        $(this).closest('td').find('div.chosen-related-post').addClass('hidden');
        $(this).closest('td').find('div.related-post-button').removeClass('hidden');

        $(this).closest('td').find('div.info-container input').val('');
    });

    $('div#boab-projects-page-blocks').on('click', 'h3 a', function() {
       $(this).closest('div.group').remove();
    });

});