<?php
namespace MBFS;

class Shortcode {
	public function init() {
		add_shortcode( 'mb_frontend_form', array( $this, 'shortcode' ) );

		if ( filter_input( INPUT_POST, 'rwmb_delete', FILTER_SANITIZE_STRING ) ) {
			add_action( 'template_redirect', array( $this, 'delete' ) );
		}

		if ( filter_input( INPUT_POST, 'rwmb_submit', FILTER_SANITIZE_STRING ) ) {
			add_action( 'template_redirect', array( $this, 'process' ) );
		}
	}

	/**
	 * Output the submission form in the frontend.
	 *
	 * @param array $atts Form parameters.
	 *
	 * @return string
	 */
	public function shortcode( $atts ) {
		$form = $this->get_form( $atts );
		if ( null === $form ) {
			return '';
		}
		ob_start();

		$form->render();

		return ob_get_clean();
	}

	/**
	 * Handle the form submit.
	 */
	public function process() {
		// @codingStandardsIgnoreLine
		$config = isset( $_POST['rwmb_form_config'] ) ? $_POST['rwmb_form_config'] : '';
		if ( empty( $config ) ) {
			return;
		}
		$form = $this->get_form( $config );
		if ( null === $form ) {
			return;
		}

		// Make sure to include the WordPress media uploader functions to process uploaded files.
		if ( ! function_exists( 'media_handle_upload' ) ) {
			require_once ABSPATH . 'wp-admin/includes/image.php';
			require_once ABSPATH . 'wp-admin/includes/file.php';
			require_once ABSPATH . 'wp-admin/includes/media.php';
		}

		$config['post_id'] = $form->process();
		$meta_box_ids      = array_filter( explode( ',', $config['id'] . ',' ) );
		$meta_box_ids      = implode( ',', $meta_box_ids );

		$redirect = add_query_arg( [] );
		if ( $config['post_id'] ) {
			$redirect = add_query_arg( 'rwmb-form-submitted', $meta_box_ids );
		}

		// Allow to re-edit the submitted post.
		if ( 'true' === $config['edit'] && $config['post_id'] ) {
			$redirect = add_query_arg( 'rwmb-post-id', $config['post_id'], $redirect );
		}

		$redirect = apply_filters( 'rwmb_frontend_redirect', $redirect, $config );

		wp_safe_redirect( $redirect );
		die;
	}

	/**
	 * Handle the form submit delete.
	 */
	public function delete() {
		$config = isset( $_POST['rwmb_form_config'] ) ? $_POST['rwmb_form_config'] : '';
		if ( empty( $config ) || empty( $config['post_id'] ) ) {
			return;
		}
		$form = $this->get_form( $config );
		if ( null === $form ) {
			return;
		}

		$form->delete();

		$meta_box_ids = array_filter( explode( ',', $config['id'] . ',' ) );
		$meta_box_ids = implode( ',', $meta_box_ids );

		$redirect = add_query_arg( 'rwmb-form-deleted', $meta_box_ids );
		$redirect = apply_filters( 'rwmb_frontend_redirect', $redirect, $config );

		wp_safe_redirect( $redirect );
		die;
	}

	/**
	 * Get the form.
	 *
	 * @param array $args Form configuration.
	 *
	 * @return Form Form object.
	 */
	private function get_form( $args ) {
		$args = shortcode_atts(
			array(
				// Meta Box ID.
				'id'                  => '',

				// Allow to edit the submitted post.
				'edit'                => false,
				'allow_delete'        => false,

				// Post fields.
				'post_type'           => '',
				'post_id'             => 0,
				'post_status'         => 'publish',
				'post_fields'         => '',
				'label_title'         => '',
				'label_content'       => '',
				'label_excerpt'       => '',
				'label_date'          => '',
				'label_thumbnail'     => '',

				// Appearance options.
				'submit_button'       => __( 'Submit', 'mb-frontend-submission' ),
				'delete_button'       => __( 'Delete', 'mb-frontend-submission' ),
				'confirmation'        => __( 'Your post has been successfully submitted. Thank you.', 'mb-frontend-submission' ),
				'delete_confirmation' => __( 'Your post has been successfully deleted.', 'mb-frontend-submission' ),
			),
			$args
		);

		// Quick set the current post ID.
		if ( 'current' === $args['post_id'] ) {
			$args['post_id'] = get_the_ID();
		}

		// Re-edit the submitted post.
		$post_id = filter_input( INPUT_GET, 'rwmb-post-id', FILTER_SANITIZE_NUMBER_INT );
		if ( $post_id ) {
			$args['post_id'] = $post_id;
		}

		// Allows developers to dynamically populate shortcode params via query string.
		$this->populate_via_query_string( $args );

		// Allows developers to dynamically populate shortcode params via hooks.
		$this->populate_via_hooks( $args );

		$meta_boxes   = array();
		$meta_box_ids = array_filter( explode( ',', $args['id'] . ',' ) );

		foreach ( $meta_box_ids as $meta_box_id ) {
			$meta_boxes[] = rwmb_get_registry( 'meta_box' )->get( $meta_box_id );
		}
		$meta_boxes = array_filter( $meta_boxes );
		if ( ! $meta_boxes ) {
			return null;
		}
		$meta_box_ids = array();
		foreach ( $meta_boxes as $meta_box ) {
			$meta_box->set_object_id( $args['post_id'] );
			if ( ! $args['post_type'] ) {
				$post_types        = $meta_box->post_types;
				$args['post_type'] = reset( $post_types );
			}
			$meta_box_ids[] = $meta_box->id;
		}

		$args['id'] = implode( ',', $meta_box_ids );

		$template_loader = new TemplateLoader();

		$post = new Post( $args['post_type'], $args['post_id'], $args, $template_loader );

		$error = new Error();

		return new Form( $meta_boxes, $post, $error, $args, $template_loader );
	}

	/**
	 * Allows developers to dynamically populate shortcode params via query string.
	 *
	 * @param array $args Shortcode params.
	 */
	private function populate_via_query_string( &$args ) {
		foreach ( $args as $key => $value ) {
			$dynamic_value = filter_input( INPUT_GET, "rwmb_frontend_field_$key", FILTER_SANITIZE_STRING );
			if ( $dynamic_value ) {
				$args[ $key ] = $dynamic_value;
			}
		}
	}

	/**
	 * Allows developers to dynamically populate shortcode params via hooks.
	 *
	 * @param array $args Shortcode params.
	 */
	private function populate_via_hooks( &$args ) {
		foreach ( $args as $key => $value ) {
			$args[ $key ] = apply_filters( "rwmb_frontend_field_value_{$key}", $value, $args );
		}
	}
}
