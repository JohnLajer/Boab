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

    <div class="row">

        <div class="col-xs-12">

            <?php
            global $wpdb;

            $arrResults = $wpdb->get_results("
              SELECT
                p.* 
              FROM
                {$wpdb->posts} p
              RIGHT JOIN
                {$wpdb->postmeta} pm ON
                  pm.post_id    = p.id
               && pm.meta_key   = '_boab_carousel_use_in_carousel' 
               && pm.meta_value = 1
              WHERE
                p.post_type IN('post', 'boab_project')
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

                    $strMetaData    = get_post_meta($oResult->ID, '_boab_carousel_settings', true);
                    $oMetaData      = json_decode($strMetaData);

                    $strStyle       = '';
                    $strClass       = '';
                    $strSubHeadline = '';
                    $strFontColor   = '';

                    # Background image
                    switch($oMetaData->{'carousel-graphics'})
                    {
                        case 'featured-image' :
                            $strStyle .= '
                                background-image:url('.$arrTrueSizeImg[0].');
                                background-size:cover;
                                background-position:center;
                            ';
                            $strFontColor = '#FFF';
                            break;
                        case 'custom-image' :
                            if(!empty($oMetaData->{'carousel-graphics-custom-image-src'}))
                            {
                                $strStyle .= '
                                    background-image:url('.$oMetaData->{'carousel-graphics-custom-image-src'}.');
                                    background-size:cover;
                                    background-position:center;
                                ';
                            }
                            else
                            {
                                $strStyle .= '
                                    background-image:url('.$arrTrueSizeImg[0].');
                                    background-size:cover;
                                    background-position:center;
                                ';
                            }
                            $strFontColor = '#FFF;';
                            break;
                        case 'icon' :
                            $strStyle .= '
                                background-image:url('.$oMetaData->{'carousel-graphics-custom-icon-src'}.');
                                background-repeat:no-repeat;
                            ';

                            $strClass .= ' carousel-background-icon';
                            break;
                    }

                    if(!empty($oMetaData->{'carousel-custom-background-color'})) {
                        $strStyle .= 'background-color:#'.$oMetaData->{'carousel-custom-background-color'}.';';
                    }

                    $strClass = empty($strClass) ? '' : 'class="'.trim($strClass).'"';
                    $strFontColor = empty($strFontColor) ? '' : 'style="color:'.$strFontColor.'"';

                    # Sub Headline
                    switch($oMetaData->{'carousel-sub-headline'})
                    {
                        case 'custom-text' :
                            $strSubHeadline = $oMetaData->{'carousel-custom-sub-headline'};
                            break;
                        case 'date' :

                            $strSubHeadline = date('j. F \'y', strtotime($oResult->post_date));
                            //.' of '.date('F \'y', strtotime($oMetaData->{'carousel-sub-headline'}))
                            break;
                    }

                    $strSubHeadline = empty($strSubHeadline) ? '' : '<h3 '.$strFontColor.'>'.$strSubHeadline.'</h3>';

                    $strThemeImg = get_template_directory_uri();

                    $strPosts .= '
                    <div style="'.$strStyle.'" '.$strClass.'>
                        <!--img src="'.$strThemeImg.'/static/images/clip_white.svg"-->
                        <div>
                            <h2 '.$strFontColor.'>'.$oMetaData->{'carousel-headline'}.'</h2>
                            '.$strSubHeadline.'
                        </div>
                    </div>
                    ';
                }

            }
            ?>
            <div class="landing-page-carousel-container">
                <div class="landing-page-carousel">
                    <?=$strPosts;?>
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
                    //autoplay:true,
                    //autoplaySpeed:11000,
                });
            });
        </script>

    </div>

<?php

get_footer();
?>