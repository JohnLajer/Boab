<?php

function boab2017_Enqueue()
{
    wp_enqueue_style('customcss', get_template_directory_uri().'/static/style/boab2017.css', array(), '1.0.0', 'all');
    wp_enqueue_script('customjs', get_template_directory_uri().'/static/javascript/boab2017.js', array(), '1.0.0', true);
}

add_action('wp_enqueue_scripts', 'boab2017_Enqueue');

function boab2017_Setup()
{
    add_theme_support('menus');

    register_nav_menu('primary', 'Primary Header Nav.');
}

add_action('after_setup_theme', 'boab2017_Setup');

add_theme_support('custom-background');
//add_theme_support('custom-header');
add_theme_support('post-thumbnails');

function boab2017_jQuery()
{
    if (!is_admin())
    {
        wp_deregister_script('jquery');

        // Load a copy of jQuery from the Google API CDN
        // The last parameter set to TRUE states that it should be loaded
        // in the footer.
        wp_register_script('jquery', 'https://code.jquery.com/jquery-3.2.1.js', false, '3.2.1', true);

        wp_enqueue_script('jquery');
    }
}
add_action('init', 'boab2017_jQuery');
?>