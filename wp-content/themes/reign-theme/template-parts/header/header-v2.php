<?php
/**
 * The header for our theme.
 *
 * This is the template that displays header vesion two
 *
 * @package Reign
 */

?>
<div class="reign-fallback-header header-desktop version-two<?php echo ( get_theme_mod( 'reign_header_sticky_menu_enable', true ) ) ? esc_attr( ' fixed-top' ) : ''; ?>">
	<div class="container">
		<div class="wb-grid">
			<div class="header-left no-gutter wb-grid-flex wb-grid-center wb-grid-space-between">
				<div class="site-branding">
				<div class="logo">
				<?php
				/**
				 * Custom logo
				 *
				 * @package reign
				 */

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

				$reign_header_sticky_menu_enable              = get_theme_mod( 'reign_header_sticky_menu_enable', true );
				$reign_header_sticky_menu_custom_style_enable = get_theme_mod( 'reign_header_sticky_menu_custom_style_enable', false );
				$sticky_menu_logo                             = get_theme_mod( 'reign_sticky_header_menu_logo', '' );

				if ( $reign_header_sticky_menu_enable && $reign_header_sticky_menu_custom_style_enable && $sticky_menu_logo ) {
					?>
					<a href="<?php echo get_home_url(); /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */ ?>" class="sticky-menu-logo custom-logo-link" rel="home" itemprop="url">
					<img src="<?php echo $sticky_menu_logo; /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */ ?>" class="custom-logo" alt="<?php bloginfo( 'name' ); ?>" itemprop="logo">
					</a>
					<?php
				}
				?>
				</div>
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
				<?php
				do_action( 'reign_before_header_icons' );

				$reign_header_default_icons_set = reign_header_default_icons_set();
				$reign_header_icons_set         = get_theme_mod( 'reign_header_icons_set', $reign_header_default_icons_set );
				foreach ( $reign_header_icons_set as $header_icon ) {
					get_template_part( 'template-parts/header-icons/' . $header_icon, '' );
				}

				do_action( 'reign_after_header_icons' );
				?>
			</div>
		</div>
	</div>
</div>
