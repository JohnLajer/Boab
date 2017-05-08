<?php

/**
 * Template Name: Landing Page
 */

get_header();

?>
    <!-- Black stribe at top -->
    <div id="topStripe">&nbsp;</div>

    <!-- Top part of the landing page -->
    <div class="landingTop">

        <!-- Social media links -->
        <ul class="socialMedia">
            <li><a href=""><img src="<?php bloginfo('template_url'); ?>/static/images/social/facebook.png" alt="Boab Facebook" /></a></li>
            <li><a href=""><img src="<?php bloginfo('template_url'); ?>/static/images/social/twitter.png" alt="Boab Twitter" /></a></li>
            <li><a href=""><img src="<?php bloginfo('template_url'); ?>/static/images/social/linked-in.png" alt="Boab LinkedIn" /></a></li>
            <li><a href=""><img src="<?php bloginfo('template_url'); ?>/static/images/social/instagram.png" alt="Boab Instagram" /></a></li>
        </ul>

        <!-- Center the page -->
        <div class="pageCentering landingTopArea">

            <a id="logo" href="#"><img src="<?php bloginfo('template_url'); ?>/static/images/logo-white.png" alt="Boab" /></a>

            <!-- Center the content -->
            <div class="contentCentering">
                <?php

                // Print data from WP
                if(have_posts()) :
                    while(have_posts()) : the_post(); ?>

                        <div class="landingPageTeaser"><?php the_content(); ?></div>

                        <?php
                    endwhile;
                endif;

                ?>

                <h1 class="landingPageSplash">
                    <div>Do you need to</div>
                    <div class="typer"></div>
                </h1>

                <div class="landingPageListContainer">

                    <img id="pointer" src="<?php bloginfo('template_url'); ?>/static/images/pointer.png" class="pointer" alt="pointer" />
                    <div>Do you need to</div>
                    <?php wp_nav_menu(array('theme_location' => 'landing_sub')); ?>

                </div>
            </div>
            <img id="paperPlane" src="<?php bloginfo('template_url'); ?>/static/images/paper-plane.png" alt="Paper plane" />
        </div>

    </div>

    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

<?php

get_footer();
?>