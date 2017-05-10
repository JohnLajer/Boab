<?php
if(has_post_thumbnail()) :

    $strUrlImg = wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) );

endif;
?>

<div class="blog-element" style="background-image: url(<?=$strUrlImg?>)">
    <?php
    the_title(sprintf('<h1 class="entry-title"><a href="%s">', esc_url( get_permalink() )), '</a></h1>');
    ?>

    <small>Posted on: <?php the_time('F j, Y'); ?> at <?php the_time('g:i a'); ?>, in <?php the_category(' '); ?></small>
</div>