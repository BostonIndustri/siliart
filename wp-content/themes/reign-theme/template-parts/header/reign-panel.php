<?php
/**
 * Left Menu Panel
 *
 * It's displayed left menu panel layout template
 *
 * @package reign
 */

global $post;
$bp_pages = get_option( 'bp-pages' );

if ( class_exists( 'BuddyPress' ) ) {
	if ( bp_is_current_component( 'groups' ) ) {
		$bp_page = get_post( $bp_pages['groups'] );
	} elseif ( bp_is_current_component( 'members' ) || bp_is_user() ) {
		$bp_page = get_post( $bp_pages['members'] );
	} elseif ( bp_is_current_component( 'activity' ) ) {
		$bp_page = get_post( $bp_pages['activity'] );
	} elseif ( bp_is_current_component( 'document' ) ) {
		$bp_page = get_post( $bp_pages['document'] );
	} elseif ( bp_is_current_component( 'media' ) ) {
		$bp_page = get_post( $bp_pages['media'] );
	} elseif ( bp_is_register_page() ) {
		$bp_page = get_post( $bp_pages['register'] );
	}
}

if ( ! empty( $bp_page ) ) {
	$wbcom_metabox_data = get_post_meta( $bp_page->ID, 'reign_wbcom_metabox_data', true );
} elseif ( is_singular() ) {
		$wbcom_metabox_data = get_post_meta( $post->ID, 'reign_wbcom_metabox_data', true );
}

$display_left_panel_menu         = isset( $wbcom_metabox_data['layout']['display_left_panel_menu'] ) ? $wbcom_metabox_data['layout']['display_left_panel_menu'] : '';
$reign_left_panel_gloabl_setting = get_theme_mod( 'reign_left_panel_gloabl_setting', true );

// Check whether to display the left panel based on other conditions.
if ( 'no' !== $display_left_panel_menu && false === $reign_left_panel_gloabl_setting ) {
	return;
}

if ( 'yes' === $display_left_panel_menu ) {
	return;
}

$reign_left_panel_state  = get_theme_mod( 'reign_left_panel_state', 'closed' );
$reign_left_panel_toggle = get_theme_mod( 'reign_left_panel_toggle', true );
$state_class             = '';
// phpcs:ignore WordPress.PHP.StrictComparisons.LooseComparison
if (
	(
		isset( $_COOKIE['reignpanel'] ) &&
		$_COOKIE['reignpanel'] === 'open'
	) || (
		$reign_left_panel_state === 'open' &&
		! isset( $_COOKIE['reignpanel'] )
	)
) {
	$state_class = 'reign-panel-open';
}

$panel_menu_exists = has_nav_menu( 'panel-menu' );
// Check if the panel menu for logged-in users exists.
if ( is_user_logged_in() && ! $panel_menu_exists ) {
	// If the panel menu for logged-in users doesn't exist, don't display the left panel.
	return;
}

// Check if the panel menu for logged-out users exists.
if ( ! is_user_logged_in() ) {
	$panel_menu_logged_out_exists = has_nav_menu( 'panel-menu-loggedout' );
	if ( ! $panel_menu_logged_out_exists ) {
		// If the panel menu for logged-out users doesn't exist, don't display the left panel.
		return;
	}
}

?>

<div id="reign-menu-panel" class="reign-menu-panel <?php echo esc_attr( $state_class ); ?>">
	<div class="reign-menu-panel-inner reign-scrollbar">
		<?php if ( $reign_left_panel_toggle ) : ?>
			<div class="reign-menu-panel-header">
				<button class="reign-toggler" type="button">
					<span class="icon-bar bar1"></span>
					<span class="icon-bar bar2"></span>
					<span class="icon-bar bar3"></span>
				</button>
			</div>
		<?php endif; ?>
		<div class="reign-inner-panel">
			<?php
			if ( is_user_logged_in() ) {
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
			} else {
				wp_nav_menu(
					array(
						'theme_location' => 'panel-menu-loggedout',
						'menu_id'        => 'reign-panel',
						'fallback_cb'    => 'fallback_panel_menu',
						'container'      => false,
						'walker'         => new Reign_Left_Panel_Menu_Walker(),
						'menu_class'     => 'navbar-nav navbar-reign-panel',
					)
				);
			}

			$left_panel_menu = ob_get_clean();

			if ( str_contains( $left_panel_menu, 'reign-menu-section' ) ) {
				$left_panel_menu = str_replace( 'navbar-nav navbar-reign-panel', 'navbar-nav navbar-reign-panel has-section-menu', $left_panel_menu );
			}

			echo $left_panel_menu; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			?>
		</div>
	</div>
</div>
