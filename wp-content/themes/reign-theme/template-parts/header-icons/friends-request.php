<?php
/**
 * Friend Requests
 *
 * Template part for displaying the user friends requests
 *
 * @package reign
 * @since 1.0.0
 */

/** Do not allow directly accessing this file. */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
?>

<?php if ( is_user_logged_in() ) : ?>
	<?php if ( function_exists( 'bp_is_active' ) ) : ?>
		<?php if ( bp_is_active( 'friends' ) ) : ?>
		<div id="friend-requests-list" class="rg-friend-request header-notifications-dropdown-toggle">
			<a class="rg-icon-wrap dropdown-toggle" href="<?php echo esc_url( trailingslashit( bp_loggedin_user_domain() . bp_get_friends_slug() . '/requests' ) ); ?>" id="nav_friend_requests" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<i class="far fa-user-plus"></i>
				<?php if ( bp_friend_get_total_requests_count( bp_loggedin_user_id() ) > 0 ) : ?>
					<?php if ( bp_friend_get_total_requests_count( bp_loggedin_user_id() ) > 9 ) : ?>
						<span class="count"><?php esc_html_e( '9+', 'reign' ); ?></span>
					<?php else : ?>
						<span class="count rg-count"><?php echo esc_html( bp_friend_get_total_requests_count( bp_loggedin_user_id() ) ); ?></span>
					<?php endif; ?>
				<?php endif; ?>
			</a>
			<div class="header-notifications-dropdown-menu" aria-labelledby="nav_friend_requests">
				<div class="dropdown-title">
					<?php esc_html_e( 'Friend requests', 'reign' ); ?>
				</div>
				<div class="dropdown-item-wrapper">
					<div class="dropdown-item-list">
						<?php
						if ( function_exists( 'bp_get_friendship_requests' ) ) :
							if ( bp_has_members( 'type=alphabetical&include=' . bp_get_friendship_requests( bp_loggedin_user_id() ) ) ) :
								?>
								<?php
								while ( bp_members() ) :
									bp_the_member();
									?>
									<div class="reign-friend-request">
										<div class="dropdown-item">
											<div class="dropdown-item-inner">
												<div class="item-avatar rounded-avatar">
													<a href="<?php bp_member_link(); ?>">
													<?php
													echo bp_core_fetch_avatar( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
														array(
															'item_id' => bp_get_member_user_id(),
															'type' => 'thumb',
															'class' => 'avatar rounded-circle',
															'width' => 40,
															'height' => 40,
														)
													);
													?>
													</a>
												</div>
												<div class="item-info">
													<div class="item-detail-data">
														<a class="ellipsis" href="<?php bp_member_link(); ?>"><?php bp_member_name(); ?></a>
														<p class="item-time mute response"><?php bp_member_last_active(); ?></p>
													</div>
												</div>
												<div class="request-button">
													<?php $friendship_id = friends_get_friendship_id( bp_get_member_user_id(), bp_loggedin_user_id() ); ?>
													<a class="btn reign-friendship-btn item-btn accept" data-friendship-id="<?php echo esc_attr( $friendship_id ); ?>" href="<?php bp_friend_accept_request_link(); ?>"><i class="far fa-check" title="<?php esc_attr_e( 'Accept', 'reign' ); ?>"></i></a>
													<a class="btn reign-friendship-btn item-btn reject" data-friendship-id="<?php echo esc_attr( $friendship_id ); ?>" href="<?php bp_friend_reject_request_link(); ?>"><i class="far fa-times" title="<?php esc_attr_e( 'Reject', 'reign' ); ?>"></i></a>
												</div>
											</div>
										</div>
									</div>
								<?php endwhile; ?>
							<?php else : ?>
							<div class="alert-message">
								<div class="alert alert-warning" role="alert"><?php esc_html_e( 'No friend request.', 'reign' ); ?></div>
							</div>
								<?php
							endif;
						endif;
						?>
					</div>
				</div>
				<div class="dropdown-footer">
					<a href="<?php echo esc_url( trailingslashit( bp_loggedin_user_domain() . bp_get_friends_slug() . '/requests' ) ); ?>" class="button read-more"><?php esc_html_e( 'All Requests', 'reign' ); ?></a>
				</div>
			</div>
		</div>
		<?php endif; ?>
	<?php endif; ?>
<?php endif; ?>
