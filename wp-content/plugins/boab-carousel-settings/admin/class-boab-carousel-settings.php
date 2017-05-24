<?php

/**
 * Setup current context on front-end carousel with certain settings.
 *
 * @link       http://boabdesign.com.au
 * @since      0.1.0
 *
 * @package    Boab_Carousel_Settings
 * @subpackage Boab_Carousel_Settings/admin
 */

/**
 * Setup current context on front-end carousel with certain settings.
 *
 * Defines the plugin name, version, the meta box functionality
 * and the JavaScript for loading the Media Uploader.
 *
 * @package    Boab_Carousel_Settings
 * @subpackage Boab_Carousel_Settings/admin
 * @author     John Lajer <john@thinktall.com.au>
 */
class Boab_Carousel_Settings {

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

        $this->name = 'boab-carousel-settings';
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
        add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );

    }

    /**
     * Renders the meta box on the post and pages.
     *
     * @since 0.1.0
     */
    public function add_meta_box() {

        $screens = array( 'post', 'boab-project'  );

        foreach ( $screens as $screen ) {

            add_meta_box(
                $this->name,
                'Carousel Settings',
                array( $this, 'boab_carousel_settings' ),
                $screen,
                'normal'
            );

        }

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
     * Renders the view that displays the contents for the meta box that for triggering
     * the meta box.
     *
     * @param    WP_Post    $post    The post object
     * @since    0.1.0
     */
    public function boab_carousel_settings( $post ) {
        echo '
        TESTING
        ';
    }

}