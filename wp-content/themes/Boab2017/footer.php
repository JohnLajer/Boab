
        <ul class="socialMedia hidden-xs">
            <li><a href=""><img src="<?php bloginfo('template_url'); ?>/static/images/social/facebook.png" alt="Boab Facebook" /></a></li>
            <li><a href=""><img src="<?php bloginfo('template_url'); ?>/static/images/social/twitter.png" alt="Boab Twitter" /></a></li>
            <li><a href=""><img src="<?php bloginfo('template_url'); ?>/static/images/social/linked-in.png" alt="Boab LinkedIn" /></a></li>
            <li><a href=""><img src="<?php bloginfo('template_url'); ?>/static/images/social/instagram.png" alt="Boab Instagram" /></a></li>
        </ul>

    </div> <!-- close container -->
    <script type="text/javascript">
        var nanobar = new Nanobar( {id: 'topStripe' } );
        nanobar.go(80);
    </script>
    <div class="footer">

        <div class="container">

            <footer>
                <div class="row">

                    <div class="col-xs-12">

                        <nav class="navbar navbar-default">
                            <div class="container-fluid">
                                <!-- Brand and toggle get grouped for better mobile display -->
                                <div class="navbar-header">
                                    <button type="button" class="navbar-toggle collapsed hidden-xs" data-toggle="collapse" data-target="#bs-navbar-collapse">
                                        <span class="sr-only">Toggle navigation</span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                    </button>
                                    <a id="logo" href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php bloginfo('template_url'); ?>/static/images/logo-white.png" alt="Boab" /></a>
                                </div>
                                <div class="collapse navbar-collapse hidden-xs" id="bs-navbar-collapse-bottom">
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

                <div class="row">

                    <div class="col-xs-12">
                        <h2>Say Hello</h2>
                        <div class="row">

                            <div class="col-xs-12 col-sm-4">
                                <p>
                                    101 The Avenue <br />
                                    Parap <br />
                                    NT 0820
                                </p>
                            </div>
                            <div class="col-xs-12 col-sm-4">
                                <p>
                                    PO Box 234 <br />
                                    Parap <br />
                                    NT 0820
                                </p>
                            </div>
                            <div class="col-xs-12 col-sm-4">
                                <p>
                                    Contact: <br />
                                    +61 8 89411799 <br />
                                    hello@boabdesign.com.au
                                </p>
                            </div>

                        </div>
                    </div>

                    <div class="col-xs-12 footer-info">

                        <p>Boab Design &copy;<?php echo date('Y') ?></p>
                        <?php wp_nav_menu(array('theme_location' => 'footer')); ?>

                    </div>

                </div>

                <div class="footerContact">

                </div>
            </footer>

        </div>

    </div>
    <script type="text/javascript">
        var nanobar = new Nanobar( {id: 'topStripe' } );
        nanobar.go(85);
    </script>
    <?php wp_footer(); ?>

    <script type="text/javascript">
        var nanobar = new Nanobar( {id: 'topStripe' } );
        nanobar.go(100);
    </script>
    </body>
</html>