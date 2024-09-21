<?php
if ( ! is_user_logged_in() ) {
	// Register Page Redirect.
	$registration_page_id  = get_theme_mod( 'reign_registration_page', 0 );
	$registration_page_url = ( $registration_page_id ) ? get_permalink( $registration_page_id ) : wp_registration_url();

	$reign_signin_popup = get_theme_mod( 'reign_signin_popup', false );
	$form_type_login    = get_theme_mod( 'reign_sign_form_popup', 'default' );
	$forms              = get_theme_mod( 'reign_sign_form_display', 'login' );
	if ( ( $form_type_login != 'custom' && ( $forms == 'register' || $forms == 'both' ) ) && $reign_signin_popup == true ) {
		$registration_page_url = '#';
	}
	if ( get_option( 'users_can_register' ) ) {
		?>
		<span class="sep">|</span>
		<div class="rg-icon-wrap rg-register-btn-wrap">
			<a href="<?php echo esc_url( $registration_page_url ); ?>" class="btn-register button" title="<?php esc_attr_e( 'Register', 'reign' ); ?>"><?php esc_html_e( 'Register', 'reign' ); ?><span class="far fa-address-book"></span></a>
		</div>
		<?php
	} elseif ( function_exists( 'bp_is_active' ) && bp_get_option( 'bp-enable-membership-requests' ) ) {
		?>
		<span class="sep">|</span>
		<div class="rg-icon-wrap rg-register-btn-wrap">
			<a href="<?php echo esc_url( $registration_page_url ); ?>" class="btn-register button" title="<?php esc_attr_e( 'Register', 'reign' ); ?>"><?php esc_html_e( 'Register', 'reign' ); ?><span class="far fa-address-book"></span></a>
		</div>
		<?php
	}
}
