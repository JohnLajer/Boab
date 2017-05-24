<?php

/**
 * Template Name: Landing Page
 */

get_header();

?>
    <!-- Top part of the landing page -->

    <div class="topContainer">
        <div class="hidden-xs row">

            <div class="col-xs-0 col-sm-2">&nbsp;</div>
            <div class="col-xs-12 col-sm-10">

                <?php

                // Print data from WP
                if(have_posts()) :
                    while(have_posts()) : the_post(); ?>

                        <div class="landingPageTeaser"><?php the_content(); ?></div>

                        <?php
                    endwhile;
                endif;

                ?>

            </div>

        </div>

        <div class="row landingPageSplashContainer">

            <div class="col-xs-1 col-sm-4">&nbsp;</div>
            <div class="col-xs-11 col-sm-8">

                <h1 class="landingPageSplash">
                    <div>Do you need to</div>
                    <div class="typer"></div>
                </h1>

            </div>

        </div>

        <div class="row">

            <div class="col-xs-0 col-sm-2">&nbsp;</div>
            <div class="col-xs-12 col-sm-10">

                <div class="landingPageListContainer">

                    <img id="pointer" src="<?php bloginfo('template_url'); ?>/static/images/pointer.png" class="pointer" alt="pointer" />
                    <div>Do you need to</div>
                    <?php wp_nav_menu(array('theme_location' => 'landing_sub')); ?>

                </div>

            </div>

        </div>

        <div class="hidden-xs paper-plane">
            <img src="<?php bloginfo('template_url'); ?>/static/images/paper-plane.png" alt="Paper plane" />
        </div>

    </div>

    <ul class="socialMedia">
        <li><a href=""><img src="<?php bloginfo('template_url'); ?>/static/images/social/facebook.png" alt="Boab Facebook" /></a></li>
        <li><a href=""><img src="<?php bloginfo('template_url'); ?>/static/images/social/twitter.png" alt="Boab Twitter" /></a></li>
        <li><a href=""><img src="<?php bloginfo('template_url'); ?>/static/images/social/linked-in.png" alt="Boab LinkedIn" /></a></li>
        <li><a href=""><img src="<?php bloginfo('template_url'); ?>/static/images/social/instagram.png" alt="Boab Instagram" /></a></li>
    </ul>

    <div class="row">

        <div class="col-xs-12">
            <div class="landing-page-carousel-container">
                <div class="landing-page-carousel">
                    <?php
                    global $wpdb;

                    $arrResults = $wpdb->get_results("
                      SELECT
                        p.* 
                      FROM
                        {$wpdb->posts} p 
                      WHERE
                        p.post_type IN('post', 'boab-project')
                        && p.post_status = 'publish'
                      ORDER BY
                        p.id DESC
                      LIMIT 5
                    ");

                    $strPosts = '';
                    if(count($arrResults) > 0)
                    {

                        foreach($arrResults as $oResult)
                        {
                            $arrTrueSizeImg = wp_get_attachment_image_src(get_post_thumbnail_id($oResult), 'full');
                            $strPosts .= '
                            <div style="background-image:url('.$arrTrueSizeImg[0].')">
                                '.$arrTrueSizeImg[0].'
                            </div>
                            ';
                        }

                    }

                    echo $strPosts;
                    ?>
                </div>
            </div>
        </div>

        <script type="text/javascript">
            $(document).ready(function(){
                $('div.landing-page-carousel').slick({
                    centerMode: true,
                    centerPadding: '15vw',
                    slidesToShow: 1,
                    dots: true,
                    prevArrow: false,
                    autoplay:true,
                    autoplaySpeed:15000,
                });
            });
        </script>

    </div>

<?php

get_footer();
?>