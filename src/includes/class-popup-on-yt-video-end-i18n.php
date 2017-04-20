<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       www.opushive.com
 * @since      1.0.0
 *
 * @package    Popup_On_Yt_Video_End
 * @subpackage Popup_On_Yt_Video_End/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Popup_On_Yt_Video_End
 * @subpackage Popup_On_Yt_Video_End/includes
 * @author     Opus Hive <valentine@opushive.com>
 */
class Popup_On_Yt_Video_End_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'popup-on-yt-video-end',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
