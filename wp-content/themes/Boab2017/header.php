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

    <!-- Black stribe at top -->
    <div id="topStripe">&nbsp;</div>

    <div class="container">

        <div class="row">

            <div class="col-xs-12">

                <nav class="navbar navbar-default">
                    <div class="container-fluid">
                        <!-- Brand and toggle get grouped for better mobile display -->
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-navbar-collapse">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                            <a id="logo" href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php bloginfo('template_url'); ?>/static/images/logo-white.png" alt="Boab" /></a>
                        </div>
                        <div class="collapse navbar-collapse" id="bs-navbar-collapse">
                        <?php
                        wp_nav_menu(
                                array(
                                    'theme_location'    => 'primary',
                                    'container'         => false,
                                    'menu_class'        => 'nav navbar-nav navbar-right'
                                )
                        );
                        ?>
                        </div>
                    </div>
                </nav>

            </div>

        </div>
