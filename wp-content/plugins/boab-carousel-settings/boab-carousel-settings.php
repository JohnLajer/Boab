<?php
/**
 * Acme Footer Image
 *
 * Setup current context on front-end carousel with certain settings.
 *
 * @package   Boab_Carousel_Settings
 * @author    John Lajer <john@thinktall.com.au>
 * @license   GPL-2.0+
 * @link      http://boabdesign.com.au
 * @copyright 2017 John Lajer
 *
 * @wordpress-plugin
 * Plugin Name: Boab Carousel Settings
 * Plugin URI:  TODO
 * Description: Setup current context on front-end carousel with certain settings.
 * Version:     0.1.0
 * Author:      John Lajer
 * Author URI:  http://boabdesign.com.au
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

/**
 * Includes the core plugin class for executing the plugin.
 */
require_once( plugin_dir_path( __FILE__ ) . 'admin/class-boab-carousel-settings.php' );

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    0.1.0
 */
function run_boab_carousel_settings() {

    $plugin = new Boab_Carousel_Settings();
    $plugin->run();

}
run_boab_carousel_settings();