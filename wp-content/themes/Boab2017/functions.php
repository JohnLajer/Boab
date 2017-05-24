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

    // JS
    wp_deregister_script('jquery');

    // Load a copy of jQuery from the Google API CDN
    // The last parameter set to TRUE states that it should be loaded
    // in the footer.
    wp_register_script('jquery', 'https://code.jquery.com/jquery-3.2.1.js', false, '3.2.1', true);

    wp_enqueue_script('jquery');
    wp_enqueue_script('jquery-migrate', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-migrate/3.0.0/jquery-migrate.js', array(), '', true);
    wp_enqueue_script('slick-js', get_template_directory_uri().'/static/libs/slick/slick/slick.js', array(), '', true);
    wp_enqueue_script('bootstrap-js', get_template_directory_uri().'/static/js/bootstrap.min.js', array(), '', true);
    //wp_enqueue_script('bootstrap-form-helper-phone', get_template_directory_uri().'/static/js/form-helpers/bootstrap-formhelpers-phone.js', array(), '', true);
    wp_enqueue_script('nanobar', get_template_directory_uri().'/static/libs/nanobar/nanobar.js', array(), '1.0.0', false);
    wp_enqueue_script('customjs', get_template_directory_uri().'/static/js/boab2017.js', array(), '1.0.0', true);
    wp_enqueue_script('type', get_template_directory_uri().'/static/js/type.js', array(), '1.0.0', true);

    // Load correct css.
    if(basename(get_page_template()) == 'page-landing.php')
    {
        wp_enqueue_style('customcss', get_template_directory_uri().'/static/css/boab2017-landing.css', array(), '1.0.0', 'all');
        wp_enqueue_style('carousel', get_template_directory_uri().'/static/css/boab2017-carousel.css', array(), '1.0.0', 'all');
        wp_enqueue_style('slick', get_template_directory_uri().'/static/libs/slick/slick/slick.css', array(), '1.0.0', 'all');
        wp_enqueue_style('slick-theme', get_template_directory_uri().'/static/libs/slick/slick/slick-theme.css', array(), '1.0.0', 'all');
    }
    elseif(basename(get_page_template()) == 'page-about.php')
    {
        //
    }
    else
    {
        wp_enqueue_style('customcss', get_template_directory_uri().'/static/css/boab2017-default.css', array(), '1.0.0', 'all');
    }
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

/*
    ===================================
    Custom Post Type
    ===================================
*/

function boab2017_ProjectsCPT()
{
    $labels = array(
        'name' => 'Projects',
        'singular_name' => 'Project',
        'add_new' => 'Add Project',
        'all_items' => 'All Projects',
        'add_new_item' => 'Add Project',
        'edit_item' => 'Edit Project',
        'new_item' => 'New Project',
        'view_item' => 'View Project',
        'search_item' => 'Search Projects',
        'not_found' => 'No Projects Found',
        'not_found_in_trash' => 'No Projects Found In Trash',
        'parent_item_colon' => 'Parent Project'
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => true,
        'publicly_queryable' => true,
        'query_var' => true,
        'rewrite' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'supports' => array(
            'title',
            'editor',
            'thumbnail',
        ),
        'taxonomies' => array(),
        'menu_position' => 5,
        'exclude_from_search' => false
    );

    register_post_type('boab-project', $args);

    // Add new taxonomy hierarchical
    $labels = [
        'name'              => 'Services',
        'singular_name'     => 'Service',
        'search_items'      => 'Search Services',
        'all_items'         => 'All Services',
        'parent_item'       => 'Parent Service',
        'parent_item_colon' => 'Parent Service Colon',
        'edit_item_label'   => 'Edit Service',
        'update_item'       => 'Update Service',
        'add_new_item'      => 'Add New Service',
        'new_item_name'     => 'New Service Name',
        'menu_name'         => 'Services'
    ];

    $args = [
        'hierarchical'          => true,
        'labels'                => $labels,
        'show_ui'               => true,
        'show_admin_column'     => true,
        'query_var'             => true,
        'rewrite'               => [
            'slug'  => 'solution-to'
        ]
    ];

    register_taxonomy('Service', ['boab-project'], $args);
}

add_action('init', 'boab2017_ProjectsCPT');

function boab2017_CustomTaxonomies()
{
    // Add new taxonomy hierarchical
    $labels = [
        'name'              => 'Solution To Problems',
        'singular_name'     => 'Solution To Problem',
        'search_items'      => 'Search "Solution To Problems"',
        'all_items'         => 'All "Solution To Problems"',
        'parent_item'       => 'Parent " Solution To Problem"',
        'parent_item_colon' => 'Parent "Solution To Problem" Colon',
        'edit_item_label'   => 'Edit "Solution To Problem"',
        'update_item'       => 'Update "Solution To Problem"',
        'add_new_item'      => 'Add New "Solution To Problem"',
        'new_item_name'     => 'New "Solution To Problem" Name',
        'menu_name'         => 'Solution To Problem'
    ];

    $args = [
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => [
            'slug'  => 'solution-to'
        ]
    ];

    register_taxonomy('solution-to', ['case'], $args);

    // Add new taxonomy not hierarchical
    register_taxonomy('testing', ['test'], [
        'label'         => 'Software',
        'rewrite'       => ['slug'  => 'software'],
        'hierarchical'  => false
    ]);
}

add_action('init', 'boab2017_CustomTaxonomies');

/*
    ===================================
    Custom term function
    ===================================
*/

function boab2017_CustomTerm($postID, $term)
{
    $termsList = wp_get_post_terms($postID, $term);

    $terms = '';
    foreach($termsList as $term)
    {
        $terms .= '<a href="'.get_term_link($term).'">'.$term->name.'</a>, ';
    }
    return rtrim($terms, ', ');
}
?>