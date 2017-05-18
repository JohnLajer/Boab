<?php
/**
 * Before And After Boab Plugin
 *
 * Description
 *
 * @package   Before_And_After_Boab_Plugin
 * @author    John Lajer <john@thinktall.com.au>
 * @license   GPL-2.0+
 * @link      http://boabdesign.com.au
 * @copyright 2017 Tom McFarlin
 *
 * @wordpress-plugin
 * Plugin Name: Before And After Boab Plugin
 * Plugin URI:  TODO
 * Description: TODO
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
require_once( plugin_dir_path( __FILE__ ) . 'admin/class-before-and-after-boab-plugin.php' );

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    0.1.0
 */
function run_before_and_after_boab_plugin() {

    $plugin = new Before_And_After_Boab_Plugin();
    $plugin->run();

}
run_before_and_after_boab_plugin();