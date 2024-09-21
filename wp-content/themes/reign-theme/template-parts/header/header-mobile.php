<?php
/**
 * Mobile menu
 *
 * @package reign
 */

$mobile_menu_logged_in_exists  = has_nav_menu( 'mobile-menu-logged-in' );
$mobile_menu_logged_out_exists = has_nav_menu( 'mobile-menu-logged-out' );
?>

<div class="reign-fallback-header header-mobile<?php echo ( get_theme_mod( 'reign_header_sticky_menu_enable', true ) ) ? esc_attr( ' fixed-top' ) : ''; ?>">
	<nav id="site-navigation" class="main-navigation reign-navbar-mobile" role="navigation" aria-label="<?php esc_attr_e( 'Main menu', 'reign' ); ?>">
		<div class="container">
			<?php do_action( 'reign_before_reign_mobile_nav_top' ); ?>
			<div class="reign-nav-top-bar">
				<div class="site-branding">
					<div class="logo">
						<?php
						if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) {
							$mobile_menu_logo_enable = get_theme_mod( 'reign_header_mobile_menu_logo_enable', false );
							if ( $mobile_menu_logo_enable ) {
								$reign_header_mobile_menu_logo = get_theme_mod( 'reign_header_mobile_menu_logo', '' );
								if ( ! empty( $reign_header_mobile_menu_logo ) ) {
									?>
									<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><img class="reign-mobile-menu" src="<?php echo esc_url( $reign_header_mobile_menu_logo ); ?>" /></a>
									<?php
								} else {
									the_custom_logo();
								}
							} else {
								the_custom_logo();
							}
						} elseif ( is_front_page() && is_home() ) {
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
						<?php } else { ?>
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

						}
						?>
					</div><!-- .logo -->
				</div><!-- .site-branding -->

				<button class="reign-toggler reign-toggler-left" type="button">
					<span class="icon-bar bar1"></span>
					<span class="icon-bar bar2"></span>
					<span class="icon-bar bar3"></span>
				</button>

				<div class="navbar-menu-container">
					<?php do_action( 'reign_before_reign_mobile_main_menu' ); ?>
					<?php if ( is_user_logged_in() ) { ?>
						<div class="reign-mobile-user reign-mobile-user-header">
							<?php
							if ( function_exists( 'buddypress' ) && version_compare( buddypress()->version, '12.0', '>=' ) ) {
								$user_link = function_exists( 'bp_members_get_user_url' ) ? bp_members_get_user_url( get_current_user_id() ) : get_author_posts_url( get_current_user_id() );
							} else {
								$user_link = function_exists( 'bp_core_get_user_domain' ) ? bp_core_get_user_domain( get_current_user_id() ) : get_author_posts_url( get_current_user_id() );
							}
							$current_user = wp_get_current_user();
							?>
							<div class="user-wrap">
								<a href="<?php echo $user_link; ?>"><?php echo get_avatar( get_current_user_id(), 100 ); ?></a>
								<div>
									<a href="<?php echo $user_link; ?>"><span class="user-name"><?php echo $current_user->display_name; ?></span></a>
									<?php
									if ( function_exists( 'bp_is_active' ) && bp_is_active( 'settings' ) ) {
										$settings_link = trailingslashit( bp_loggedin_user_domain() . bp_get_settings_slug() );
										?>
										<div class="my-account-link"><a class="ab-item" aria-haspopup="true" href="<?php echo $settings_link; ?>"><?php esc_html_e( 'My Account', 'reign' ); ?></a></div>
										<?php
									}
									?>
								</div>
							</div>
							<a href="javascript:void(0);" class="reign-panel-close"><i class="far fa-times"></i></a>
						</div>
					<?php } else { ?>
						<div class="reign-mobile-user reign-mobile-user-header">
							<div class="site-branding">
								<div class="logo">
									<?php
									if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) {
										$mobile_menu_logo_enable = get_theme_mod( 'reign_header_mobile_menu_logo_enable', false );
										if ( $mobile_menu_logo_enable ) {
											$reign_header_mobile_menu_logo = get_theme_mod( 'reign_header_mobile_menu_logo', '' );
											if ( ! empty( $reign_header_mobile_menu_logo ) ) {
												?>
												<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><img class="reign-mobile-menu" src="<?php echo esc_url( $reign_header_mobile_menu_logo ); ?>" /></a>
												<?php
											} else {
												the_custom_logo();
											}
										} else {
											the_custom_logo();
										}
									} elseif ( is_front_page() && is_home() ) {
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
									<?php } else { ?>
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

									}
									?>
								</div><!-- .logo -->
							</div><!-- .site-branding -->
							<a href="javascript:void(0);" class="reign-panel-close"><i class="far fa-times"></i></a>
						</div>
					<?php } ?>
					<?php
					if ( is_user_logged_in() ) {
						wp_nav_menu(
							array(
								'theme_location' => 'mobile-menu-logged-in',
								'menu_id'        => 'primary-menu',
								'fallback_cb'    => 'fallback_primary_mobile_menu',
								'container'      => false,
								'walker'         => new Reign_Left_Panel_Menu_Walker(),
								'menu_class'     => 'primary-menu navbar-nav',
							)
						);
					} else {
						wp_nav_menu(
							array(
								'theme_location' => 'mobile-menu-logged-out',
								'menu_id'        => 'primary-menu',
								'fallback_cb'    => 'fallback_primary_mobile_menu',
								'container'      => false,
								'walker'         => new Reign_Left_Panel_Menu_Walker(),
								'menu_class'     => 'primary-menu navbar-nav',
							)
						);
					}

					?>
					<?php do_action( 'reign_after_reign_mobile_main_menu' ); ?>

					<?php
					do_action( 'reign_before_reign_mobile_panel_menu' );
					if ( ! $mobile_menu_logged_in_exists && ! $mobile_menu_logged_out_exists ) {
						wp_nav_menu(
							array(
								'theme_location' => 'panel-menu',
								'menu_id'        => 'reign-panel',
								'fallback_cb'    => '',
								'container'      => false,
								'walker'         => new Reign_Left_Panel_Menu_Walker(),
								'menu_class'     => 'navbar-nav navbar-reign-panel',
							)
						);
					}
					do_action( 'reign_before_reign_mobile_panel_menu' );
					?>
				</div>

				<div class="reign-user-toggler">
					<?php
					do_action( 'reign_before_header_icons' );

					$reign_mobile_header_default_icons_set = reign_mobile_header_default_icons_set();
					$reign_mobile_header_icons_set         = get_theme_mod( 'reign_mobile_header_icons_set', $reign_mobile_header_default_icons_set );

					if ( is_array( $reign_mobile_header_icons_set ) && in_array( 'user-menu', $reign_mobile_header_icons_set ) ) :
						if ( ( ! $mobile_menu_logged_in_exists && ! $mobile_menu_logged_out_exists ) && is_user_logged_in() ) {
							// For PeepSo notification icons.
							if ( class_exists( 'PeepSo' ) ) {
								$reign_dark_mode_style = get_theme_mod( 'reign_dark_mode_style', 'style2' );

								if ( is_active_sidebar( 'reign-header-widget-area' ) ) :
									echo '<div class="reign-peepso-menu-toggle">';
									dynamic_sidebar( 'reign-header-widget-area' );
									if ( 'style3' === $reign_dark_mode_style ) {
										do_action( 'reign_after_header_icons' );
									}
									echo '</div>';
								endif;

								if ( is_active_sidebar( 'reign-header-widget-area' ) ) :
									echo '<div class="user-profile-menu-wrapper">';
									echo '<div class="reign-mobile-user reign-mobile-user-header">';
									echo '<a href="javascript:void(0);" class="reign-panel-close"><i class="far fa-times"></i></a>';
									echo '</div>';
									dynamic_sidebar( 'reign-header-widget-area' );
									echo '</div>';
								endif;
							} else {
								$current_user = wp_get_current_user();
								if ( ( $current_user instanceof WP_User ) ) {
									if ( function_exists( 'buddypress' ) && version_compare( buddypress()->version, '12.0', '>=' ) ) {
										$user_link = function_exists( 'bp_members_get_user_url' ) ? bp_members_get_user_url( get_current_user_id() ) : '#';
									} else {
										$user_link = function_exists( 'bp_core_get_user_domain' ) ? bp_core_get_user_domain( get_current_user_id() ) : '#';
									}
									echo '<div class="user-link-wrap">';
									echo '<a class="user-link" href="' . esc_url( $user_link ) . '">';
									?>
									<?php
									echo get_avatar( $current_user->user_email, 200 );
									echo '</a>';
									echo '<div class="user-profile-menu-wrapper">';
									echo '<div class="reign-mobile-user reign-mobile-user-header">';
									echo '<a href="javascript:void(0);" class="reign-panel-close"><i class="far fa-times"></i></a>';
									echo '</div>';
									if ( has_nav_menu( 'menu-2' ) ) {
										wp_nav_menu(
											array(
												'theme_location' => 'menu-2',
												'menu_id' => 'user-profile-menu',
												'fallback_cb' => '',
												'container' => 'user-mobile-menu',
												'menu_class' => 'user-profile-menu',
											)
										);
									} else {
										do_action( 'reign_user_profile_menu' );
									}
									echo '</div>';
									echo '</div>';
								}
							}
						}
					endif;
					if ( ! class_exists( 'PeepSo' ) ) {
						do_action( 'reign_after_header_icons' );
					}
					?>
				</div>

				<?php
				$reign_mobile_header_layout = get_theme_mod( 'reign_mobile_header_layout', 'header-v1' );
				if ( 'header-v2' === $reign_mobile_header_layout ) {
					?>
					<div class="reign-navbar-user">
						<?php
						$reign_mobile_header_default_icons_set = reign_mobile_header_default_icons_set();
						$reign_mobile_header_icons_set         = get_theme_mod( 'reign_mobile_header_icons_set', $reign_mobile_header_default_icons_set );
						foreach ( $reign_mobile_header_icons_set as $header_icon ) {
							if ( 'user-menu' !== $header_icon ) {
								get_template_part( 'template-parts/header-icons/' . $header_icon, '' );
							}
						}

						do_action( 'reign_after_header_icons' );
						?>
					</div><!-- .reign-navbar-user -->
					<?php
				}
				?>

			</div><!-- .reign-nav-top-bar -->
			<?php if ( 'header-v2' !== $reign_mobile_header_layout ) { ?>
				<div class="reign-navbar-user">
					<?php
					$reign_mobile_header_default_icons_set = reign_mobile_header_default_icons_set();
					$reign_mobile_header_icons_set         = get_theme_mod( 'reign_mobile_header_icons_set', $reign_mobile_header_default_icons_set );
					foreach ( $reign_mobile_header_icons_set as $header_icon ) {
						if ( 'user-menu' !== $header_icon ) {
							get_template_part( 'template-parts/header-icons/' . $header_icon, '' );
						}
					}
					?>
				</div><!-- .reign-navbar-user -->
			<?php } ?>
			<?php do_action( 'reign_after_reign_mobile_nav_top' ); ?>
		</div><!-- .container -->
	</nav><!-- #site-navigation -->
</div><!-- .header-mobile -->
