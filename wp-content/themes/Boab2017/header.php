<!doctype html>
<html <?php language_attributes(); ?>>

    <head>
        <meta charset="<?php bloginfo('charset') ?>" />
        <meta name="description" content="<?php bloginfo('description') ?>" />
        <title><?php bloginfo('name') ?><?php wp_title('-') ?></title>
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
    <div id="topStripe" class="loading-content"></div>
    <script type="text/javascript">
        var nanobar = new Nanobar( {id: 'topStripe' } );
        nanobar.go(5);
    </script>

    <div class="container">

        <div class="row adapt-row">

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
                            <a id="logo" href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php bloginfo('template_url'); ?>/static/images/<?=((basename(get_page_template()) == 'page-landing.php') ? 'logo-white.png' : 'logo-black.png')?>" alt="Boab" /></a>
                        </div>
                        <div class="collapse navbar-collapse" id="bs-navbar-collapse">
                            <div class="hidden-xs search-form-container">
                                <?php get_search_form(); ?>
                            </div>
                        <?php
                        wp_nav_menu(
                                array(
                                    'theme_location'    => 'primary',
                                    'container'         => false,
                                    'menu_class'        => 'nav navbar-nav navbar-right',
                                    'walker'            => new Walker_NavPrimary()
                                )
                        );
                        ?>
                        </div>
                    </div>
                </nav>

            </div>

        </div>

        <script type="text/javascript">
            var nanobar = new Nanobar( {id: 'topStripe' } );
            nanobar.go(15);
        </script>