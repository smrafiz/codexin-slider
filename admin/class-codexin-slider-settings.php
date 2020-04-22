<?php
class Codexin_Slider_Settings {

	private $settings;

	private $colors;

	public function page_menu_item() {
		add_submenu_page(
			'edit.php?post_type=codexin_slider',
			'Settings',
			'Settings',
			'manage_options',
			'codexin-slider-settings',
			array( $this, 'display' )
		);
	}

	public function display () {
		if( ! current_user_can( 'manage_options' ) ) {
			wp_die('You don\'t have sufficient permissions to access this page!');
		}

		$this->settings = get_option( 'codexin_slider_settings' );
		$this->colors   = get_option( 'codexin_slider_colors' );

		$style_screen            = ( isset( $_GET['action'] ) && 'slider-colors' == $_GET['action'] ) ? true : false;
		?>

		<!-- Creating a header in the default WordPress 'wrap' container -->
		<div id="codexin_slider_settings_page" class="wrap">
			<h1><?php esc_html_e( 'Slider Settings', 'codexin' ) ?></h1>

			<h2 class="nav-tab-wrapper">
				<a href="<?php echo admin_url( 'edit.php?post_type=codexin_slider&page=codexin-slider-settings' ); ?>" class="nav-tab<?php if( ! isset( $_GET['action'] ) || isset( $_GET['action'] ) && 'slider-colors' != $_GET['action'] ) echo ' nav-tab-active'; ?>"><?php esc_html_e( 'Settings', 'codexin' ); ?></a>

				<a href="<?php echo esc_url( add_query_arg( array( 'action' => 'slider-colors' ), admin_url( 'edit.php?post_type=codexin_slider&page=codexin-slider-settings' ) ) ); ?>" class="nav-tab<?php if( $style_screen ) { echo ' nav-tab-active'; } ?>"><?php esc_html_e( 'Colors', 'codexin' ); ?></a>
			</h2> <!-- end of nav-tab-wrapper -->

			<?php settings_errors(); ?>

			<form method="post" action="options.php">
				<?php

				// Assinging settings fields for every tabs
				if( $style_screen ) {
					settings_fields( 'codexin_slider_colors' );
					do_settings_sections( 'codexin-slider-colors' );
					submit_button();
				} else {
					settings_fields( 'codexin_slider_settings' );
					do_settings_sections( 'codexin-slider-settings' );
					submit_button();
				}

				?>
			</form>
		</div><!-- end of wrap -->

		<?php
	} // create_settings_page_html ()

