<?php
/**
 * **************************************
 * Main.php
 *
 * The main template file, that loads the header, footer and sidebar
 * apart from loading the appropriate rtMedia template
 * ***************************************
 *
 * @package rtMedia
 */

// By default it is not an ajax request.
global $rt_ajax_request;
$rt_ajax_request = false;

// Todo sanitize and fix $_SERVER variable usage.
// Check if it is an ajax request.
$_rt_ajax_request = rtm_get_server_var( 'HTTP_X_REQUESTED_WITH', 'FILTER_SANITIZE_FULL_SPECIAL_CHARS' );
if ( 'xmlhttprequest' === strtolower( $_rt_ajax_request ) ) {
	$rt_ajax_request = true;
}

// Get currently active template (Nouveau / Legacy).
$bp_template = get_option( '_bp_theme_package_id' );

$class = '';
// Getting extran classes for #buddypress when Nouveau is active.
if ( 'nouveau' === $bp_template && ! $rt_ajax_request && function_exists( 'bp_nouveau_get_container_classes' ) ) {
	$class = bp_nouveau_get_container_classes();
}
?>
<div id="buddypress" class="<?php echo esc_attr( $class ); ?>">
<?php
// if it's not an ajax request, load headers.
if ( ! $rt_ajax_request ) {
	// if this is a BuddyPress page, set template type to buddypress to load appropriate headers.
	if ( class_exists( 'BuddyPress' ) && ! bp_is_blog_page() && apply_filters( 'rtm_main_template_buddypress_enable', true ) ) {
		$template_type = 'buddypress';
	} else {
		$template_type = '';
	}

	// When Nouveau is active.
	if ( 'nouveau' === $bp_template ) {

		if ( 'buddypress' === $template_type ) {

			if ( bp_displayed_user_id() ) {

				global $wbtm_reign_settings;
				$member_header_position = isset( $wbtm_reign_settings['reign_buddyextender']['member_header_position'] ) ? $wbtm_reign_settings['reign_buddyextender']['member_header_position'] : 'inside';
				$member_header_position = apply_filters( 'wbtm_rth_manage_member_header_position', $member_header_position );

				$bp_nouveau_appearance = bp_get_option( 'bp_nouveau_appearance', array() );
				if ( ! isset( $bp_nouveau_appearance['user_nav_display'] ) ) {
					$bp_nouveau_appearance['user_nav_display'] = false;
				}

				$bp_nav_style = get_theme_mod( 'buddypress_single_member_nav_style', 'iconic' );
				if ( $bp_nav_style == 'iconic' ) {
					$class = 'reign-nav-iconic';
				} else {
					$class = 'reign-default';
				}

				$bp_nav_view_style = get_theme_mod( 'buddypress_main_nav_view_style', 'text_icon' );
				if ( $bp_nav_view_style == 'swipe' ) {
					$nav_view_style = 'reign-nav-swipe';
				} elseif ( $bp_nav_view_style == 'text_icon' ) {
					$nav_view_style = 'reign-nav-swipe text-icon';
				} else {
					$nav_view_style = 'reign-nav-more';
				}

				?>
				<?php bp_nouveau_member_hook( 'before', 'home_content' ); ?>

				<?php if ( $member_header_position == 'top' ) : ?>
					<div id="item-header" role="complementary" data-bp-item-id="<?php echo esc_attr( bp_displayed_user_id() ); ?>" data-bp-item-component="members" class="users-header single-headers">

						<?php bp_nouveau_member_header_template_part(); ?>

					</div><!-- #item-header -->
				<?php endif; ?>

				<div class="bp-wrap <?php echo esc_attr( $class ); ?>">
					<?php
					if ( $bp_nouveau_appearance['user_nav_display'] ) {
						if ( ! bp_nouveau_is_object_nav_in_sidebar() ) {
							?>
							<div class="rg-nouveau-sidebar-menu <?php echo esc_attr( $nav_view_style ); ?>">
								<?php bp_get_template_part( 'members/single/parts/item-nav' ); ?>
							</div>
							<?php
						}
					}
					?>

					<div id="item-body" class="item-body">
						<div class="wb-grid">
							<div class="wb-grid-cell">

								<div class="item-body-inner-wrapper">

									<?php if ( $member_header_position == 'inside' ) : ?>
										<div id="item-header" role="complementary" data-bp-item-id="<?php echo esc_attr( bp_displayed_user_id() ); ?>" data-bp-item-component="members" class="users-header single-headers">

											<?php bp_nouveau_member_header_template_part(); ?>

										</div><!-- #item-header -->
									<?php endif; ?>

									<?php
									if ( ! $bp_nouveau_appearance['user_nav_display'] ) {
										if ( ! bp_nouveau_is_object_nav_in_sidebar() ) {
											?>
											<div class="rg-nouveau-sidebar-menu <?php echo esc_attr( $nav_view_style ); ?>">
												<?php bp_get_template_part( 'members/single/parts/item-nav' ); ?>
											</div>
											<?php
										}
									}
									?>

									<?php do_action( 'bp_before_member_body' ); ?>
									<?php do_action( 'bp_before_member_media' ); ?>

									<nav class="<?php bp_nouveau_single_item_subnav_classes(); ?>" id="subnav" role="navigation" aria-label="<?php esc_attr_e( 'rtMedia menu', 'reign' ); ?>">
										<ul class="subnav">

											<?php rtmedia_sub_nav(); ?>

											<?php do_action( 'rtmedia_sub_nav' ); ?>

										</ul>
									</nav><!-- .item-list-tabs#subnav -->

									<?php
									rtmedia_load_template();

									do_action( 'bp_after_member_media' );
									do_action( 'bp_after_member_body' );
									?>

								</div><!-- // .item-body-inner-wrapper -->
							</div><!-- // .wb-grid-cell -->
							<?php
							if ( is_active_sidebar( 'member-profile' ) && bp_is_user() ) {
								?>
								<aside id="secondary" class="widget-area member-profile-widget-area sm-wb-grid-1-1 md-wb-grid-1-1 lg-wb-grid-1-3" role="complementary">
									<div class="widget-area-inner">
										<?php do_action( 'reign_begin_member_profile_sidebar' ); ?>
										<?php dynamic_sidebar( 'member-profile' ); ?>
										<?php do_action( 'reign_end_member_profile_sidebar' ); ?>
									</div>
								</aside>
								<?php
							}
							?>
						</div><!-- // .wb-grid -->
					</div><!--#item-body-->
				</div><!-- // .bp-wrap -->

				<?php bp_nouveau_member_hook( 'after', 'home_content' ); ?>
				<?php
			} elseif ( bp_is_group() ) {
				if ( bp_has_groups() ) {
					while ( bp_groups() ) :
						bp_the_group();
						?>

						<?php
						global $wbtm_reign_settings;
						$member_header_position = isset( $wbtm_reign_settings['reign_buddyextender']['member_header_position'] ) ? $wbtm_reign_settings['reign_buddyextender']['member_header_position'] : 'inside';

						$bp_nouveau_appearance = bp_get_option( 'bp_nouveau_appearance', array() );
						if ( ! isset( $bp_nouveau_appearance['group_nav_display'] ) ) {
							$bp_nouveau_appearance['group_nav_display'] = false;
						}

						$bp_nav_style = get_theme_mod( 'buddypress_single_group_nav_style', 'iconic' );
						if ( $bp_nav_style == 'iconic' ) {
							$class = 'reign-nav-iconic';
						} else {
							$class = 'reign-default';
						}

						$bp_nav_view_style = get_theme_mod( 'buddypress_main_nav_view_style', 'text_icon' );
						if ( $bp_nav_view_style == 'swipe' ) {
							$nav_view_style = 'reign-nav-swipe';
						} elseif ( $bp_nav_view_style == 'text_icon' ) {
							$nav_view_style = 'reign-nav-swipe text-icon';
						} else {
							$nav_view_style = 'reign-nav-more';
						}
						?>

						<?php bp_nouveau_group_hook( 'before', 'home_content' ); ?>

						<?php if ( $member_header_position == 'top' ) : ?>
							<div id="item-header" role="complementary" data-bp-item-id="<?php bp_group_id(); ?>" data-bp-item-component="groups" class="groups-header single-headers">

								<?php bp_nouveau_group_header_template_part(); ?>

							</div><!-- #item-header -->
						<?php endif; ?>

						<div class="bp-wrap <?php echo esc_attr( $class ); ?>">

							<?php
							if ( $bp_nouveau_appearance['group_nav_display'] ) {
								if ( ! bp_nouveau_is_object_nav_in_sidebar() ) {
									?>
									<div class="rg-nouveau-sidebar-menu <?php echo esc_attr( $nav_view_style ); ?>">
										<?php bp_get_template_part( 'groups/single/parts/item-nav' ); ?>
									</div>
									<?php
								}
							}
							?>

							<div id="item-body" class="item-body">

								<div class="wb-grid">
									<div class="wb-grid-cell">
										<div class="item-body-inner-wrapper">

											<?php if ( $member_header_position == 'inside' ) : ?>
												<div id="item-header" role="complementary" data-bp-item-id="<?php bp_group_id(); ?>" data-bp-item-component="groups" class="groups-header single-headers">

													<?php bp_nouveau_group_header_template_part(); ?>

												</div><!-- #item-header -->
											<?php endif; ?>

											<?php
											if ( ! $bp_nouveau_appearance['group_nav_display'] ) {
												if ( ! bp_nouveau_is_object_nav_in_sidebar() ) {
													?>
													<div class="rg-nouveau-sidebar-menu <?php echo esc_attr( $nav_view_style ); ?>">
														<?php bp_get_template_part( 'groups/single/parts/item-nav' ); ?>
													</div>
													<?php
												}
											}
											?>

											<?php
											do_action( 'bp_before_group_body' );
											do_action( 'bp_before_group_media' );

											$bp_is_group_home = bp_is_group_home();
											if ( $bp_is_group_home && ! bp_current_user_can( 'groups_access_group' ) ) {
												/**
												 * Fires before the display of the group status message.
												 *
												 * @since 1.1.0
												 */
												do_action( 'bp_before_group_status_message' );
												?>

												<div id="message" class="info">
													<p><?php bp_group_status_message(); ?></p>
												</div>

												<?php

												/**
												 * Fires after the display of the group status message.
												 *
												 * @since 1.1.0
												 */
												do_action( 'bp_after_group_status_message' );
											} else {
												?>
												<nav class="<?php bp_nouveau_single_item_subnav_classes(); ?>" id="subnav" role="navigation" aria-label="<?php esc_attr_e( 'rtMedia menu', 'reign' ); ?>">
													<ul class="subnav">
														<?php rtmedia_sub_nav(); ?>
														<?php do_action( 'rtmedia_sub_nav' ); ?>
													</ul>
												</nav><!-- .item-list-tabs#subnav -->
												<?php

												rtmedia_load_template();
											}

											do_action( 'bp_after_group_media' );
											do_action( 'bp_after_group_body' );
											?>
										</div><!-- // .item-body-inner-wrapper -->
									</div><!-- // .wb-grid-cell -->
									<?php
									if ( is_active_sidebar( 'group-single' ) && bp_is_group() ) {
										?>
										<aside id="secondary" class="widget-area member-profile-widget-area sm-wb-grid-1-1 md-wb-grid-1-1 lg-wb-grid-1-3" role="complementary">
											<div class="widget-area-inner">
												<?php do_action( 'reign_begin_member_profile_sidebar' ); ?>
												<?php dynamic_sidebar( 'group-single' ); ?>
												<?php do_action( 'reign_end_member_profile_sidebar' ); ?>
											</div>
										</aside>
										<?php
									}
									?>
								</div><!-- // .wb-grid -->
							</div><!-- // .item-body -->

						</div><!-- // .bp-wrap -->

						<?php bp_nouveau_group_hook( 'after', 'home_content' ); ?>

						<?php
					endwhile;
				}
			}
		} else { // if BuddyPress.
			echo '<div id="item-body">';

			rtmedia_load_template();

			if ( ! $rt_ajax_request ) {
				if ( 'buddypress' === $template_type ) {
					if ( function_exists( 'bp_is_group' ) && bp_is_group() ) {
						do_action( 'bp_after_group_media' );
						do_action( 'bp_after_group_body' );
					}
					if ( function_exists( 'bp_displayed_user_id' ) && bp_displayed_user_id() ) {
						do_action( 'bp_after_member_media' );
						do_action( 'bp_after_member_body' );
					}
				}
				echo '</div><!--#item-body-->';
				if ( 'buddypress' === $template_type ) {
					if ( function_exists( 'bp_is_group' ) && bp_is_group() ) {
						do_action( 'bp_after_group_home_content' );
					}
					if ( function_exists( 'bp_displayed_user_id' ) && bp_displayed_user_id() ) {
						do_action( 'bp_after_member_home_content' );
					}
				}
			}
		}
	} else { // When Legacy is active.
		if ( 'buddypress' === $template_type ) {
			// load buddypress markup.
			if ( bp_displayed_user_id() ) {
				?>
				<?php do_action( 'bp_before_member_home_content' ); ?>
				<div id="item-header" role="complementary" data-bp-item-id="<?php echo esc_attr( bp_displayed_user_id() ); ?>" data-bp-item-component="members" class="users-header single-headers">

					<?php
					/**
					 * If the cover image feature is enabled, use a specific header
					 */
					if ( function_exists( 'bp_displayed_user_use_cover_image_header' ) && bp_displayed_user_use_cover_image_header() ) :
						bp_get_template_part( 'members/single/cover-image-header' );
					else :
						bp_get_template_part( 'members/single/member-header' );
						endif;
					?>

				</div><!--#item-header-->

				<div id="item-nav">
					<div class="item-list-tabs no-ajax" id="object-nav" role="navigation">
						<ul>

							<?php bp_get_displayed_user_nav(); ?>

							<?php do_action( 'bp_member_options_nav' ); ?>

						</ul>
					</div>
				</div><!--#item-nav-->

				<div id="item-body" role="main">

					<?php do_action( 'bp_before_member_body' ); ?>
					<?php do_action( 'bp_before_member_media' ); ?>
					<div class="item-list-tabs no-ajax" id="subnav">
						<ul>

							<?php rtmedia_sub_nav(); ?>

							<?php do_action( 'rtmedia_sub_nav' ); ?>

						</ul>
					</div><!-- .item-list-tabs -->

				<?php
				// if it is a buddypress member profile.

			} elseif ( bp_is_group() ) {

				// not a member profile, but a group.
				?>

				<?php
				if ( bp_has_groups() ) :
					while ( bp_groups() ) :
						bp_the_group();

						?>
						<?php
						/**
						 * Fires before the display of the group home content.
						 *
						 * @since 1.2.0
						 */
						do_action( 'bp_before_group_home_content' );
						?>

						<div id="item-header" role="complementary" data-bp-item-id="<?php bp_group_id(); ?>" data-bp-item-component="groups" class="groups-header single-headers">

							<?php
							/**
							 * If the cover image feature is enabled, use a specific header
							 */
							if ( function_exists( 'bp_group_use_cover_image_header' ) && bp_group_use_cover_image_header() ) :
								bp_get_template_part( 'groups/single/cover-image-header' );
							else :
								bp_get_template_part( 'groups/single/group-header' );
							endif;
							?>

						</div><!--#item-header-->

						<div id="item-nav">
							<div class="item-list-tabs no-ajax" id="object-nav" role="navigation">
								<ul>
									<?php bp_get_options_nav(); ?>
									<?php do_action( 'bp_group_options_nav' ); ?>
								</ul>
							</div>
						</div><!-- #item-nav -->


						<div id="item-body">
							<?php do_action( 'bp_before_group_body' ); ?>
							<?php do_action( 'bp_before_group_media' ); ?>
							<div class="item-list-tabs no-ajax" id="subnav">
								<ul>
									<?php rtmedia_sub_nav(); ?>
									<?php do_action( 'rtmedia_sub_nav' ); ?>
								</ul>
							</div><!-- .item-list-tabs -->
						<?php

					endwhile;
				endif; // group/profile if/else.
			}
		} else { // if BuddyPress.
			echo '<div id="item-body">';
		}

		rtmedia_load_template();

		if ( ! $rt_ajax_request ) {
			if ( 'buddypress' === $template_type ) {
				if ( function_exists( 'bp_is_group' ) && bp_is_group() ) {
					do_action( 'bp_after_group_media' );
					do_action( 'bp_after_group_body' );
				}
				if ( function_exists( 'bp_displayed_user_id' ) && bp_displayed_user_id() ) {
					do_action( 'bp_after_member_media' );
					do_action( 'bp_after_member_body' );
				}
			}
			echo '</div><!--#item-body-->';
			if ( 'buddypress' === $template_type ) {
				if ( function_exists( 'bp_is_group' ) && bp_is_group() ) {
					do_action( 'bp_after_group_home_content' );
				}
				if ( function_exists( 'bp_displayed_user_id' ) && bp_displayed_user_id() ) {
					do_action( 'bp_after_member_home_content' );
				}
			}
		}
	}
} else { // If ajax/iframe request, just load images.
	rtmedia_load_template();
}
// close all markup.
?>
</div><!--#buddypress-->
<?php
