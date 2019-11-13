jQuery( function( $ ) {
	var types = ['very-weak', 'very-weak', 'weak', 'medium', 'strong'],
		requiredStrength = types.indexOf( MBUP_Password.strength );

	function checkPasswordStrength( password, $result, $submitButton ) {
		if ( '' === password ) {
			$result.hide();
			return;
		}

		// Reset the form & meter.
		$submitButton.prop( 'disabled', true );
		$result.removeClass( 'very-weak weak medium strong' ).show();

		// Get the password strength.
		var strength = wp.passwordStrength.meter( password, wp.passwordStrength.userInputBlacklist() );
		if ( 0 > strength || 4 < strength ) {
			return;
		}
		var type = types[strength];

		$result.addClass( type ).html( MBUP_Password[type] );
		if ( requiredStrength <= strength ) {
			$submitButton.prop( 'disabled', false );
		}
	}

	// Binding to trigger checkPasswordStrength.
	var $result = $( '#password-strength' ),
		$submitButton = $( '[name="rwmb_profile_submit_register"], [name="rwmb_profile_submit_info"]' );

	$( 'body' ).on( 'keyup', '#user_pass', function() {
		checkPasswordStrength( this.value, $result, $submitButton );
	} );
} );