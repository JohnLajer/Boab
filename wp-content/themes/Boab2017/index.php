<?php get_header(); ?>

<div class="row">

    <div class="col-xs-12 col-sm-8">

        <div class="row text-center">

        <?php
        // Manually set pagination to 3 posts, instead of WP's default...
        $iCurrentPage = get_query_var('paged');
        $arrArgs = array(
            'posts_per_page'    => 3,
            'paged'             => ($iCurrentPage > 0 ? $iCurrentPage : 1)
        );
        query_posts($arrArgs);
        if(have_posts()) :

            $iLoops     = 0;
            $iColumn    = 0;

            while(have_posts()) : the_post();

                $strClass   = '';

                if($iLoops == 0) :
                    $iColumn = 12;
                elseif($iLoops > 0 && $iLoops <= 2) :
                    $iColumn = 6;
                    $strClass = 'second-row-padding';
                else :
                    $iColumn = 4;
                    $strClass = 'third-row-padding';
                endif;

                ?>
                <div class="col-xs-<?=$iColumn.' '.$strClass?>">
                <?php
                    get_template_part('content', 'blog');
                ?>
                </div>
                <?php

                $iLoops++;
            endwhile;
        ?>

        <div class="col-xs-6 text-left">
            <?php next_posts_link('<- Older Posts') ?>
        </div>
        <div class="col-xs-6 text-right">
            <?php previous_posts_link('Newer Posts ->') ?>
        </div>
        <?php
        endif;
        wp_reset_query();
        ?>
        </div>
    </div>
    <div class="col-xs-12 col-sm-4">
        <?php get_sidebar(); ?>
    </div>
</div>
<?php get_footer(); ?>