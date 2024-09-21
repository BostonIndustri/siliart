<?php
/**
 * @var int $rand
 * @var string $redirect_to
 * @var string $redirect
 * @var string $forms
 */
extract( $args );
$can_register = get_option( 'users_can_register' );

global $wbtm_reign_settings;
$registration_page_url = wp_registration_url();
if ( isset( $wbtm_reign_settings['reign_pages']['reign_register_page'] ) && ( $wbtm_reign_settings['reign_pages']['reign_register_page'] != '-1' && $wbtm_reign_settings['reign_pages']['reign_register_page'] != '' ) ) {
	$registration_page_id  = $wbtm_reign_settings['reign_pages']['reign_register_page'];
	$registration_page_url = get_permalink( $registration_page_id );
}
?>
<div class="title h6"><?php echo ( $login_title != '' ) ? esc_html( $login_title ) : esc_html__( 'Login to your Account', 'reign' ); ?></div>

<form data-handler="reign-signin-form" class="content reign-sign-form-login reign-sign-form" method="POST" action="<?php echo esc_url( site_url( 'wp-login.php', 'login_post' ) ); ?>">

	<input class="simple-input" type="hidden" value="<?php echo wp_create_nonce( 'reign-sign-form' ); ?>" name="_ajax_nonce" />

	<input class="simple-input" type="hidden" name="redirect_to" value="<?php echo esc_attr( $redirect_to ); ?>"/>
	<input class="simple-input" type="hidden" name="redirect" value="<?php echo esc_attr( $redirect ); ?>"/>

	<?php do_action( 'reign_login_form_top' ); ?>

	<ul class="reign-sign-form-messages woocommerce-error"></ul>

	<div class="row">
		<div class="col">
			<div class="form-group label-floating">
				<label class="control-label"><?php esc_html_e( 'Username', 'reign' ); ?></label>
				<input class="form-control simple-input" name="log" type="text">
			</div>
			<div class="form-group label-floating password-eye-wrap">
				<label class="control-label"><?php esc_html_e( 'Your Password', 'reign' ); ?></label>
				<a href="#" class="fa fa-fw fa-eye password-eye" tabindex="-1"></a>
				<input class="form-control simple-input" name="pwd"  type="password">
			</div>

			<div class="remember">

				<div class="checkbox">
					<label>
						<input name="rememberme" value="forever" type="checkbox">
						<?php esc_html_e( 'Remember Me', 'reign' ); ?>
					</label>
				</div>

				<div class="registar-lostpass-wrap">
					<?php
					if ( get_option( 'users_can_register' ) ) {
						?>
						<a href="<?php echo esc_url( $registration_page_url ); ?>" class="register"><?php esc_html_e( 'Register', 'reign' ); ?></a>
						<?php
					} elseif ( function_exists( 'bp_is_active' ) && bp_get_option( 'bp-enable-membership-requests' ) ) {
						?>
						<a href="<?php echo esc_url( $registration_page_url ); ?>" class="register"><?php esc_html_e( 'Register', 'reign' ); ?></a>
						<?php
					}
					?>

					<?php $lostpswd = apply_filters( 'reign_lostpassword_url', wp_lostpassword_url() ); ?>

					<a href="<?php echo esc_url( $lostpswd ); ?>" class="forgot"><?php esc_html_e( 'Forgot my Password', 'reign' ); ?></a>
				</div>

			</div>

			<?php do_action( 'reign_recaptcha_after_login_form' ); ?>

			<button type="submit" class="btn full-width registration-login-submit">
				<span><?php esc_html_e( 'Login', 'reign' ); ?></span>
				<span class="icon-loader"></span>
			</button>

			<?php do_action( 'reign_login_form_bottom' ); ?>

			<?php
			if ( $can_register ) {
				if ( $login_description != '' ) {
					echo wp_kses_post( wpautop( do_shortcode( $login_description ) ) );
				} else {
					echo sprintf(
						'<p>%s %s %s</p>',
						esc_html__( 'Don\'t you have an account?', 'reign' ),
						esc_html__( 'Register Now!', 'reign' ),
						esc_html__( 'it\'s really simple and you can start enjoying all the benefits!', 'reign' )
					);
				}
			}
			?>
		</div>
	</div>
</form>
