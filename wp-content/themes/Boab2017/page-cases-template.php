<?php

/*
 * Template Name: Cases Template
 */

get_header();

$args = [
    'post_type'         => 'case',
    'posts_per_page'    => 3
];
$loop = new WP_Query($args);
if($loop->have_posts()):
    while($loop->have_posts()) : $loop->the_post();

        get_template_part('content', 'archive');

    endwhile;
 endif;

get_footer();
?>