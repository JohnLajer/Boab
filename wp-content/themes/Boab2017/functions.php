<?php

/*
    ===================================
    Include scripts
    ===================================
*/
function boab2017_Enqueue()
{
    // CSS
    wp_enqueue_style('bootstrap', get_template_directory_uri().'/static/css/bootstrap.min.css', array(), '', 'all');
    wp_enqueue_style('defaultcss', get_template_directory_uri().'/static/css/boab2017-basic.css', array(), '1.0.0', 'all');
    wp_enqueue_style('searchcss', get_template_directory_uri().'/static/css/search-form.css', array(), '1.0.0', 'all');

    // Load correct css.
    if(basename(get_page_template()) == 'page-landing.php')
    {
        wp_enqueue_style('customcss', get_template_directory_uri().'/static/css/boab2017-landing.css', array(), '1.0.0', 'all');
    }
    elseif(basename(get_page_template()) == 'page-about.php')
    {
        wp_enqueue_style('carousel', get_template_directory_uri().'/static/css/boab2017-carousel.css', array(), '1.0.0', 'all');
    }
    else
    {
        wp_enqueue_style('customcss', get_template_directory_uri().'/static/css/boab2017-default.css', array(), '1.0.0', 'all');
    }

    // JS
    wp_deregister_script('jquery');

    // Load a copy of jQuery from the Google API CDN
    // The last parameter set to TRUE states that it should be loaded
    // in the footer.
    wp_register_script('jquery', 'https://code.jquery.com/jquery-3.2.1.js', false, '3.2.1', true);

    wp_enqueue_script('jquery');
    wp_enqueue_script('bootstrap-js', get_template_directory_uri().'/static/js/bootstrap.min.js', array(), '', true);
    wp_enqueue_script('customjs', get_template_directory_uri().'/static/js/boab2017.js', array(), '1.0.0', true);
    wp_enqueue_script('type', get_template_directory_uri().'/static/js/type.js', array(), '1.0.0', true);
}

add_action('wp_enqueue_scripts', 'boab2017_Enqueue');

/*
    ===================================
    Activate menus
    ===================================
*/
function boab2017_Setup()
{
    add_theme_support('menus');

    register_nav_menu('primary', 'Primary Header Nav.');
    register_nav_menu('landing_sub', 'Landing page business challanges');
    register_nav_menu('footer', 'Footer Menu');
}

add_action('after_setup_theme', 'boab2017_Setup');

/*
    ===================================
    Theme support
    ===================================
*/
add_theme_support('custom-background');
//add_theme_support('custom-header');
add_theme_support('post-thumbnails');
add_theme_support('post-formats', array('aside', 'image', 'video'));
add_theme_support('html5', array('search-form'));

/*
    ===================================
    Sidebar function
    ===================================
*/
function boab2017_WidgetSetup()
{
    register_sidebar(array(
        'name'          => 'Sidebar',
        'id'            => 'sidebar-1',
        'class'         => 'custom',
        'description'   => 'Standard sidebar',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h1 class="widget-title">',
        'after_title'   => '</h1>',
    ));
}

add_action('widgets_init', 'boab2017_WidgetSetup');

/*
    ===================================
    Include Walker file
    ===================================
*/

require get_template_directory() .'/inc/walker.php';

/*
    ===================================
    Head function
    ===================================
*/

function boab2017_RemoveVersion()
{
    return '';
}

add_filter('the_generator', 'boab2017_RemoveVersion');
?>