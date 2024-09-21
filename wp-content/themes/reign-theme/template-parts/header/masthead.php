<?php
/**
 * The header for our theme.
 *
 * This is the template that displays header vesion two
 *
 * @package Reign
 */

?>
<div class="reign-fallback-header header-desktop<?php echo ( get_theme_mod( 'reign_header_sticky_menu_enable', true ) ) ? esc_attr( ' fixed-top' ) : ''; ?>">
	<div class="container">
		<div class="wb-grid">
			<div class="header-left no-gutter wb-grid-flex wb-grid-center wb-grid-space-between">
				<div class="mobile-view-search-wrap header-right no-gutter wb-grid-flex wb-grid-center">
					<div class="search-wrap">
						<span class="rg-search-icon icon-search-interface-symbol"></span>
						<div class="rg-search-form-wrap">
							<?php get_search_form(); ?>
						</div>
					</div>
				</div>
				<!-- <div class="mobile-view-search">
				<?php // get_search_form(); ?>
				</div> -->
				<div class="site-branding">
					<div class="logo">
						<?php
						if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) {
							the_custom_logo();
						} else {
							if ( is_front_page() && is_home() ) :
								?>
								<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
								<?php
								$reign_description = get_bloginfo( 'description', 'display' );
								if ( $reign_description || is_customize_preview() ) {
									?>
										<p class="site-description">
												<?php echo esc_html( $reign_description ); ?>
										</p>
										<?php
								}
								?>
							<?php else : ?>
							<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
								<?php
								$reign_description = get_bloginfo( 'description', 'display' );
								if ( $reign_description || is_customize_preview() ) {
									?>
									<p class="site-description">
										<?php echo esc_html( $reign_description ); ?>
									</p>
									<?php
								}
								?>
								<?php
						endif;
						}
						?>
					</div>
				</div>

				<div class="mobile-view-cart">
					<?php my_wc_cart_count(); ?>
				</div>

				<div class="mobile-view-notification">
					<?php get_template_part( 'template-parts/user-notifications' ); ?>
				</div>

				<nav id="site-navigation" class="main-navigation" role="navigation">
					<?php
					if ( is_user_logged_in() ) {
						wp_nav_menu(
							array(
								'theme_location' => 'menu-1',
								'menu_id'        => 'primary-menu',
								'fallback_cb'    => '',
								'container'      => false,
								'menu_class'     => 'primary-menu',
							)
						);
					} elseif ( has_nav_menu( 'menu-1' ) || has_nav_menu( 'menu-1-logout' ) ) {
						wp_nav_menu(
							array(
								'theme_location' => 'menu-1-logout',
								'menu_id'        => 'primary-menu',
								'fallback_cb'    => 'fallback_primary_desktop_menu',
								'container'      => false,
								'menu_class'     => 'primary-menu',
							)
						);
					}
					?>
				</nav>
			</div>

			<div class="header-right no-gutter wb-grid-flex wb-grid-center">
				<div class="search-wrap">
					<span class="rg-search-icon icon-search-interface-symbol"></span>
					<div class="rg-search-form-wrap">
						<?php get_search_form(); ?>
					</div>
				</div>

				<?php my_wc_cart_count(); ?>

				<?php
				if ( is_user_logged_in() ) {

					get_template_part( 'template-parts/user-messages' );
					get_template_part( 'template-parts/user-notifications' );

					$current_user = wp_get_current_user();

					if ( ( $current_user instanceof WP_User ) ) {
						if ( function_exists( 'buddypress' ) && version_compare( buddypress()->version, '12.0', '>=' ) ) {
							$user_link = function_exists( 'bp_members_get_user_url' ) ? bp_members_get_user_url( get_current_user_id() ) : '#';
						} else {
							$user_link = function_exists( 'bp_core_get_user_domain' ) ? bp_core_get_user_domain( get_current_user_id() ) : '#';
						}
						echo '<div class="user-link-wrap">';
						echo '<a class="user-link" href="' . $user_link . '">'; /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */
						?>
						<span class="rg-user"><?php echo $current_user->display_name; /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */ ?></span>
						<?php
						echo get_avatar( $current_user->user_email, 200 );
						echo '</a>';
						wp_nav_menu(
							array(
								'theme_location' => 'menu-2',
								'menu_id'        => 'user-profile-menu',
								'fallback_cb'    => '',
								'container'      => false,
								'menu_class'     => 'user-profile-menu',
							)
						);
						echo '</div>';
					}
				} else {
					// Login Page Redirect.
					$login_page_id  = get_theme_mod( 'reign_login_page', 0 );
					$login_page_url = ( $login_page_id ) ? get_permalink( $login_page_id ) : wp_login_url();

					// Register Page Redirect.
					$registration_page_id  = get_theme_mod( 'reign_registration_page', 0 );
					$registration_page_url = ( $registration_page_id ) ? get_permalink( $registration_page_id ) : wp_registration_url();
					?>
					<div class="rg-icon-wrap rg-login-btn-wrap">
						<a href="<?php echo esc_url( $login_page_url ); ?>" class="btn-login button" title="<?php esc_attr_e( 'Login', 'reign' ); ?>"><?php esc_html_e( 'Login', 'reign' ); ?><span class="far fa-sign-in"></span></a>
					</div>
					<?php
					if ( get_option( 'users_can_register' ) ) {
						?>
					<span class="sep">|</span>
					<div class="rg-icon-wrap rg-register-btn-wrap">
						<a href="<?php echo esc_url( $registration_page_url ); ?>" class="btn-register button" title="<?php esc_attr_e( 'Register', 'reign' ); ?>"><?php esc_html_e( 'Register', 'reign' ); ?><span class="far fa-address-book"></span></a>
					</div>
						<?php
					}
				}
				?>
			</div>
		</div>
	</div>
</div>
