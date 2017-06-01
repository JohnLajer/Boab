<?php

/*
 * Template Name: Projects Template
 */

get_header();
?>
<div class="row">

    <div class="hidden-xs col-sm-2">&nbsp;</div>
    <div class="col-xs-12 col-sm-8">

        <?php

        // Print data from WP
        if(have_posts()) :
            while(have_posts()) : the_post(); ?>

                <h4 class="projects-content"><?php the_content(); ?></h4>

                <?php
            endwhile;
        endif;

        ?>

    </div>

    <div class="hidden-xs col-sm-2">
        <img class="clip" src="<?=get_template_directory_uri()?>/static/images/clip.svg">
    </div>

</div>
<div id="projects-container" class="row">
    <?php

    // Create the ability to filter on tasks taxonomy
    $arrTasks = get_terms('Tasks');

    $strFilterOnTasks = '<li><a href="javascript:void(0);" class="selected" data-slug="none">No Filter</a></li>';
    foreach($arrTasks as $oTask)
    {
        $strFilterOnTasks .= '<li><a href="javascript:void(0);" data-slug="'.$oTask->slug.'">'.$oTask->name.'</a></li>';
    }

    echo '
    <div class="row">
        <div class="col-xs-1">&nbsp;</div>
        <div class="col-xs-11">
        <ul class="type-filter">
            '.$strFilterOnTasks.'
        </ul>
        </div>
    </div>
    
    <div class="filler">&nbsp;</div>
    ';

    $args = [
        'post_type'         => 'boab_project',
        'posts_per_page'    => 9
    ];
    $loop = new WP_Query($args);
    echo boab2017_RenderPosts($loop);
    wp_reset_postdata();
    ?>
</div>
<div class="load-more">
    <a href="javascript:void(0);">LOAD MORE <span class="glyphicon glyphicon-menu-down"></span></a>
</div>
<?php

get_footer();
?>