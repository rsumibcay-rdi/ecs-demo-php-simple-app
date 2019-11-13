( function ( $, MB, window ) {
	// Set ajax URL for ajax actions.
	if ( ! window.ajaxurl ) {
		window.ajaxurl = MB.ajaxUrl;
	}

	$( function() {
		// Disable submit button to prevent submitting twice.
		$( '.rwmb-form' ).on( 'submit', function( e ) {
			var $this = $( this );

			// Use setTimeout to make the button disabled *after* form is submit, so we have variable sent via POST.
			setTimeout( function() {
				var disabled = true;

				if ( $.validator && ! $this.valid() ) {
					disabled = false;
				}
				$this.children( '.rwmb-form-submit' ).children( 'button' ).prop( 'disabled', disabled );
			}, 0 );
		} );
	} );
} )( jQuery, mbFrontendForm, window );