	public function page_init() {
		register_setting(
            'codexin_slider_settings',
            'codexin_slider_settings',
            array( $this, 'sanitize' )
		);

        add_settings_section(
            'cx_slider',
            esc_html__( '', 'codexin' ),
            array( $this, 'settings_info' ),
            'codexin-slider-settings'
		);

		add_settings_field(
            'shortcode',
            esc_html__( 'Slider Shortcode', 'codexin' ),
            array( $this, 'shortcode_callback' ),
            'codexin-slider-settings',
            'cx_slider'
		);

		add_settings_field(
            'extra_class',
            esc_html__( 'Extra Slider CSS Class', 'codexin' ),
            array( $this, 'extra_class_callback' ),
            'codexin-slider-settings',
            'cx_slider'
		);

		add_settings_field(
            'default_height',
            esc_html__( 'Slider Height', 'codexin' ),
            array( $this, 'height_callback' ),
            'codexin-slider-settings',
            'cx_slider'
		);

		add_settings_field(
            'loop',
            esc_html__( 'Enable loop?', 'codexin' ),
            array( $this, 'loop_callback' ),
            'codexin-slider-settings',
            'cx_slider'
		);

		add_settings_field(
            'autoplay',
            esc_html__( 'Enable Autoplay?', 'codexin' ),
            array( $this, 'autoplay_callback' ),
            'codexin-slider-settings',
            'cx_slider'
		);

		add_settings_field(
            'autoplay_delay',
            esc_html__( 'Autoplay Delay', 'codexin' ),
            array( $this, 'autoplay_delay_callback' ),
            'codexin-slider-settings',
            'cx_slider'
		);

		add_settings_field(
            'navigation',
            esc_html__( 'Navigation Type', 'codexin' ),
            array( $this, 'navigation_callback' ),
            'codexin-slider-settings',
            'cx_slider'
		);

		add_settings_field(
            'effect',
            esc_html__( 'Transition Effect', 'codexin' ),
            array( $this, 'effect_callback' ),
            'codexin-slider-settings',
            'cx_slider'
		);

		add_settings_field(
            'font',
            esc_html__( 'Load Font Awesome?', 'codexin' ),
            array( $this, 'font_callback' ),
            'codexin-slider-settings',
            'cx_slider'
		);

		register_setting(
            'codexin_slider_colors',
            'codexin_slider_colors',
            array( $this, 'sanitize_color' )
		);

        add_settings_section(
            'cx_slider',
            esc_html__( '', 'codexin' ),
            array( $this, 'colors_info' ),
            'codexin-slider-colors'
		);

		add_settings_field(
            'title_color',
            esc_html__( 'Title & Subtitle Color', 'codexin' ),
            array( $this, 'title_color_callback' ),
            'codexin-slider-colors',
            'cx_slider'
		);

		add_settings_field(
            'button_color',
            esc_html__( 'Button Color', 'codexin' ),
            array( $this, 'button_color_callback' ),
            'codexin-slider-colors',
            'cx_slider'
		);

		add_settings_field(
            'button_bg_color',
            esc_html__( 'Button Background Color', 'codexin' ),
            array( $this, 'button_bg_color_callback' ),
            'codexin-slider-colors',
            'cx_slider'
		);

		add_settings_field(
            'button_hover_color',
            esc_html__( 'Button Hover Color', 'codexin' ),
            array( $this, 'button_hover_color_callback' ),
            'codexin-slider-colors',
            'cx_slider'
		);

		add_settings_field(
            'button_hover_bg_color',
            esc_html__( 'Button Hover Background Color', 'codexin' ),
            array( $this, 'button_hover_bg_color_callback' ),
            'codexin-slider-colors',
            'cx_slider'
		);

		add_settings_field(
            'navigation_color',
            esc_html__( 'Arrow Navigation Color', 'codexin' ),
            array( $this, 'navigation_color_callback' ),
            'codexin-slider-colors',
            'cx_slider'
		);

		add_settings_field(
            'navigation_hover_color',
            esc_html__( 'Arrow Navigation Hover Color', 'codexin' ),
            array( $this, 'navigation_hover_color_callback' ),
            'codexin-slider-colors',
            'cx_slider'
		);

		add_settings_field(
            'pagination_color',
            esc_html__( 'Dot Pagination Color', 'codexin' ),
            array( $this, 'pagination_color_callback' ),
            'codexin-slider-colors',
            'cx_slider'
		);

		add_settings_field(
            'pagination_hover_color',
            esc_html__( 'Dot Pagination Hover Color', 'codexin' ),
            array( $this, 'pagination_hover_color_callback' ),
            'codexin-slider-colors',
            'cx_slider'
		);
	}

	public function settings_info() {
		echo '<h2>'. esc_html__( 'General Slider Settings', 'codexin' ) .'</h2>';
	}

	public function colors_info() {
		echo '<h2>'. esc_html__( 'Slider Color Settings', 'codexin' ) .'</h2>';
	}

	public function shortcode_callback() {
        printf(
            '<input onClick="this.setSelectionRange(0, this.value.length)" readonly type="text" class="regular-text" id="shortcode" name="codexin_slider_settings[shortcode]" value="%s" />',
            '[codexin_slider]'
		);

        printf( '<p><span class="description">%s</span></p>', esc_html__( 'Paste this shortcode anywhere to activate slider.', 'codexin' ) );
	}

	public function height_callback() {
        printf(
            '<input type="text" class="regular-text" id="default_height" name="codexin_slider_settings[default_height]" value="%s" />',
            isset( $this->settings['default_height'] ) ? esc_attr( $this->settings['default_height'] ) : ''
        );
        printf( '<p><span class="description">%s</span></p>', esc_html__( 'Enter Slider Height in px, % unit. Example: 550px. Default: 530px.', 'codexin' ) );
	}

