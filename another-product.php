<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://greencraft.design/another-product
 * @since             1.0.0
 * @package           Another_Product
 *
 * @wordpress-plugin
 * Plugin Name:       Another Product
 * Plugin URI:        http://greencraft.design/
 * Description:       Adds an area to suggest another product via shortcode on product page
 * Version:           1.0.0
 * Author:            Jaime Manikas
 * Author URI:        http://greencraft.design
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       another-product
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'ANOTHER_PRODUCT_VERSION', '1.0.0' );
$path_array  = wp_upload_dir();
$upload_url=$path_array['baseurl'];
$upload_dir=$path_array['basedir'];
define('Another_Product_DIR', plugin_dir_path( __FILE__ ) );
define('Another_Product_URI', plugin_dir_url( __FILE__ ) );
define('Another_Product_UPLOAD_URI', $upload_url);
define('Another_Product_UPLOAD_DIR', $upload_dir);

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-another-product-activator.php
 */
function activate_another_product() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-another-product-activator.php';
	Another_Product_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-another-product-deactivator.php
 */
function deactivate_another_product() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-another-product-deactivator.php';
	Another_Product_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_another_product' );
register_deactivation_hook( __FILE__, 'deactivate_another_product' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-another-product.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_another_product() {

	$plugin = new Another_Product();
	$plugin->run();

}
run_another_product();
