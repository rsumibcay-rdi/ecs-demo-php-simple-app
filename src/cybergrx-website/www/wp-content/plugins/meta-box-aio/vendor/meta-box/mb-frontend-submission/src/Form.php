<?php
namespace MBFS;

class Form {
	/**
	 * Meta box object.
	 *
	 * @var array
	 */
	public $meta_boxes;

	/**
	 * The object model that meta box is for. Default is post.
	 *
	 * @var Post
	 */
	public $object;

	/**
	 * Form configuration.
	 *
	 * @var array
	 */
	public $config;

	private $error;
	private $template_loader;

	/**
	 * Constructor.
	 *
	 * @param array          $meta_boxes      Meta box array.
	 * @param object         $object          Post object.
	 * @param array          $config          Form configuration.
	 * @param TemplateLoader $template_loader Template loader for loading form templates.
	 */
	public function __construct( $meta_boxes, $object, $error, $config, $template_loader ) {
		$this->meta_boxes      = array_filter( $meta_boxes, array( $this, 'is_meta_box_visible' ) );
		$this->object          = $object;
		$this->error           = $error;
		$this->config          = $config;
		$this->template_loader = $template_loader;
	}

	/**
	 * Output the form.
	 */
	public function render() {
		if ( empty( $this->meta_boxes ) ) {
			return;
		}

		$this->enqueue();

		if ( $this->is_deleted() ) {
			do_action( 'rwmb_frontend_before_delete_confirmation', $this->config );
			$this->display_message( 'delete-confirmation' );
			do_action( 'rwmb_frontend_after_delete_confirmation', $this->config );
			return;
		}

		if ( $this->error->has() ) {
			$this->error->show();
			$this->error->clear();
		}

		if ( $this->is_processed() ) {
			do_action( 'rwmb_frontend_before_display_confirmation', $this->config );
			$this->display_message( 'confirmation' );
			do_action( 'rwmb_frontend_after_display_confirmation', $this->config );

			if ( 'true' !== $this->config['edit'] ) {
				return;
			}
		}

		do_action( 'rwmb_frontend_before_form', $this->config );

		echo '<form class="rwmb-form" method="post" enctype="multipart/form-data" encoding="multipart/form-data">';
		$this->render_hidden_fields();

		// Register wp color picker scripts for frontend.
		$this->register_scripts();
		wp_localize_jquery_ui_datepicker();

		$this->object->render();

		foreach ( $this->meta_boxes as $meta_box ) {
			$meta_box->enqueue();
			$meta_box->show();
		}

		$delete_button = '';
		if ( 'true' === $this->config['allow_delete'] && $this->config['post_id'] ) {
			$delete_button = '<button class="rwmb-button rwmb-button--delete" name="rwmb_delete" value="1">' . esc_html( $this->config['delete_button'] ) . '</button>';
		}

		do_action( 'rwmb_frontend_before_submit_button', $this->config );
		echo '<div class="rwmb-field rwmb-button-wrapper rwmb-form-submit"><button class="rwmb-button" name="rwmb_submit" value="1">', esc_html( $this->config['submit_button'] ), '</button>' , $delete_button , '</div>';
		do_action( 'rwmb_frontend_after_submit_button', $this->config );

		echo '</form>';

		do_action( 'rwmb_frontend_after_form', $this->config );
	}

	/**
	 * Check if a meta box is visible.
	 *
	 * @param  \RW_Meta_Box $meta_box Meta Box object.
	 * @return bool
	 */
	public function is_meta_box_visible( $meta_box ) {
		if ( empty( $meta_box ) ) {
			return false;
		}
		if ( is_callable( $meta_box, 'is_shown' ) ) {
			return $meta_box->is_shown();
		}
		$show = apply_filters( 'rwmb_show', true, $meta_box->meta_box );
		return apply_filters( "rwmb_show_{$meta_box->id}", $show, $meta_box->meta_box );
	}

	/**
	 * Process the form.
	 * Meta box auto hooks to 'save_post' action to save its data, so we only need to save the post.
	 *
	 * @return int Inserted object ID.
	 */
	public function process() {
		$this->error->clear();

		$validate = true;
		foreach ( $this->meta_boxes as $meta_box ) {
			$validate = $validate && $meta_box->validate();
		}

		$validate  = apply_filters( 'rwmb_frontend_validate', $validate, $this->config );

		if ( true !== $validate ) {
			$this->error->set( $validate );
			return null;
		}

		do_action( 'rwmb_frontend_before_process', $this->config );
		$object_id             = $this->object->save();
		$this->object->post_id = $object_id;
		do_action( 'rwmb_frontend_after_process', $this->config, $object_id );

		return $object_id;
	}

	/**
	 * Handling deleting posts by id.
	 */
	public function delete() {
		if ( empty( $this->config['post_id'] ) ) {
			return;
		}
		do_action( 'rwmb_frontend_before_delete', $this->config );
		wp_delete_post( $this->config['post_id'] );
		do_action( 'rwmb_frontend_after_delete', $this->config, $this->config['post_id'] );
	}

	private function register_scripts() {
		if ( wp_script_is( 'wp-color-picker', 'registered' ) ) {
			return;
		}
		wp_register_script(
			'iris',
			admin_url( 'js/iris.min.js' ),
			array(
				'jquery-ui-draggable',
				'jquery-ui-slider',
				'jquery-touch-punch',
			),
			'1.0.7',
			true
		);
		wp_register_script( 'wp-color-picker', admin_url( 'js/color-picker.min.js' ), array( 'iris' ), '', true );

		wp_localize_script(
			'wp-color-picker',
			'wpColorPickerL10n',
			array(
				'clear'            => __( 'Clear', 'mb-frontend-submission' ),
				'clearAriaLabel'   => __( 'Clear color', 'mb-frontend-submission' ),
				'defaultString'    => __( 'Default', 'mb-frontend-submission' ),
				'defaultAriaLabel' => __( 'Select default color', 'mb-frontend-submission' ),
				'pick'             => __( 'Select Color', 'mb-frontend-submission' ),
				'defaultLabel'     => __( 'Color value', 'mb-frontend-submission' ),
			)
		);
	}

	private function enqueue() {
		wp_enqueue_style( 'mb-frontend-form', MB_FRONTEND_SUBMISSION_URL . 'css/frontend-submission.css', '', '2.0.0' );

		wp_enqueue_script( 'mb-frontend-form', MB_FRONTEND_SUBMISSION_URL . 'js/frontend-submission.js', array( 'jquery' ), '2.0.0', true );
		wp_localize_script(
			'mb-frontend-form',
			'mbFrontendForm',
			array(
				'ajaxUrl' => admin_url( 'admin-ajax.php' ),
			)
		);
	}

	private function render_hidden_fields() {
		foreach ( $this->config as $key => $value ) {
			echo '<input type="hidden" name="rwmb_form_config[', esc_attr( $key ), ']" value="', esc_attr( $value ), '">';
		}
	}

	private function is_processed() {
		$id = array();
		foreach ( $this->meta_boxes as $meta_box ) {
			$id[] = $meta_box->id;
		}
		$id = implode( ',', $id );

		return filter_input( INPUT_GET, 'rwmb-form-submitted' ) === $id;
	}

	private function is_deleted() {
		$id = array();
		foreach ( $this->meta_boxes as $meta_box ) {
			$id[] = $meta_box->id;
		}
		$id = implode( ',', $id );

		return filter_input( INPUT_GET, 'rwmb-form-deleted' ) === $id;
	}

	private function display_message( $type ) {
		$this->template_loader->set_template_data( $this->config )->get_template_part( $type );
	}
}