	public function navigation_callback() {

		$items = array( "Arrow Navigation", "Dot Pagination", "Both", "None" );
		echo "<select id='navigation' name='codexin_slider_settings[navigation]'>";
		foreach($items as $item) {
			$value = str_replace(" ", "-", strtolower( $item) );
			$selected = ( $this->settings['navigation'] == $value ) ? 'selected="selected"' : '';
			echo "<option value='$value' $selected>$item</option>";
		}
		echo "</select>";

        printf( '<p><span class="description">%s</span></p>', esc_html__( 'Choose navigation type.', 'codexin' ) );
	}

	public function loop_callback() {

		if( $this->settings['loop'] ) {
			$checked = ' checked="checked" ';
		}

		echo "<label class='switch'><input " . $checked . " id='loop' name='codexin_slider_settings[loop]' type='checkbox' /><span class='slider round'></span></label>";

        printf( '<p class="description">%s</p>', esc_html__( 'Toggles Slider Loop. Activates loop when turned on.', 'codexin' ) );
	}

	public function effect_callback() {

		$items = array( "Slide", "Fade" );
		echo "<select id='effect' name='codexin_slider_settings[effect]'>";
		foreach($items as $item) {
			$value = str_replace(" ", "-", strtolower( $item) );
			$selected = ( $this->settings['effect'] == $value ) ? 'selected="selected"' : '';
			echo "<option value='$value' $selected>$item</option>";
		}
		echo "</select>";

        printf( '<p><span class="description">%s</span></p>', esc_html__( 'Choose Transition Effect.', 'codexin' ) );
	}

	public function autoplay_callback() {

		if( $this->settings['autoplay'] ) {
			$checked = ' checked="checked" ';
		}

		echo "<label class='switch'><input ".$checked." id='autoplay' name='codexin_slider_settings[autoplay]' type='checkbox' /><span class='slider round'></span></label>";

        printf( '<p class="description">%s</p>', esc_html__( 'Toggles Slider Autoplay. Activates autoplay when turned on.', 'codexin' ) );
	}

	public function autoplay_delay_callback() {
        printf(
            '<input type="text" class="regular-text" id="autoplay_delay" name="codexin_slider_settings[autoplay_delay]" value="%s" />',
            isset( $this->settings['autoplay_delay'] ) ? esc_attr( $this->settings['autoplay_delay'] ) : ''
        );
        printf( '<p><span class="description">%s</span></p>', esc_html__( 'Enter Autoplay Delay in miliseconds without unit. Example: 7000.', 'codexin' ) );
	}

	public function extra_class_callback() {
        printf(
            '<input type="text" class="regular-text" id="extra_class" name="codexin_slider_settings[extra_class]" value="%s" />',
            isset( $this->settings['extra_class'] ) ? esc_attr( $this->settings['extra_class'] ) : ''
        );
        printf( '<p><span class="description">%s</span></p>', esc_html__( 'Enter extra wrapper CSS class if needed.', 'codexin' ) );
	}

	public function font_callback() {

		if( $this->settings['font'] ) {
			$checked = ' checked="checked" ';
		}

		echo "<label class='switch'><input " . $checked . " id='font' name='codexin_slider_settings[font]' type='checkbox' /><span class='slider round'></span></label>";

        printf( '<p class="description" style="max-width: 400px;">%s</p>', esc_html__( 'Codexin Slider uses Font Awesome icon font. If the current theme does not load Font Awesome, you can load it from here by turning on the switch.', 'codexin' ) );
	}

	public function title_color_callback() {
		$val = ( isset( $this->colors['title_color'] ) ) ? $this->colors['title_color'] : '#fff';
		echo '<input type="text" name="codexin_slider_colors[title_color]" value="' . $val . '" class="cx-color-picker" >';

        printf( '<p><span class="description">%s</span></p>', esc_html__( 'Choose title & subtitle color', 'codexin' ) );
	}

	public function button_color_callback() {
		$val = ( isset( $this->colors['button_color'] ) ) ? $this->colors['button_color'] : '#fff';
		echo '<input type="text" name="codexin_slider_colors[button_color]" value="' . $val . '" class="cx-color-picker" >';

        printf( '<p><span class="description">%s</span></p>', esc_html__( 'Choose button color', 'codexin' ) );
	}

	public function button_bg_color_callback() {
		$val = ( isset( $this->colors['button_bg_color'] ) ) ? $this->colors['button_bg_color'] : '#cc2121';
		echo '<input type="text" name="codexin_slider_colors[button_bg_color]" value="' . $val . '" class="cx-color-picker" >';

        printf( '<p><span class="description">%s</span></p>', esc_html__( 'Choose button background color', 'codexin' ) );
	}

