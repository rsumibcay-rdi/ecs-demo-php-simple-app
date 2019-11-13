<?php
namespace MBB;

class Edit {
	public $meta = [];

	public function __construct() {
		add_action( 'add_meta_boxes_meta-box', [ $this, 'remove_meta_box' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue' ] );
		add_action( 'edit_form_after_title', [ $this, 'render' ] );

		// Removed hooks that modify post content, excerpt. Priority 20 to run after default WP hooks.
		add_action( 'init', [ $this, 'remove_content_hooks' ], 20 );
		add_filter( 'wp_insert_post_data', [ $this, 'update_meta_box' ], 10, 2 );
	}

	public function remove_meta_box() {
		remove_meta_box( 'submitdiv', 'meta-box', 'side' );
	}

	public function render() {
		if ( ! $this->is_screen() ) {
			return;
		}

		$tab = mbb_get_current_tab();
		require MBB_DIR . "views/tabs/$tab.php";
	}

	public function enqueue() {
		if ( ! $this->is_screen() ) {
			return;
		}

		wp_enqueue_style( 'rwmb-select2', RWMB_CSS_URL . 'select2/select2.css', [], '4.0.1' );
		wp_enqueue_style( 'rwmb-select-advanced', RWMB_CSS_URL . 'select-advanced.css', [], RWMB_VER );
		wp_enqueue_style( 'highlightjs', MBB_URL . 'assets/css/atom-one-dark.css' );
		wp_enqueue_style( 'meta-box-builder', MBB_URL . 'assets/css/meta-box-builder.css', [], MBB_VER );

		wp_register_script( 'highlightjs', MBB_URL . 'assets/js/highlight.pack.js', [], '9.11.0', true );
		wp_register_script( 'angularjs', MBB_URL . 'assets/js/angular.min.js', [], '1.6.9', true );
		wp_register_script( 'angularjs-animate', MBB_URL . 'assets/js/angular-animate.min.js', [ 'angularjs' ], '1.6.9', true );
		wp_register_script( 'angular-ui-sortable', MBB_URL . 'assets/js/angular-ui-sortable.min.js', [ 'angularjs' ], '0.19.0', true );
		wp_register_script( 'angular-ui-bootstrap-collapse', MBB_URL . 'assets/js/angular-ui-bootstrap-collapse.min.js', [ 'angularjs' ], '2.5.0', true );
		wp_register_script( 'tg-dynamic-directive', MBB_URL . 'assets/js/tg.dynamic.directive.js', [ 'angularjs' ], '0.3.0', true );
		wp_register_script( 'meta-box-builder-directives', MBB_URL . 'assets/js/directives.js', [ 'angularjs' ], '2.12.0', true );
		wp_register_script( 'rwmb-select2', RWMB_JS_URL . 'select2/select2.min.js', [ 'jquery' ], '4.0.2', true );
		wp_register_script( 'clipboard', MBB_URL . 'assets/js/clipboard.min.js', [], '2.0.4', true );
		wp_register_script( 'popper', MBB_URL . 'assets/js/popper.min.js', [], '1.15.0', true );
		wp_register_script( 'tippy', MBB_URL . 'assets/js/tippy.min.js', ['popper'], '4.3.1', true );

		wp_enqueue_script(
			'meta-box-builder',
			MBB_URL . 'assets/js/builder.js',
			array(
				'highlightjs',
				'angularjs-animate',
				'angular-ui-sortable',
				'angular-ui-bootstrap-collapse',
				'tg-dynamic-directive',
				'meta-box-builder-directives',
				'rwmb-select2',
				'accordion',
				'clipboard',
				'tippy',
			),
			MBB_VER,
			true
		);

		// If we're updating metabox, load old data.
		if ( isset( $_GET['post'] ) ) {
			$post = get_post( $_GET['post'] );
			$meta = $post->post_excerpt;

			// Should convert to array to enqueue properly.
			$meta = json_decode( $meta, true );
			wp_localize_script( 'meta-box-builder', 'meta', $meta );

			$this->meta = unserialize( $post->post_content );
		}

		$attrs = require __DIR__ . '/define.php';
		wp_localize_script( 'meta-box-builder', 'attrs', $attrs );
		wp_localize_script( 'meta-box-builder', 'post_types', mbb_get_post_types() );
		wp_localize_script( 'meta-box-builder', 'taxonomies', mbb_get_taxonomies() );
		wp_localize_script( 'meta-box-builder', 'settings_pages', mbb_get_setting_pages() );
		wp_localize_script( 'meta-box-builder', 'terms', mbb_get_terms() );
		wp_localize_script( 'meta-box-builder', 'posts', mbb_get_posts() );
		wp_localize_script( 'meta-box-builder', 'templates', mbb_get_templates() );

		wp_localize_script( 'meta-box-builder', 'i18n', [
			'defaultTitle' => __( 'Untitled Field Group', 'meta-box-builder' ),
		] );
	}

	/**
	 * Removed excerpt_save_pre filter for meta box, which adds rel="noopener"
	 * to <a target="_blank"> links, thus braking JSON validity.
	 *
	 * @see https://elightup.freshdesk.com/a/tickets/27894
	 */
	public function remove_content_hooks() {
		if ( ! is_admin() ) {
			return;
		}

		// Update meta box via method POST.
		$action    = filter_input( INPUT_POST, 'action' );
		$post_type = filter_input( INPUT_POST, 'post_type' );
		$is_post   = 'editpost' === $action && 'meta-box' === $post_type;

		// Trash or restore meta box via method GET.
		$is_get  = isset( $_GET['post_type'] ) && 'meta-box' === $_GET['post_type']; // Bulk removed.
		$post_id = filter_input( INPUT_GET, 'post', FILTER_SANITIZE_NUMBER_INT );
		if ( $post_id ) {
			$post = get_post( $post_id );
			$is_get = 'meta-box' === $post->post_type;
		}

		if ( $is_post || $is_get ) {
			remove_all_filters( 'excerpt_save_pre' );
		}
	}

	/**
	 * Action when user save post. We have to manual store post_content field.
	 * Which takes value from post_excerpt and serialize
	 *
	 * @param  mixed    $data raw posted data
	 * @param  \WP_Post $post current post to save
	 *
	 * @return mixed $data after formatted
	 */
	public function update_meta_box( $data, $post ) {
		if ( ! isset( $post['post_type'] ) || 'meta-box' !== $post['post_type'] || empty( $data['post_excerpt'] ) ) {
			return $data;
		}

		$parser = Parsers\MetaBox::from_json( $data['post_excerpt'] );
		$parser->parse();

		$meta_box = $parser->get_settings();
		$status   = empty( $meta_box['status'] ) ? 'publish' : $meta_box['status'];
		unset( $meta_box['is_id_modified'], $meta_box['status'] );

		// Only allow Trash or Publish status.
		$data['post_status']  = 'trash' === $data['post_status'] ? $data['post_status'] : $status;
		$data['post_content'] = @serialize( $meta_box );
		return $data;
	}

	private function is_screen() {
		$screen = get_current_screen();
		return 'post' === $screen->base && 'meta-box' === $screen->post_type;
	}
}
