<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>We Are Boab</title>
        <?php wp_head() ?>
    </head>

    <?php
        if(is_front_page()/*is_home() WHere the blog is*/) :
            $arrClasses = array('homey', 'my-class');
        else :
            $arrClasses = array('no-class');
        endif
    ?>

    <body <?php body_class($arrClasses); ?>>

    <div class="pageCentering">
        <?php wp_nav_menu(array('theme_location' => 'primary')); ?>
    </div>
