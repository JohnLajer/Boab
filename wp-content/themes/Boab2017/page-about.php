<?php
get_header();

$oLastPost = new WP_Query('type=post&posts_per_page=1');

if($oLastPost->have_posts()) :
    while($oLastPost->have_posts()) : $oLastPost->the_post(); ?>

        Suuup

        <h3><?php the_title(); ?></h3>

        <p><?php the_content(); ?></p>

        <hr>
        <?php
    endwhile;
endif;

wp_reset_postdata();


if(have_posts()) :
    while(have_posts()) : the_post(); ?>

        <h3><?php the_title(); ?></h3>

        <p><?php the_content(); ?></p>

        <hr>
        <?php
    endwhile;
endif;

// Print other 2 posts, not the first one
$arrArgs = array(
    'type'              => 'post',
    'posts_per_page'    => 2,
    'offset'            => 1
);
$oOtherPosts = new WP_Query($arrArgs);

if($oOtherPosts->have_posts()) :
    while($oOtherPosts->have_posts()) : $oOtherPosts->the_post(); ?>

        <h3><?php the_title(); ?></h3>

        <p><?php the_content(); ?></p>

        <hr>
        <?php
    endwhile;
endif;

wp_reset_postdata();

// Tutorials
$oOtherPosts = new WP_Query('type=post&posts_per_page=-1&cat=9');

if($oOtherPosts->have_posts()) :
    while($oOtherPosts->have_posts()) : $oOtherPosts->the_post(); ?>
        <h3><?php the_title(); ?></h3>

        <p><?php the_content(); ?></p>

        <hr>
        <?php
    endwhile;
endif;

wp_reset_postdata();

get_footer();
?>