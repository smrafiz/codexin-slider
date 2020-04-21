<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://codexin.com
 * @since      1.0.0
 *
 * @package    Codexin_Slider
 * @subpackage Codexin_Slider/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Codexin_Slider
 * @subpackage Codexin_Slider/public
 * @author     Codexins <info@codexin.com>
 */
class Codexin_Slider_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->load_dependencies();

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Codexin_Slider_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Codexin_Slider_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		if( get_option( 'codexin_slider_settings' )['font'] ) {
			wp_enqueue_style( 'font-awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
		}

		wp_enqueue_style( 'swiper', plugin_dir_url( __FILE__ ) . 'css/swiper.min.css', array(), '5.3.7', 'all' );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/codexin-slider-public.css', array(), $this->version, 'all' );
		wp_add_inline_style( $this->plugin_name, $this->slider_styles() );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Codexin_Slider_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Codexin_Slider_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( 'swiper', plugin_dir_url( __FILE__ ) . 'js/swiper.min.js', array( 'jquery' ), '5.3.7', false );
		wp_register_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/codexin-slider-public.js', array( 'jquery', 'swiper' ), $this->version, false );

		$vars = array(
			'loop'       => esc_html( get_option( 'codexin_slider_settings' )['loop'] ),
			'effect'       => esc_html( get_option( 'codexin_slider_settings' )['effect'] ),
			'autoplay'       => esc_html( get_option( 'codexin_slider_settings' )['autoplay'] ),
			'autoplay_delay' => esc_html( get_option( 'codexin_slider_settings' )['autoplay_delay'] ),
		);

		wp_localize_script( $this->plugin_name, 'codexin_slider_vars', $vars);

		wp_enqueue_script( $this->plugin_name );

	}

	/**
	 * Loading files.
	 *
	 * @since    1.0.0
	 */
	public function load_dependencies() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) .  'public/class-codexin-slider-shortcodes.php';
	}

	/**
	 * Inline Styles.
	 *
	 * @since    1.0.0
	 */
	public function slider_styles() {
		$height = ! empty( get_option( 'codexin_slider_settings' )['default_height'] ) ?  get_option( 'codexin_slider_settings' )['default_height'] : '530px';
		$title_c = ! empty( get_option( 'codexin_slider_colors' )['title_color'] ) ? get_option( 'codexin_slider_colors' )['title_color'] : '#fff';
		$button_c = ! empty( get_option( 'codexin_slider_colors' )['button_color'] ) ? get_option( 'codexin_slider_colors' )['button_color'] : '#fff';
		$button_bg_c = ! empty( get_option( 'codexin_slider_colors' )['button_bg_color'] ) ? get_option( 'codexin_slider_colors' )['button_bg_color'] : '#cc2121';
		$button_hover_c = ! empty( get_option( 'codexin_slider_colors' )['button_hover_color'] ) ? get_option( 'codexin_slider_colors' )['button_hover_color'] : '#fff';
		$button_hover_bg_c = ! empty( get_option( 'codexin_slider_colors' )['button_hover_bg_color'] ) ? get_option( 'codexin_slider_colors' )['button_hover_bg_color'] : '#252525';
		$navigation_c = ! empty( get_option( 'codexin_slider_colors' )['navigation_color'] ) ? get_option( 'codexin_slider_colors' )['navigation_color'] : '#e2e2e2';
		$navigation_hover_c = ! empty( get_option( 'codexin_slider_colors' )['navigation_hover_color'] ) ? get_option( 'codexin_slider_colors' )['navigation_hover_color'] : '#cc2121';
		$pagination_c = ! empty( get_option( 'codexin_slider_colors' )['pagination_color'] ) ? get_option( 'codexin_slider_colors' )['pagination_color'] : '#e2e2e2';
		$pagination_hover_c = ! empty( get_option( 'codexin_slider_colors' )['pagination_hover_color'] ) ? get_option( 'codexin_slider_colors' )['pagination_hover_color'] : '#cc2121';

		$styles = '';

        $slider = array(
            '#primary_slider',
		);

        $title = array(
			'#primary_slider .slide-content .main-title',
			'#primary_slider .slide-content .subtitle',
		);

        $button = array(
			'#primary_slider .slide-content .slide-button a',
		);

        $button_hover = array(
			'#primary_slider .slide-content .slide-button a:hover',
			'#primary_slider .slide-content .slide-button a:focus',
		);

        $arrow = array(
			'#primary_slider .swiper-arrow',
		);

        $arrow_hover = array(
			'#primary_slider .swiper-arrow:hover',
		);

        $dot = array(
			'#primary_slider .swiper-pagination .swiper-pagination-bullet',
		);

        $dot_hover = array(
			'#primary_slider .swiper-pagination .swiper-pagination-bullet:hover',
			'#primary_slider .swiper-pagination .swiper-pagination-bullet-active',
		);

		$styles .= implode( $slider, ',' ).'{ height: '. esc_html( $height ) .'; }';
		$styles .= implode( $title, ',' ).'{ color: '. $this->sanitize_color( $title_c ) .'; }';
		$styles .= implode( $button, ',' ).'{ color: '. $this->sanitize_color( $button_c ) .'; }';
		$styles .= implode( $button, ',' ).'{ background-color: '. $this->sanitize_color( $button_bg_c ) .'; }';
		$styles .= implode( $button_hover, ',' ).'{ color: '. $this->sanitize_color( $button_hover_c ) .'; }';
		$styles .= implode( $button_hover, ',' ).'{ background-color: '. $this->sanitize_color( $button_hover_bg_c ) .'; }';
		$styles .= implode( $arrow, ',' ).'{ color: '. $this->sanitize_color( $navigation_c ) .'; }';
		$styles .= implode( $arrow_hover, ',' ).'{ color: '. $this->sanitize_color( $navigation_hover_c ) .'; }';
		$styles .= implode( $dot, ',' ).'{ background-color: '. $this->sanitize_color( $pagination_c ) .'; }';
		$styles .= implode( $dot_hover, ',' ).'{ background-color: '. $this->sanitize_color( $pagination_hover_c ) .'; }';

		return $styles;
	}

    /**
     * Helper method to sanitize hex colors
     *
     * @param   string  $color  The color code
     * @return  string
	 * @access  private
     * @since   v1.0
     */
    private function sanitize_color( $color ) {
        if ( '' === $color ) {
            return '';
        }

        // make sure the color starts with a hash
        $color = '#' . ltrim( $color, '#' );

        // 3 or 6 hex digits, or the empty string.
        if ( preg_match( '|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) ) {
            return $color;
        }

        return null;
    }

}
