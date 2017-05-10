<article id="post-<?php the_ID();?>" <?php post_class(); ?>>

    <?php

    if( has_post_thumbnail() ) :
        ?>
        <div class="pull-left"><?php the_post_thumbnail('thumbnail'); ?></div>
        <?php
    endif;

        the_title('<h1 class="entry-title">', '</h1>');

        ?> <small><?php the_category(' '); ?> || <?php the_tags() ?> || <?php edit_post_link() ?></small> <?php

        the_excerpt();
    ?>



</article>