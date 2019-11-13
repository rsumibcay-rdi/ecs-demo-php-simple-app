<?php
namespace MBB;

class Register {
	public function __construct() {
		add_filter( 'rwmb_meta_boxes', array( $this, 'register_meta_box' ) );
	}

	public function register_meta_box( $meta_boxes ) {
		$query = new \WP_Query( [
			'post_type'              => 'meta-box',
			'post_status'            => 'publish',
			'posts_per_page'         => -1,
			'no_found_rows'          => true,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false,
		] );

		foreach ( $query->posts as $post ) {
			$meta_box = @unserialize( $post->post_content );

			if ( empty( $meta_box['fields'] ) ) {
				continue;
			}

			$meta_boxes[] = $meta_box;
		}

		return $meta_boxes;
	}
}
