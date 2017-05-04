<?php

/**
 * Template Name: Landing Page
 */

get_header();

?>
    <div id="topStripe">&nbsp;</div>

    <div class="landingTop">

        <img id="pointer" src="<?php bloginfo('template_url'); ?>/static/images/pointer.png" class="pointer" alt="pointer" />

        <div class="pageCentering landingTopArea">

            <a id="logo" href="#"><img src="<?php bloginfo('template_url'); ?>/static/images/logo-white.png" alt="Boab" /></a>

            <div class="contentCentering">
                <?php

                if(have_posts()) :
                    while(have_posts()) : the_post(); ?>

                        <div class="landingPageTeaser"><?php the_content(); ?></div>

                        <?php
                    endwhile;
                endif;

                ?>

                <h1 class="landingPageSplash">
                    <div>Do you need to</div>
                    <div>spread the word?</div>
                </h1>

                <div class="landingPageListContainer">
                    <ul class="landingPageList">
                        <li>Do you need to</li>
                        <li><a href="#">stand out?</a></li>
                        <li><a href="#">spread the word?</li>
                        <li><a href="#">connect with people?</li>
                        <li><a href="#">grow your business?</li>
                        <li><a href="#">attract new customers?</li>
                        <li><a href="#">be better understood?</li>
                    </ul>
                </div>
            </div>
            <img id="paperPlane" src="<?php bloginfo('template_url'); ?>/static/images/paper-plane.png" alt="Paper plane" />
        </div>
    </div>
<?php

get_footer();
?>