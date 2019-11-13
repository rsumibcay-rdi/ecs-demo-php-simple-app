<?php
namespace MBFS;

class Error {
	public function set( $error = false ) {
		if ( false === $error ) {
			$error = __( 'There are some errors submitting the form. Please correct and try again.', 'mb-frontend-submission' );
		}
		$_SESSION['rwmb_frontend_error'] = $error;
	}

	public function has() {
		return ! empty( $_SESSION['rwmb_frontend_error'] );
	}

	public function clear() {
		unset( $_SESSION['rwmb_frontend_error'] );
	}

	public function show() {
		?>
		<div class="rwmb-error"><?php echo esc_html( $_SESSION['rwmb_frontend_error'] ); ?></div>
		<?php
	}
}