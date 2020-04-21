<?php
class Codexin_Slider_Meta_Boxes {

	private $types = array( 'codexin_slider' );

	public function add( $post_type ) {

		if( in_array( $post_type, $this->types ) ) {
			add_meta_box(
				'cx_slider_metas',
				esc_html__( 'Slide Settings', 'codexin_slider' ),
				array($this, 'slide_display'),
				$post_type,
				'normal',
				'high'
			);
		}
	}

	public function slide_display( $post ) {
		wp_nonce_field( basename(__FILE__), 'cx_slider_nonce' );
		$title = get_post_meta($post->ID, 'cx_slider_title', true);
		$subtitle = get_post_meta($post->ID, 'cx_slider_subtitle', true);
		$show_btn = get_post_meta($post->ID, 'cx_slider_show_toggle', true);
		$button_text = get_post_meta($post->ID, 'cx_slider_button_text', true);
		$button_link = get_post_meta($post->ID, 'cx_slider_button_link', true);
		$content_animation = get_post_meta($post->ID, 'cx_slider_animation', true);

		$html = '';
		ob_start();
		?>

		<div class="codexin-slider-metabox">
			<label>
				<div class="title-desc">
					<span>Slide Title</span>
					<p class="description">Enter Slide Title</p>
				</div>
				<div class="inputs">
					<input type="text" name="cx_slider_title" value="<?php echo esc_attr( $title ) ?>" />
					<p class="description">Note: You can write HTML code here.</p>
				</div>

			</label>
		</div>

		<div class="codexin-slider-metabox">
			<label>
				<div class="title-desc">
					<span>Slide Subtitle</span>
					<p class="description">Enter Slide Subtitle</p>
				</div>
				<div class="inputs">
					<textarea name="cx_slider_subtitle"/><?php echo esc_html( $subtitle ) ?></textarea>
					<p class="description">Note: You can write HTML code here.</p>
				</div>
			</label>
		</div>

		<div class="codexin-slider-metabox toggle-switch">
			<label>
				<div class="title-desc">
					<span>Disable Button?</span>
				</div>
				<div class="inputs">
					<label class="switch">
						<input type="checkbox" name="cx_slider_show_toggle" value="1" <?php checked(1, $show_btn, true); ?>/>
						<span class='slider round'></span>
					</label>
					<p class="description">Toggles slider button. Hides button when turned on.</p>
				</div>
			</label>
		</div>

		<div class="codexin-slider-metabox">
			<label>
				<div class="title-desc">
					<span>Button Text</span>
					<p class="description">Enter Button Title</p>
				</div>
				<div class="inputs">
					<input type="text" name="cx_slider_button_text" value="<?php echo esc_attr( $button_text ) ?>" />
					<p class="description">Note: Button will be disabled if this field is kept empty.</p>
				</div>
			</label>
		</div>

		<div class="codexin-slider-metabox">
			<label>
				<div class="title-desc">
					<span>Button URL</span>
					<p class="description">Enter Button URL</p>
				</div>
				<div class="inputs">
					<input type="text" name="cx_slider_button_link" value="<?php echo esc_attr( $button_link ) ?>" />
					<p class="description">Example: https://google.com. <br>You can also enter relative URL such as '/blog'</p>
				</div>
			</label>
		</div>

		<div class="codexin-slider-metabox">
			<label>
				<div class="title-desc">
					<span>Slide Content Animation:</span>
					<p class="description">Cloose Slide Content Animation</p>
				</div>
				<div class="inputs">
					<select name="cx_slider_animation" id="cx_slider_animation">
						<option value="animation-left" <?php selected( $content_animation, 'animation-left' ); ?>>Fade-In Left</option>
						<option value="animation-right" <?php selected( $content_animation, 'animation-right' ); ?>>Fade-In Right</option>
						<option value="animation-up" <?php selected( $content_animation, 'animation-up' ); ?>>Fade-In Up</option>
						<option value="animation-down" <?php selected( $content_animation, 'animation-down' ); ?>>Fade-In Down</option>
						<option value="animation-zoom" <?php selected( $content_animation, 'animation-zoom' ); ?>>Zoom-In</option>
					</select>
				</div>
			</label>
		</div>


		<?php

		$html = ob_get_clean();

		echo $html;
	}

	public function save( $post_id ) {
		if( ! isset( $_POST['cx_slider_nonce'] ) || ! wp_verify_nonce( $_POST['cx_slider_nonce'], basename( __FILE__ ) ) ) {
			return;
		}

		if( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		$metas_to_be_saved = array(
			// Slide Settings.
			'cx_slider_title'	  	=> wp_kses_post( $_POST['cx_slider_title'] ),
			'cx_slider_subtitle'  	=> wp_kses_post( $_POST['cx_slider_subtitle'] ),
			'cx_slider_show_toggle'  	=> $_POST['cx_slider_show_toggle'],
			'cx_slider_button_text' => sanitize_text_field( $_POST['cx_slider_button_text'] ),
			'cx_slider_button_link' => esc_url_raw( $_POST['cx_slider_button_link'] ),
			'cx_slider_animation'  	=> sanitize_text_field( $_POST['cx_slider_animation'] ),
		);

		foreach( $metas_to_be_saved as $meta_key => $meta_value ) {
			if( $meta_value ) {
				update_post_meta( $post_id, $meta_key, $meta_value );
			} else {
				delete_post_meta( $post_id, $meta_key );
			}
		}
	}
}
