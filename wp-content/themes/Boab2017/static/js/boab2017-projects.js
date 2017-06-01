$(window).ready(function() {
   $('div.load-more a').on('click', function() {

       loadPosts('');

   });

   $('ul.type-filter li a').on('click', function() {
        // Remove the selected class from all siblings
        $('ul.type-filter li a').each(function() {
           $(this).removeClass('selected');
        });

        // Add the selected class to this one
       $(this).addClass('selected');

       // Remove all posts since, we're changing filter
       $('div#projects-container').find('div.blog-element').each(function() {
           $(this).fadeOut(300, function(){ $(this).remove();});
       })

       // wait 350 ms after which we'll start adding some new stuff!
       var $this = $(this);
       setTimeout(function() {
           loadPosts($this.data('slug'));
       }, 350);
   });

   function loadPosts(typeFilter) {
       var data = {
           action: 'add_more_posts',
           offset: +$('div#projects-container').find('a.blog-element-desktop').last().data('postno'),
           context: 'boab_project',
           filter: typeFilter
       };

       $.ajax({
           url: ajaxurl,
           type: 'POST',
           dataType: 'json',
           data: data,
           success: function (response) {

               var responseData = JSON.parse(response.data);

               $('div#projects-container').append(responseData);

               $('div#projects-container').find('div.blog-element').each(function() {
                   $(this).fadeIn(500);
               });

               // If the amount of posts is not dividable by 9 or if we havent recieved any data in return remove the add more button
               if(response.data == '""') {
                   $('div.load-more').hide(300);
               } else if (($('div#projects-container').find('a.blog-element-desktop').length / 9) % 1 != 0) {
                   $('div.load-more').hide(300);
               } else {
                   $('div.load-more').show(300);
               }
           },
           error: function (error) {
               console.log(error);
           }
       });
   }

    $('div#projects-container').find('div.blog-element').each(function() {
        $(this).fadeIn(500);
    });

   function positionImage($strImage) {

       // How high is the container the image is in?
       var containerHeight  = $strImage.closest('div').height(),
            imageHeight     = $strImage[0].scrollHeight;

       // Calculate how much to margin top to make sure that the image is positioned center
       $strImage.css('margin-top', ((imageHeight - containerHeight) / 2 * -1))
   }
   // Make sure the featured image is positioned correctly so we see the center of the image
    $('div.adaptable-image img').each(function () {
        positionImage($(this));
    });
    $(window).resize(function(){
        $('div.adaptable-image img').each(function () {
            positionImage($(this));
        });
    });

    $('div.content div:nth-child(2) p').addClass('webstyle5');

    // Swap the before and after logos if there are two of them
    function swapLogos($swapImg) {
        window.setInterval(function() {

            // Find the hidden image
            var $hiddenImage = $swapImg.closest('div').find('img:hidden');

            // Now that we know which image is hidden, it's safe to assume that the other image is not hidden
            $shownImage = $hiddenImage.siblings('img');
            $shownImage.fadeOut(500, function() {
                $hiddenImage.fadeIn(500);
            });


        }, 3500);
    }
    swapLogos($('div.content img.swap'));

    $('div.gallery-slider').slick({
        dots: false,
        infinite: true,
        speed: 1500,
        slidesToShow: 5,
        centerMode: true,
        variableWidth: true
    });

    // Implement lightbox
    $(document).on('click', '[data-toggle="lightbox"]', function(event) {
        event.preventDefault();
        $(this).ekkoLightbox();
    });
});
