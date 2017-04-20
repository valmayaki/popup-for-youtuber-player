<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              www.opushive.com
 * @since             1.0.3
 * @package           Popup_On_Yt_Video_End
 *
 * @wordpress-plugin
 * Plugin Name:       PopUp on Youtube Video End
 * Plugin URI:        www.opushive.com
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Opus Hive
 * Author URI:        www.opushive.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       popup-on-yt-video-end
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-popup-on-yt-video-end-activator.php
 */
function activate_popup_on_yt_video_end() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-popup-on-yt-video-end-activator.php';
	Popup_On_Yt_Video_End_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-popup-on-yt-video-end-deactivator.php
 */
function deactivate_popup_on_yt_video_end() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-popup-on-yt-video-end-deactivator.php';
	Popup_On_Yt_Video_End_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_popup_on_yt_video_end' );
register_deactivation_hook( __FILE__, 'deactivate_popup_on_yt_video_end' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-popup-on-yt-video-end.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_popup_on_yt_video_end() {

	$plugin = new Popup_On_Yt_Video_End();
	$plugin->run();

}
run_popup_on_yt_video_end();
