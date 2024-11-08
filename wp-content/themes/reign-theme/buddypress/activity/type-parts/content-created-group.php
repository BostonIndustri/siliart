<?php
/**
 * BuddyPress - `created_group` activity type content part.
 *
 * This template is only used to display the `created_group` activity type content.
 *
 * @since 10.0.0
 * @version 10.0.0
 */
?>
<div class="bp-group-activity-preview">

	<?php if ( bp_activity_has_generated_content_part( 'group_cover_image' ) ) : ?>
		<div class="bp-group-preview-cover">
			<a href="<?php bp_activity_generated_content_part( 'group_url' ); ?>">
				<img src="<?php bp_activity_generated_content_part( 'group_cover_image' ); ?>" alt=""/>
			</a>
		</div>
	<?php endif; ?>

	<div class="bp-group-short-description">
		<?php if ( bp_activity_has_generated_content_part( 'group_profile_photo' ) ) : ?>
			<div class="bp-group-avatar-content <?php echo bp_activity_has_generated_content_part( 'group_cover_image' ) ? 'has-cover-image' : ''; ?>">
				<a href="<?php bp_activity_generated_content_part( 'group_url' ); ?>">
					<img src="<?php bp_activity_generated_content_part( 'group_profile_photo' ); ?>" class="profile-photo avatar aligncenter" alt=""/>
				</a>
			</div>
		<?php endif; ?>

		<p class="bp-group-short-description-title">
			<a href="<?php bp_activity_generated_content_part( 'group_url' ); ?>"><?php bp_activity_generated_content_part( 'group_name' ); ?></a>
		</p>

		<div class="bp-profile-button">
			<a href="<?php bp_activity_generated_content_part( 'group_url' ); ?>" class="button large primary button-primary" role="button"><?php esc_html_e( 'Visit group', 'buddypress'); ?></a>
		</div>
	</div>
	
	<div class="reign-user-preview-footer">
		<div class="reign-user-stats">
			<div class="reign-user-stat">
				<p class="reign-user-stat-title"><?php echo groups_get_total_member_count( bp_get_activity_item_id() ); ?></p>
				<p class="reign-user-stat-text"><?php esc_html_e( 'Members', 'reign' ); ?></p>
			</div>
		</div>
	</div>
</div>
