<?php
if ( is_user_logged_in() ) {
	// For PeepSo notification icons.
	if ( class_exists( 'PeepSo' ) ) {
		if ( is_active_sidebar( 'reign-header-widget-area' ) ) :
			dynamic_sidebar( 'reign-header-widget-area' );
		endif;
	} else {
		$current_user = wp_get_current_user();
		if ( ( $current_user instanceof WP_User ) ) {
			if ( function_exists( 'buddypress' ) && version_compare( buddypress()->version, '12.0', '>=' ) ) {
				$user_link = function_exists( 'bp_members_get_user_url' ) ? bp_members_get_user_url( get_current_user_id() ) : '#';
			} else {
				$user_link = function_exists( 'bp_core_get_user_domain' ) ? bp_core_get_user_domain( get_current_user_id() ) : '#';
			}
			echo '<div class="user-link-wrap header-notifications-dropdown-toggle">';
			echo '<a class="user-link dropdown-toggle" href="javascript:void(0)">';
			?>
			<span class="rg-user"><?php echo esc_html( $current_user->display_name ); ?></span>
			<?php
			echo '</a>';
			echo '<a class="user-link" href="' . esc_url( $user_link ) . '">';
			echo get_avatar( $current_user->user_email, 200 );
			echo '</a>';
			if ( has_nav_menu( 'menu-2' ) ) {
				wp_nav_menu(
					array(
						'theme_location' => 'menu-2',
						'menu_id'        => 'user-profile-menu',
						'fallback_cb'    => '',
						'container'      => false,
						'menu_class'     => 'user-profile-menu header-notifications-dropdown-menu',
					)
				);
			} else {
				do_action( 'reign_user_profile_menu' );
			}

			echo '</div>';
		}
	}
}
