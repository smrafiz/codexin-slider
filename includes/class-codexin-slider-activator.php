<?php

/**
 * Fired during plugin activation
 *
 * @link       https://codexin.com
 * @since      1.0.0
 *
 * @package    Codexin_Slider
 * @subpackage Codexin_Slider/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Codexin_Slider
 * @subpackage Codexin_Slider/includes
 * @author     Codexins <info@codexin.com>
 */
class Codexin_Slider_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		flush_rewrite_rules();
	}

}
