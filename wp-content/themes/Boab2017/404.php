<?php get_header() ?>

    <div id="primary" class="container">
        <main id="main" class="site-main" role="main">

            <section class="error-404 not-found">

                <head class="page-header">

                    <h1 class="page-title">Sorry, Page not found</h1>

                </head>

                <div class="page-content">

                    <h2>This is not the location you're looking for. Maybe try one of the links below, or search?</h2>

                    <?php

                        get_search_form();

                        the_widget('WP_Widget_Recent_Posts');

                    ?>

                    <div class="widget widget_categories">
                        <h3>Check the most used categories</h3>

                        <ul>
                            <?php
                                wp_list_categories(array(
                                    'orderby'       => 'count',
                                    'order'         => 'DESC',
                                    'show_count'    => 1,
                                    'title'         => '',
                                    'number'        => 5
                                ));
                            ?>
                        </ul>
                    </div>

                </div>

            </section>

        </main>
    </div>

<?php get_footer() ?>