	public function button_hover_color_callback() {
		$val = ( isset( $this->colors['button_hover_color'] ) ) ? $this->colors['button_hover_color'] : '#fff';
		echo '<input type="text" name="codexin_slider_colors[button_hover_color]" value="' . $val . '" class="cx-color-picker" >';

        printf( '<p><span class="description">%s</span></p>', esc_html__( 'Choose button hover color', 'codexin' ) );
	}

	public function button_hover_bg_color_callback() {
		$val = ( isset( $this->colors['button_hover_bg_color'] ) ) ? $this->colors['button_hover_bg_color'] : '#252525';
		echo '<input type="text" name="codexin_slider_colors[button_hover_bg_color]" value="' . $val . '" class="cx-color-picker" >';

        printf( '<p><span class="description">%s</span></p>', esc_html__( 'Choose button hover background color', 'codexin' ) );
	}

	public function navigation_color_callback() {
		$val = ( isset( $this->colors['navigation_color'] ) ) ? $this->colors['navigation_color'] : '#e2e2e2';
		echo '<input type="text" name="codexin_slider_colors[navigation_color]" value="' . $val . '" class="cx-color-picker" >';

        printf( '<p><span class="description">%s</span></p>', esc_html__( 'Choose navigation arrow color', 'codexin' ) );
	}

	public function navigation_hover_color_callback() {
		$val = ( isset( $this->colors['navigation_hover_color'] ) ) ? $this->colors['navigation_hover_color'] : '#cc2121';
		echo '<input type="text" name="codexin_slider_colors[navigation_hover_color]" value="' . $val . '" class="cx-color-picker" >';

        printf( '<p><span class="description">%s</span></p>', esc_html__( 'Choose navigation arrow hover color', 'codexin' ) );
	}

	public function pagination_color_callback() {
		$val = ( isset( $this->colors['pagination_color'] ) ) ? $this->colors['pagination_color'] : '#e2e2e2';
		echo '<input type="text" name="codexin_slider_colors[pagination_color]" value="' . $val . '" class="cx-color-picker" >';

        printf( '<p><span class="description">%s</span></p>', esc_html__( 'Choose pagination dot color', 'codexin' ) );
	}

	public function pagination_hover_color_callback() {
		$val = ( isset( $this->colors['pagination_hover_color'] ) ) ? $this->colors['pagination_hover_color'] : '#cc2121';
		echo '<input type="text" name="codexin_slider_colors[pagination_hover_color]" value="' . $val . '" class="cx-color-picker" >';

        printf( '<p><span class="description">%s</span></p>', esc_html__( 'Choose pagination dot hover color', 'codexin' ) );
	}

    public function sanitize( $input )  {

		$output = array();

		foreach( $input as $key => $value ) {
			if( isset( $input[$key] ) ) {
				$output[$key] = strip_tags( stripslashes( $input[ $key ] ) );
			}
		}

		return apply_filters( 'codexin_slider_validate_inputs', $output, $input );
	}

	public function sanitize_color( $input ) {

		$output = array();

		foreach( $input as $key => $value ) {
			if( isset( $input[$key] ) ) {
				$color = strip_tags( stripslashes( $input[ $key ] ) );

				// Check if is a valid hex color
				if( FALSE === $this->check_color( $color ) ) {

					// Set the error message
					add_settings_error( 'codexin_slider_colors', 'cx_color_error', 'Insert a valid color', 'error' );

					// Get the default value
					$output[$key] = $this->colors[$key];
				} else {
					$output[$key] = $color;
				}
			}
		}

		return apply_filters( 'codexin_slider_validate_colors', $output, $input );
	}

	/**
	 * Function that will check if value is a valid HEX color.
	 */
	public function check_color( $value ) {

		if ( preg_match( '|^#([A-Fa-f0-9]{3}){1,2}$|', $value ) ) {
			return true;
		}

		return false;
	}

	public function settings_link( $links ) {
		$settings_link = '<a href="edit.php?post_type=codexin_slider&page=codexin-slider-settings">Settings</a>';
		array_push( $links, $settings_link );

		return $links;
	}

}
