
    <footer>
        <div class="pageCentering">
            <?php wp_nav_menu(array('theme_location' => 'primary')); ?>
            <a id="logo" href="#"><img src="<?php bloginfo('template_url'); ?>/static/images/logo-white.png" alt="Boab" /></a>

            <div class="footerMenu">
                <p>Boab Design &copy;<?php echo date('Y') ?></p>
                <?php wp_nav_menu(array('theme_location' => 'footer')); ?>
            </div>

            <div class="footerContact">
                <h2>Say Hello</h2>
                <table border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td>
                            <p>101 The Avenue</p>
                            <p>Parap</p>
                            <p>NT 0820</p>
                        </td>
                        <td>
                            <p>PO Box 234</p>
                            <p>Parap</p>
                            <p>NT 0820</p>
                        </td>
                        <td>
                            <p>+61 8 89411799</p>
                            <p>hello@boabdesign</p>
                            <p>.com.au</p>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </footer>

    <?php wp_footer(); ?>

    </body>
</html>