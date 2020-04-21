<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://codexin.com
 * @since      1.0.0
 *
 * @package    Codexin_Slider
 * @subpackage Codexin_Slider/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Codexin_Slider
 * @subpackage Codexin_Slider/includes
 * @author     Codexins <info@codexin.com>
 */
class Codexin_Slider_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		flush_rewrite_rules();
	}

}
