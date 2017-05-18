<?php

/**
Plugin Name:    Boab Projects
Version:        0.0.1
Description:    Create projects for the Boab Website!
Author:         John Lajer
 */

add_action('init', 'BoabProjects_Init');
function BoabProjects_Init()
{
    wp_enqueue_style('jquery-ui-css', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css');

    wp_enqueue_script( 'boab-projects-jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js', [], '3.2.1', false );
    //wp_enqueue_script('bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js');
    wp_enqueue_script('boab-projects-plugin', plugin_dir_url( __FILE__ ).'static/js/boab-projects-plugin.js', array('jquery'));

    BoabProjects_RegisterCPT();
}

function BoabProjects_RegisterCPT()
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

/**
 * Meta boxes
 */

function BoabProjects_AddMetaBox()
{
    add_meta_box('meta_data', 'Site Build', 'BoabProjects_MetaData', 'boab-project', 'normal', 'default');
    add_meta_box('logoes', 'Logoes', 'BoabProjects_Logoes', 'boab-project', 'normal', 'high');
}
add_action('add_meta_boxes', 'BoabProjects_AddMetaBox');

function BoabProjects_Logoes($post)
{
    wp_nonce_field('BoabProjects_SaveProjectData', 'boab_project_data_logoes_nonce');

    $value = esc_attr( get_post_meta($post->ID, '_boab_projects_logo_before', true) );

    echo '
    <table border="0" cellspacing="0" cellpadding="6">
        <tr>
            <td><label for="boab_projects_logo_before">Logo before: </label></td>
            <td><input type="file" id="boab_projects_logo_before" name="boab_projects_logo_before" value="" /></td>
        </tr>
        <tr>
            <td><label for="boab_projects_logo_after">Logo after: </label></td>
            <td><input type="file" id="boab_projects_logo_after" name="boab_projects_logo_after" value="" /></td>
        </tr>
    </table>
    ';
}

function BoabProjects_MetaData($post)
{
    wp_nonce_field('BoabProjects_SaveProjectData', 'boab_project_data_meta_box_nonce');

    $value = esc_attr( get_post_meta($post->ID, '_contact_client_value_key', true) );

    echo '
    <table border="0" cellspacing="0" cellpadding="6">
        <tr>
            <td><label for="boab_projects_contact_client">Client name: </label></td>
            <td><input type="text" id="boab_projects_contact_client" name="boab_projects_contact_client" value="'.$value.'" /></td>
        </tr>
        <tr>
            <td><label for="boab_projects_add_block">Add content block: </label></td>
            <td>
                <select id="boab_projects_add_block">
                    <option value="gallery">Gallery</option>
                    <option value="3-img-content">3 Image content area</option>
                    <option value="4-img-content">4 Image content area</option>
                </select>
                <input type="button" id="boab_project_add_block_button" value="Add" />
            </td>
        </tr>
    </table>
    <div id="boab_projects_blocks_container">
    
    </div>
    ';
}

add_action('save_post', 'BoabProjects_SaveProjectData');
function BoabProjects_SaveProjectData($post_id)
{
    if(defined('DOING_AUTOSAVE') && 'DOING_AUTOSAVE'){
        return;
    }

    if(!current_user_can('edit_post', $post_id)){
        return;
    }

    if(isset($_POST['boab_project_data_meta_box_nonce'])) {
        if(wp_verify_nonce($_POST['boab_project_data_meta_box_nonce'], 'BoabProjects_SaveProjectData')) {
            $clientName = sanitize_text_field($_POST['boab_projects_contact_client']);

            update_post_meta($post_id, '_contact_client_value_key', $clientName);
        }
    }

    if(isset($_POST['boab_project_data_logoes_nonce'])) {
        if(wp_verify_nonce($_POST['boab_project_data_logoes_nonce'], 'BoabProjects_SaveProjectData')) {
            $imageBefore    = $_POST['boab_projects_logo_before'];
            $imageAfter     = $_POST['boab_projects_logo_after'];

            if(!empty($imageBefore))
                update_post_meta($post_id, '_boab_projects_logo_before', $imageBefore);

            if(!empty($imageAfter))
                update_post_meta($post_id, '_boab_projects_logo_after', $imageAfter);
        }
    }


}

add_action( 'wp_ajax_add_content_block', 'BoabProjects_AddContentBlockAJAX' );
function BoabProjects_AddContentBlockAJAX()
{
    wp_send_json_success(
        BoabProjects_RenderContentBlock(
            esc_attr($_POST['type'])
        )
    );

    wp_die();
}

function BoabProjects_RenderContentBlock($strType)
{
    switch($strType)
    {
        case 'gallery' :
            $strContentBlock = BoabProjects_RenderContentBlockGallery();
            break;
        case '3-img-content' :
            $strContentBlock = BoabProjects_RenderContentBlockThreeImg();
            break;
        case '4-img-content' :
            $strContentBlock = BoabProjects_RenderContentBlockFourImg();
            break;
        default :
            $strContentBlock = 'An error occured, call John! code-finder: 854-541';
            break;
    }

    return $strContentBlock;
}

function BoabProjects_RenderContentBlockGallery()
{
    return '
    <li>
        
    </li>
    ';
}

function BoabProjects_RenderContentBlockThreeImg()
{
    return '
        2
    ';
}

function BoabProjects_RenderContentBlockFourImg()
{
    return '
        3
    ';
}
/*
function boab_loadDependencies()
{
    require_once plugin_dir_path( dirname( __FILE__ ) ) . 'boab-projects-plugin/include/class-boab-projects-plugin.php';
}
/*
function boab_AddMenu()
{
    add_menu_page('Contact test', 'Contact test', 'manage_options', 'boab-contact', 'boab_addFunctionality');
    //add_submenu_page('boab-contact', 'Contact stuff', 'Contact stuff', 'manage_options', 'boab-contact-stuff', 'boabContactStuff');
}

function boab_addFunctionality()
{
    $chk = '';
    if(!empty($_POST)) :
        $strText = $_POST['textytext'];

        if(get_option('texty_text') != trim($strText)) :

            $chk = update_option('texty_text', trim($strText));

        endif;

    endif;

    $strSuccess = '';
    if(!empty($_POST) && !empty($chk)) :
        $strSuccess = '
        <div id="message" class="updated below-h2">
            <p>SUCCESS</p>
        </div>
        ';
    endif;

    echo '
    <div class="wrap">
        <h2>Stuff</h2>
        '.$strSuccess.'
        <form method="post" action="">
            <input type="text" name="textytext" value="'.get_option('texty_text').'" />
            <input type="submit" value="submit" />
        </form>
    </div>
    ';
}

function boabContactStuff()
{
    echo 'SECRECY!!!';
}

function boab_Footer()
{
    echo '<div>'.get_option('texty_text').'</div>';
}
add_action('wp_footer', 'boab_Footer');*/
?>
