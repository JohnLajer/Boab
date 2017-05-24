<?php get_header(); ?>

<div class="row">

    <div class="col-xs-12">
        <div id="boab2017-carousel" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner" role="listbox">


                <?php

                $arrCategories = get_categories(array(
                    'include'   => '1, 8, 9'
                ));

                $iCounter   = 0;
                $strBullets = '';
                foreach($arrCategories as $oCategory) :

                    $oLastPost = new WP_Query(array(
                        'type'              => 'post',
                        'posts_per_page'    => 1,
                        'category__in'      => $oCategory->term_id,
                        'category__not_in'  => 10
                    ));

                    if($oLastPost->have_posts()) :
                        while($oLastPost->have_posts()) : $oLastPost->the_post();
                            $strActiveClass = '';
                            if($iCounter == 0) :
                                $strActiveClass = 'active';
                            endif;
                            ?>

                                <div class="item <?php echo $strActiveClass; ?>">
                                    <?php the_post_thumbnail('full');?>
                                    <div class="carousel-caption d-none d-md-block">

                                        <?php the_title(sprintf('<h1 class="entry-title"><a href="%s">', esc_url( get_permalink() ) ), '</a></h1>')?>

                                        <small><?php the_category(' ') ?></small>

                                    </div>
                                </div>

                            <?php

                        // Add a bullet
                            $strBullets .= '<li data-target="#boab2017-carousel" data-slide-to="'.$iCounter.'" class="'.$strActiveClass.'"></li>';

                            $iCounter++;
                        endwhile;
                    endif;

                    wp_reset_postdata();

                endforeach;
                ?>

            </div>

            <ol class="carousel-indicators">
                <?php echo $strBullets; ?>
            </ol>

            <a class="left carousel-control" href="#boab2017-carousel" role="button" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#boab2017-carousel" role="button" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>

</div>

<div class="row">

    <div class="col-xs-12 col-sm-8">

        <?php
        if(have_posts()) :
            while(have_posts()) : the_post();

                get_template_part('content', get_post_format());

            endwhile;
        endif;
/*
        // Print other 2 posts, not the first one
        $arrArgs = array(
            'type'              => 'post',
            'posts_per_page'    => 2,
            'offset'            => 1
        );
        $oOtherPosts = new WP_Query($arrArgs);

        if($oOtherPosts->have_posts()) :
            while($oOtherPosts->have_posts()) : $oOtherPosts->the_post();

                get_template_part('content', get_post_format());

            endwhile;
        endif;

        wp_reset_postdata();*/
/*
        // Tutorials
        $oOtherPosts = new WP_Query('type=post&posts_per_page=-1&cat=9');

        if($oOtherPosts->have_posts()) :
            while($oOtherPosts->have_posts()) : $oOtherPosts->the_post();

                get_template_part('content', get_post_format());

            endwhile;
        endif;

        wp_reset_postdata();*/
        ?>
        </div>
    <div class="col-xs-12 col-sm-4">
        <?php get_sidebar(); ?>
    </div>
</div>
<?php get_footer(); ?>

<?php
/*
 * <div id="boab2017-carousel" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner" role="listbox">


                    <?php

                    $arrCategories = get_categories(array(
                        'include'   => '1, 8, 9'
                    ));

                    $iCounter   = 0;
                    $strBullets = '';
                    foreach($arrCategories as $oCategory) :

                        $oLastPost = new WP_Query(array(
                            'type'              => 'post',
                            'posts_per_page'    => 1,
                            'category__in'      => $oCategory->term_id,
                            'category__not_in'  => 10
                        ));

                        if($oLastPost->have_posts()) :
                            while($oLastPost->have_posts()) : $oLastPost->the_post();
                                $strActiveClass = '';
                                if($iCounter == 0) :
                                    $strActiveClass = 'active';
                                endif;
                                ?>

                                <div class="item <?php echo $strActiveClass; ?>">
                                    <?php the_post_thumbnail('full');?>
                                    <div class="carousel-caption d-none d-md-block">

                                        <?php the_title(sprintf('<h1 class="entry-title"><a href="%s">', esc_url( get_permalink() ) ), '</a></h1>')?>

                                        <small><?php the_category(' ') ?></small>

                                    </div>
                                </div>

                                <?php

                                // Add a bullet
                                $strBullets .= '<li data-target="#boab2017-carousel" data-slide-to="'.$iCounter.'" class="'.$strActiveClass.'"></li>';

                                $iCounter++;
                            endwhile;
                        endif;

                        wp_reset_postdata();

                    endforeach;
                    ?>

                </div>

                <ol class="carousel-indicators">
                    <?php echo $strBullets; ?>
                </ol>

                <!--a class="left carousel-control" href="#boab2017-carousel" role="button" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a-->
                <a class="right carousel-control" href="#boab2017-carousel" role="button" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
 */
?>
