<?php
/**
 * Boab Related Posts
 *
 * Attach related posts to a post!
 *
 * @package   Boab_Related_Posts
 * @author    John Lajer <john@thinktall.com.au>
 * @license   GPL-2.0+
 * @link      http://boabdesign.com.au
 * @copyright 2017 John Lajer
 *
 * @wordpress-plugin
 * Plugin Name: Boab Related Posts
 * Plugin URI:  TODO
 * Description: Attach related posts to a post!
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
require_once( plugin_dir_path( __FILE__ ) . 'admin/class-boab-related-posts.php' );

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    0.1.0
 */
function run_boab_related_posts() {

    $plugin = new Boab_Related_posts();
    $plugin->run();

}
run_boab_related_posts();
?>