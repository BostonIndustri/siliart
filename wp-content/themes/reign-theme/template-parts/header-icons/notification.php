<?php
if ( class_exists( 'BuddyPress' ) && is_user_logged_in() && bp_is_active( 'notifications' ) ) {

	global $bp;
	$unread_notification_count = bp_notifications_get_unread_notification_count( get_current_user_id() );
	?>

	<div class="user-notifications header-notifications-dropdown-toggle">
		<a class="rg-icon-wrap dropdown-toggle" href="#" title="<?php esc_attr_e( 'Notifications', 'reign' ); ?>">
			<span class="far fa-bell"></span>
			<?php if ( $unread_notification_count > 0 ) : ?>
				<sup class="count rg-count">
					<?php echo esc_html( $unread_notification_count > 9 ? '9+' : $unread_notification_count ); ?>
				</sup>
			<?php endif; ?>
		</a>

		<div class="header-notifications-dropdown-menu" aria-labelledby="nav_notification">
			<div class="dropdown-title">
				<?php esc_html_e( 'Notifications', 'reign' ); ?>
				<a class="mark-read-all action-unread <?php echo ( $unread_notification_count == 0 ) ? 'hidden' : ''; ?>" data-notification-id="all">
					<?php esc_html_e( 'Mark all as read', 'reign' ); ?>
				</a>
			</div>
			<?php
			if ( bp_has_notifications( bp_ajax_querystring( 'notifications' ) . '&user_id=' . get_current_user_id() . '&is_new=1' ) ) :
				?>
			<div class="dropdown-item-wrapper">
				<?php
				while ( bp_the_notifications() ) :
					bp_the_notification();
					$is_unread = isset( buddypress()->notifications->query_loop->notification->is_new ) && buddypress()->notifications->query_loop->notification->is_new;
					?>
					<div class="dropdown-item read-item <?php echo $is_unread ? 'unread' : ''; ?>">
						<div class="notification-item-content">
							<div class="item-avatar">
								<?php
								function_exists( 'buddypress' ) && isset( buddypress()->buddyboss ) ? bb_notification_avatar() : reign_notifications_avatar();
								?>
							</div>
							<div class="item-info">
								<div class="dropdown-item-title notification ellipsis"><?php bp_the_notification_description(); ?></div>
								<p class="mute"><?php bp_the_notification_time_since(); ?></p>
							</div>
						</div>
						<div class="actions">
							<a class="mark-read action-unread primary" data-bp-tooltip-pos="left" data-bp-tooltip="<?php esc_html_e( 'Mark as Read', 'reign' ); ?>" data-notification-id="<?php bp_the_notification_id(); ?>">
								<span class="dashicons dashicons-hidden" aria-hidden="true"></span>
							</a>
						</div>
					</div>
				<?php endwhile; ?>
			</div>
			<?php else : ?>
				<div class="alert-message">
					<div class="alert alert-warning" role="alert"><?php esc_html_e( 'No notifications found', 'reign' ); ?></div>
				</div>
			<?php endif; ?>
			<div class="dropdown-footer">
				<a href="<?php echo esc_url( trailingslashit( bp_loggedin_user_domain() . bp_get_notifications_slug() . '/unread' ) ); ?>" class="button read-more"><?php esc_html_e( 'All Notifications', 'reign' ); ?></a>
			</div>
		</div>
	</div>
	<?php
}
