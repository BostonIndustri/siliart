<?php
/**
 * BuddyPress - Users Cover Image Header
 *
 * @since 3.0.0
 * @version 12.0.0
 */
?>
<?php
global $wbtm_reign_settings;
$member_header_class = isset( $wbtm_reign_settings['reign_buddyextender']['member_header_type'] ) ? $wbtm_reign_settings['reign_buddyextender']['member_header_type'] : 'wbtm-cover-header-type-1';
$member_header_class = apply_filters( 'wbtm_rth_manage_member_header_class', $member_header_class );

$has_cover_image          = '';
$has_cover_image_position = '';
$displayed_user           = bp_get_displayed_user();
$cover_image_url          = bp_attachments_get_attachment(
	'url',
	array(
		'object_dir' => 'members',
		'item_id'    => $displayed_user->id,
	)
);

if ( function_exists( 'buddypress' ) && isset( buddypress()->buddyboss ) ) {
	if ( ! empty( $cover_image_url ) ) {
		$cover_image_position = bp_get_user_meta( bp_displayed_user_id(), 'bp_cover_position', true );
		$has_cover_image      = ' has-cover-image';
		if ( '' !== $cover_image_position ) {
			$has_cover_image_position = 'has-position';
		}
	}
}
?>
<?php if ( ! bp_is_user_messages() && ! bp_is_user_settings() && ! bp_is_user_notifications() && ! bp_is_user_profile_edit() && ! bp_is_user_change_avatar() && ! bp_is_user_change_cover_image() ) : ?>
	<div id="cover-image-container" class="wbtm-member-cover-image-container <?php echo esc_attr( $member_header_class ); ?>">

		<div id="header-cover-image" class="<?php echo esc_attr( $has_cover_image_position . $has_cover_image ); ?>">
			<?php if ( bp_is_my_profile() ) { ?>
			<a href="<?php echo esc_url( bp_get_members_component_link( 'profile', 'change-cover-image' ) ); ?>" class="link-change-cover-image bp-tooltip" data-bp-tooltip-pos="right" data-bp-tooltip="<?php esc_attr_e( 'Change Cover Photo', 'reign' ); ?>">
				<i class="far fa-edit"></i>
			</a>
			<?php } ?>
		</div>

		<div id="item-header-cover-image">

			<div class="wbtm-member-info-section"><!-- custom wrapper for main content :: start -->

				<div id="item-header-avatar">
					<?php if ( bp_is_my_profile() && ! bp_disable_avatar_uploads() ) { ?>
						<a href="<?php bp_members_component_link( 'profile', 'change-avatar' ); ?>" class="link-change-profile-image bp-tooltip" data-bp-tooltip-pos="up" data-bp-tooltip="<?php esc_attr_e( 'Change Profile Photo', 'reign' ); ?>">
							<i class="far fa-edit"></i>
						</a>
					<?php } ?>
				<?php bp_displayed_user_avatar( 'type=full' ); ?>
				</div><!-- #item-header-avatar -->

				<div id="item-header-content">

					<?php
					/**
					 * Fires before the bp_displayed_user_mentionname.
					 * Added by Reign Theme
					 *
					 * @since 1.0.7
					 */
					do_action( 'reign_bp_before_displayed_user_mentionname' );
					?>

					<?php if ( bp_is_active( 'activity' ) && bp_activity_do_mentions() ) : ?>
						<h2 class="user-nicename">@<?php bp_displayed_user_mentionname(); ?></h2>
					<?php endif; ?>

					<div class="wbtm-item-buttons-wrapper member-header-actions-wrap">
						<div id="item-buttons">
							<?php
							bp_nouveau_member_header_buttons(
								array(
									'container'         => 'ul',
									'button_element'    => 'button',
									'container_classes' => array( 'member-header-actions' ),
								)
							);
							?>
						</div><!-- #item-buttons -->
					</div>

					<?php bp_nouveau_member_hook( 'before', 'header_meta' ); ?>

					<?php if ( bp_nouveau_member_has_meta() ) : ?>
						<div class="item-meta">

							<?php bp_nouveau_member_meta(); ?>

						</div><!-- #item-meta -->

						<?php if ( class_exists( 'BadgeOS' ) ) : ?>
							<div class="wbtm-badge"> 
								<?php
								if ( function_exists( 'reign_profile_achievements' ) ) :
									reign_profile_achievements();
								endif;
								?>
							</div>
						<?php endif; ?>

					<?php endif; ?>

					<?php
					if ( function_exists( 'bp_member_type_list' ) ) :
						bp_member_type_list(
							bp_displayed_user_id(),
							array(
								'label'        => array(
									'plural'   => __( 'Member Types', 'reign' ),
									'singular' => __( 'Member Type', 'reign' ),
								),
								'list_element' => 'span',
							)
						);
					endif;
					?>

				</div><!-- #item-header-content -->

			</div><!-- custom wrapper for main content :: end -->

			<!-- custom section for extra content :: start -->
			<div class="wbtm-cover-extra-info-section">
				<?php
				/**
				 * Fires after main content to show extra information.
				 *
				 * @since 1.0.7
				 */
				do_action( 'reign_member_extra_info_section' );
				?>
			</div>
			<!-- custom section for extra content :: start -->

		</div><!-- #item-header-cover-image -->
	</div><!-- #cover-image-container -->
	<?php do_action( 'wbtm_after_cover_imager_container' ); ?>
<?php endif; ?>
