<?php
class Codexin_slider_Shortcodes {

	public function register() {
		$shortcodes = array(
			'codexin_slider'
		);

		foreach ( $shortcodes as $shortcode ) :
			add_shortcode( $shortcode, array($this, $shortcode . '_shortcode' ));
		endforeach;
	}

	/**
	* Syntax:
	* [codexin_slider]
	*
	*/
	function codexin_slider_shortcode( $atts, $content = null ) {
		extract(shortcode_atts(array(
		), $atts));

		$result = '';

		ob_start();

		$extra_class = esc_attr( get_option( 'codexin_slider_settings' )['extra_class'] );
		$nav_type = esc_html( get_option( 'codexin_slider_settings' )['navigation'] );
		$arrow = false;
		$dot = false;

		if( 'arrow-navigation' === $nav_type ) {
			$arrow = true;
		} elseif( 'dot-pagination' === $nav_type ) {
			$dot = true;
		} elseif( 'both' === $nav_type ) {
			$arrow = true;
			$dot = true;
		} elseif( 'none' === $nav_type ) {
			$arrow = false;
			$dot = false;
		} else {
			$arrow = true;
		}

		$css_class = 'swiper-container';
		$css_class .= ' ' . $extra_class;
		?>

		<div id="primary_slider" class="<?php echo esc_attr( $css_class ); ?>">

			<!-- Slides -->
			<div class="swiper-wrapper">

				<?php
					$args = array(
						'post_type'		 => 'codexin_slider',
						'posts_per_page' => -1,
						'post_status'	 => 'publish'
					);

					$data = new WP_Query( $args );

					if( $data->have_posts() ) {
						//Start loop here...
						while( $data->have_posts() ) {
							$data->the_post();

							$title = get_post_meta( get_the_ID(), 'cx_slider_title', true);
							$subtitle = get_post_meta( get_the_ID(), 'cx_slider_subtitle', true);
							$show_btn = get_post_meta( get_the_ID(), 'cx_slider_show_toggle', true);
							$btn_link = get_post_meta( get_the_ID(), 'cx_slider_button_link', true);
							$btn_text = get_post_meta( get_the_ID(), 'cx_slider_button_text', true);
							$content_animation = get_post_meta( get_the_ID(), 'cx_slider_animation', true);
							$content_class = get_post_meta( get_the_ID(), 'cx_slider_class', true);
							$anim_class = '';

							switch( $content_animation ) {
								case 'animation-left':
									$anim_class = ' layer-animation-left';
									break;

								case 'animation-right':
									$anim_class = ' layer-animation-right';
									break;

								case 'animation-down':
									$anim_class = ' layer-animation-down';
									break;

								case 'animation-up':
									$anim_class = ' layer-animation-up';
									break;

								case 'animation-zoom':
									$anim_class = ' layer-animation-zoom';
									break;

								default:
									$anim_class = ' layer-animation-left';
									break;
							}

							?>
								<div class="swiper-slide bg-img-wrapper<?php echo ! empty( $content_class ) ? ' ' . esc_attr( $content_class ) : ''; ?>">
									<div class="slide-inner image-placeholder pos-r">
										<img src="<?php echo get_the_post_thumbnail_url( get_the_ID(),'full'); ?>" class="visually-hidden" alt="Slider Image">
										<div class="container">
											<div class="row">
												<div class="col-lg-12 pos-s">
													<div class="slide-content<?php echo esc_attr( $anim_class ); ?>">
														<?php if( ! empty( $title ) ) { ?>
															<h1 class="main-title"><?php echo $title ?></h1>
														<?php } ?>
														<?php if( ! empty( $subtitle ) ) { ?>
															<p class="subtitle"><?php echo $subtitle ?></p>
														<?php } ?>
														<?php if( ! $show_btn && ! empty( $btn_text ) ) { ?>
															<div class="slide-button">
																<a href="<?php echo esc_url($btn_link); ?>" title="<?php echo $btn_text; ?>"><?php echo $btn_text; ?></a>
															</div>
														<?php } ?>
													</div> <!-- end of slide-content -->
												</div>
											</div>
										</div>
									</div> <!-- end of slider-inner -->
								</div> <!-- end of swiper-slide -->
						<?php
						}
						?>
						<?php
					} //End check-posts if()....
					wp_reset_postdata();

				?>
			</div> <!-- end of swiper-slide -->

			<?php
			if( $arrow ) {
			?>
				<!-- Slider Navigation -->
				<div class="swiper-arrow next slide"><i class="fa fa-angle-right"></i></div>
				<div class="swiper-arrow prev slide"><i class="fa fa-angle-left"></i></div>
			<?php
			}

			if( $dot ) {
			?>
				<!-- Slider Pagination -->
				<div class="swiper-pagination"></div>
			<?php
			}
			?>
		</div>


		   <?php $result .= ob_get_clean();
		   return $result;
	}

}
