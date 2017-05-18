<?php

/**
 * The dashboard-specific functionality of the plugin.
 *
 * @link       www.boabdesign.dk
 * @since      0.1.0
 *
 * @package    Before_And_After_Boab_Plugin
 * @subpackage Before_And_After_Boab_Plugin/Admin
 */

/**
 * The dashboard-specific functionality of the plugin.
 *
 * Defines the plugin name, version, the meta box functionality
 * and the JavaScript for loading the Media Uploader.
 *
 * @package    Before_And_After_Boab_Plugin
 * @subpackage Before_And_After_Boab_Plugin/Admin
 * @author     John Lajer <john@thinktall.com.au>
 */
class Before_And_After_Boab_Plugin {

    /**
     * The ID of this plugin.
     *
     * @since    0.1.0
     * @access   private
     * @var      string    $name    The ID of this plugin.
     */
    private $name;

    /**
     * The current version of the plugin.
     *
     * @since    0.1.0
     * @access   private
     * @var      string    $version    The version of the plugin
     */
    private $version;

    /**
     * Initializes the plugin by defining the properties.
     *
     * @since 0.1.0
     */
    public function __construct() {

        $this->name = 'before-and-after-boab-plugin';
        $this->version = '0.1.0';

    }

    /**
     * Defines the hooks that will register and enqueue the JavaScript
     * and the meta box that will render the option.
     *
     * @since 0.1.0
     */
    public function run() {

        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_styles' ) );
        add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );

        add_action( 'save_post', array( $this, 'save_post' ) );
        //add_filter( 'the_content', array( $this, 'some_content_method' ) );

    }

/*
    public function some_content_method( $content ) {

        var_dump('Why u no?');
        $content .= 'Why u no work?';
        return $content;

        // We only care about appending the image to single pages
        if ( is_single() ) {
            var_dump('asfsdafsafdsafs');
            // In order to append an image, there has to be at least a source attribute
            if ( '' !== ( $src = get_post_meta( get_the_ID(), 'thumbnail-src', true ) ) ) {

                // read the remaining attributes even if they are empty strings
                $alt = get_post_meta( get_the_ID(), 'thumbnail-alt', true );
                $title = get_post_meta( get_the_ID(), 'thumbnail-title', true );

                // create the image element within its own container
                $img_html = '<p id="footer-thumbnail">';
                $img_html .= "<img src='$src' alt='$alt' title='$title' />";
                $img_html .= '</p><!-- #footer-thumbnail -->';

                // append it to the content
                $content .= $img_html;

            }

        }

        return $content;

    }*/

    /**
     * Renders the meta box on the post and pages.
     *
     * @since 0.1.0
     */
    public function add_meta_box() {

        $screens = array( 'boab-project' );

        foreach ( $screens as $screen ) {

            add_meta_box(
                $this->name,
                'Before And_After Logo',
                array( $this, 'display_before_and_after_boab_plugin' ),
                $screen,
                'side'
            );

        }

    }

    /**
     * Registers the stylesheets for handling the meta box
     *
     * @since 0.2.0
     */
    public function enqueue_styles() {

        wp_enqueue_style(
            $this->name,
            plugin_dir_url( __FILE__ ) . 'css/admin.css',
            array()
        );

    }

    /**
     * Registers the JavaScript for handling the media uploader.
     *
     * @since 0.1.0
     */
    public function enqueue_scripts() {

        wp_enqueue_media();

        wp_enqueue_script(
            $this->name,
            plugin_dir_url( __FILE__ ) . 'js/admin.js',
            array( 'jquery' ),
            $this->version,
            'all'
        );

    }

    /**
     * Sanitized and saves the post featured image meta data specific with this post.
     *
     * @param    int    $post_id    The ID of the post with which we're currently working.
     * @since 0.2.0
     */
    public function save_post( $post_id ) {

        # Before Boab Logo
        if ( isset( $_REQUEST['before-thumbnail-src'] ) ) {
            update_post_meta( $post_id, 'before-thumbnail-src', sanitize_text_field( $_REQUEST['before-thumbnail-src'] ) );
        }

        if ( isset( $_REQUEST['before-thumbnail-title'] ) ) {
            update_post_meta( $post_id, 'before-thumbnail-title', sanitize_text_field( $_REQUEST['before-thumbnail-title'] ) );
        }

        if ( isset( $_REQUEST['before-thumbnail-alt'] ) ) {
            update_post_meta( $post_id, 'before-thumbnail-alt', sanitize_text_field( $_REQUEST['before-thumbnail-alt'] ) );
        }

        # After Boab Logo
        if ( isset( $_REQUEST['after-thumbnail-src'] ) ) {
            update_post_meta( $post_id, 'after-thumbnail-src', sanitize_text_field( $_REQUEST['after-thumbnail-src'] ) );
        }

        if ( isset( $_REQUEST['after-thumbnail-title'] ) ) {
            update_post_meta( $post_id, 'after-thumbnail-title', sanitize_text_field( $_REQUEST['after-thumbnail-title'] ) );
        }

        if ( isset( $_REQUEST['after-thumbnail-alt'] ) ) {
            update_post_meta( $post_id, 'after-thumbnail-alt', sanitize_text_field( $_REQUEST['after-thumbnail-alt'] ) );
        }
    }

    /**
     * Renders the view that displays the contents for the meta box that for triggering
     * the meta box.
     *
     * @param    WP_Post    $post    The post object
     * @since    0.1.0
     */
    public function display_before_and_after_boab_plugin( $post ) {
        include_once( dirname( __FILE__ ) . '/views/admin.php' );
    }

}