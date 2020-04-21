<?php
class Codexin_Slider_Custom_Post_Type {

	public function register() {
		$labels = array(
			'name'                  => 'Slider',
			'singular_name'         => 'Slider',
			'add_new'               => 'Add New',
			'all_items'             => 'All Slides',
			'add_new_item'          => 'Add New Slide',
			'edit_item'             => 'Edit Slide',
			'new_item'              => 'New Slide',
			'view_item'             => 'View Slide',
			'search_item'           => 'Search Slides',
			'not_found'             => 'No Slides Found',
			'not_found_in_trash'    => 'No Slides Found In Trash',
			'parent_item_colon'     => 'Parent Slide'
		);

		$args = array (
			'labels'    => $labels,
			'public'    => true,
			'has_archive' => false,
			'publicly_queryable' => true,
			'query_var'     => true,
			're-write'      => true,
			'capability_type'   => 'post',
			'hierarchical'  => false,
			'menu_icon'  => 'dashicons-images-alt2',
			'supports' => array (
				'title',
				'thumbnail',
			),
			'menu_position' => 5,
			'exclude_from_search' => true
		);

		register_post_type('codexin_slider', $args);
	}

	public function redirect() {
		$queried_post_type = get_query_var( 'post_type' );
		if( is_single() && 'codexin_slider' == $queried_post_type ) {
			wp_redirect("/", 301);
			exit;
		}
	}

	public function featured_image_html( $html ) {
		if( 'codexin_slider' === get_post_type() ) {
			$html .= '<p><b><u>Note:</u></b> Upload Slide Image as Featured Image here. Recommended image size is <b>1920x1080</b> px.</p>';
		}

		return $html;
	}
}
