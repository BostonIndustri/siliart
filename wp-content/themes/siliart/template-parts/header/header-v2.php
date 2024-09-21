<?php
/**
 * The header for our theme.
 *
 * This is the template that displays header vesion two
 *
 * @package Reign
 */

$cart          = WC()->cart;
$cart_count    = WC()->cart->get_cart_contents_count();
$user_id       = get_current_user_id();
$PeepSoProfile = PeepSoProfile::get_instance();
$PeepSoUser    = $PeepSoProfile->user;
$profile_url   = $PeepSoUser->get_profileurl( FALSE );
$followers     = array();
// $followers     =  PeepSoUserFollower::get_followers(
// 	array(
// 		'limit'   => -1,
// 		'user_id' => $user_id,
// 	)
// );

// $user        = PeepSoUser::get_instance( $user_id );



// Notificaiton code.
// $notifications = $PeepSoProfile->next_notification( 10, 0 );
// debug( $notifications ); die;
// $className = 'ps-notification';
// if ($readstatus === FALSE) {
// 	$className .= ' ps-notification--unread';
// }
// $className .= ' ps-js-notification ps-js-notification--' . $notification_id;
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
					<span class="menu-toggle wbcom-nav-menu-toggle" aria-controls="primary-menu" aria-expanded="false">
					<span></span>
					<span></span>
					<span></span>
					</span>
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'menu-1',
							'menu_id'        => 'primary-menu',
							'fallback_cb'    => '',
							'container'      => false,
							'menu_class'     => 'primary-menu',
						)
					);
					?>
				</nav>
			</div>


			<div class="header-right no-gutter wb-grid-flex wb-grid-center">
				<div class="search-wrap rg-icon-wrap">
					<span class="rg-search-icon far fa-search"></span>
					<div class="rg-search-form-wrap">
						<span class="rg-search-close far fa-times-circle"></span>
						<form role="search" method="get" class="search-form" action="/">
							<label>
								<span class="screen-reader-text">Search for:</span>
								<input type="search" class="search-field" placeholder="Search …" value="" name="s">
							</label>
							<input type="submit" class="search-submit" value="Search">
						</form>
					</div>
				</div>
				<div class="woo-cart-wrapper header-notifications-dropdown-toggle">
					<a class="rg-icon-wrap woo-cart-wrap dropdown-toggle" href="#" title="View your shopping cart">
						<span class="far fa-shopping-cart"></span>
						<?php if ( 0 < $cart_count ) { ?>
							<span class="cart-contents-count rg-count"><?php echo esc_html( $cart_count ); ?></span>
						<?php } ?>
					</a>
					<div class="rg-woocommerce_mini_cart header-notifications-dropdown-menu">
						<?php if ( ! empty( $cart->cart_contents ) && is_array( $cart->cart_contents ) ) { ?>
							<ul class="woocommerce-mini-cart cart_list product_list_widget">
								<?php foreach ( $cart->cart_contents as $cart_item_key => $cart_item ) {
									$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
									$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
									/**
									 * Filter the product name.
									 *
									 * @since 2.1.0
									 * @param string $product_name Name of the product in the cart.
									 * @param array $cart_item The product in the cart.
									 * @param string $cart_item_key Key for the product in the cart.
									 */
									$product_name = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );
					
									if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
										$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
										$thumbnail         = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
										?>
										<li class="woocommerce-mini-cart-item mini_cart_item" data-key="<?php echo esc_html( $cart_item_key ); ?>">
											<a href="<?php echo esc_url( wc_get_cart_remove_url( $cart_item_key ) ); ?>" class="remove remove_from_cart_button" aria-label="<?php echo esc_attr( sprintf( __( 'Remove %s from cart', 'woocommerce' ), wp_strip_all_tags( $product_name ) ) ); ?>" data-product_id="<?php echo esc_attr( $product_id ); ?>" data-cart_item_key="<?php echo esc_attr( $cart_item_key ); ?>" data-product_sku="">×</a>

											<?php if ( ! $product_permalink ) { ?>
												<?php echo $thumbnail; // PHPCS: XSS ok. ?>
												<?php echo esc_html( $product_name ); ?>
											<?php } else { ?>
												<a href="<?php echo esc_url( $product_permalink ); ?>">
													<?php echo $thumbnail; // PHPCS: XSS ok. ?>
													<?php echo esc_html( $product_name ); ?>
												</a>
											<?php } ?>
											<span class="quantity"><?php echo esc_html( $cart_item['quantity'] ); ?> × <?php echo wp_kses_post( WC()->cart->get_product_price( $_product ) ); ?>
										</li>
									<?php } ?>
								<?php } ?>
							</ul>
							<p class="woocommerce-mini-cart__total total">
								<strong>Subtotal:</strong> <?php wc_cart_totals_subtotal_html(); ?>
							</p>
							<p class="woocommerce-mini-cart__buttons buttons">
								<a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="button wc-forward">View cart</a>
								<a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" class="button checkout wc-forward">Checkout</a>
							</p>
						<?php } else {?>
							<p class="woocommerce-mini-cart__empty-message">No products in the cart.</p>
						<?php } ?>
					</div>
				</div>

				<?php if ( is_user_logged_in() ) {
					?>
					<!-- <div class="rg-msg header-notifications-dropdown-toggle">
						<a class="rg-icon-wrap dropdown-toggle" href="/members/info/messages">
							<span class="far fa-envelope"></span>
							<span class="count rg-count">2</span>
						</a>
						<div class="header-notifications-dropdown-menu" aria-labelledby="nav_private_messages">
							<div class="dropdown-title"><?php // esc_html_e( 'Messages', 'reign-theme-child' ); ?></div>
							<div class="dropdown-item-wrapper">
								<div class="dropdown-item">
									<div class="item-avatar">
										<img loading="lazy" src="https://installer.wbcomdesigns.com/dokan-interior-decorators/wp-content/themes/reign-theme/inc/reign-settings/imgs/default-mem-avatar.png" class="avatar user-31-avatar avatar-30 photo" width="30" height="30" alt="Profile picture of stevenmubaiwa1985" />
									</div>
									<div class="item-info">
										<div class="dropdown-item-title message-subject ellipsis">
											<a href="/members/info/messages/view/101/" class="color-primary">hello</a>
										</div>
										<p class="mute">August 19, 2023 at 5:19 pm</p>
									</div>
								</div>
								<div class="dropdown-item">
									<div class="item-avatar">
										<img loading="lazy" src="https://installer.wbcomdesigns.com/dokan-interior-decorators/wp-content/themes/reign-theme/inc/reign-settings/imgs/default-mem-avatar.png" class="avatar user-31-avatar avatar-30 photo" width="30" height="30" alt="Profile picture of stevenmubaiwa1985" />
									</div>
									<div class="item-info">
										<div class="dropdown-item-title message-subject ellipsis">
											<a href="/members/info/messages/view/101/" class="color-primary">hello</a>
										</div>
										<p class="mute">August 19, 2023 at 5:19 pm</p>
									</div>
								</div>
							</div>
							
							<div class="dropdown-footer">
								<a href="/messages/" class="button read-more"><?php esc_html_e( 'All Messages', 'reign-theme-child' ); ?></a>
							</div>
						</div> .header-notifications-dropdown-menu -->
					<!-- </div>
					<div class="user-notifications header-notifications-dropdown-toggle">
						<a class="rg-icon-wrap dropdown-toggle" href="#" title="Notifications">
							<span class="far fa-bell"></span>
							<sup class="count rg-count">2</sup>
						</a>
						<div class="header-notifications-dropdown-menu" aria-labelledby="nav_notification">
							<div class="dropdown-title">
								Notifications
								<a class="mark-read-all action-unread" data-notification-id="all">Mark all as read</a>
							</div>
							<div class="dropdown-item-wrapper">
								<div class="dropdown-item read-item unread">
									<div class="notification-item-content">
										<div class="item-avatar">
											<img loading="lazy" src="https://installer.wbcomdesigns.com/dokan-interior-decorators/wp-content/themes/reign-theme/inc/reign-settings/imgs/default-mem-avatar.png" class="avatar user-31-avatar avatar-100 photo" width="100" height="100" alt="Profile Photo" />
										</div>
										<div class="item-info">
											<div class="dropdown-item-title notification ellipsis">
												<a href="/members/info/messages/view/101/">stevenmubaiwa1985 sent you a new private message</a>
											</div>
											<p class="mute">9 months, 2 weeks ago</p>
										</div>
									</div>
									<div class="actions">
										<a class="mark-read action-unread primary" data-bp-tooltip-pos="left" data-bp-tooltip="Mark as Read" data-notification-id="282">
											<span class="dashicons dashicons-hidden" aria-hidden="true"></span>
										</a>
									</div>
								</div>
								<div class="dropdown-item read-item unread">
									<div class="notification-item-content">
										<div class="item-avatar">
											<img loading="lazy" src="https://installer.wbcomdesigns.com/dokan-interior-decorators/wp-content/themes/reign-theme/inc/reign-settings/imgs/default-mem-avatar.png" class="avatar user-84-avatar avatar-100 photo" width="100" height="100" alt="Profile Photo" />
										</div>
										<div class="item-info">
											<div class="dropdown-item-title notification ellipsis">
												<a href="/members/info/friends/requests/?new">You have a friendship request from stevenmubaiwa1985</a>
											</div>
											<p class="mute">9 months, 2 weeks ago</p>
										</div>
									</div>
									<div class="actions">
										<a class="mark-read action-unread primary" data-bp-tooltip-pos="left" data-bp-tooltip="Mark as Read" data-notification-id="281">
											<span class="dashicons dashicons-hidden" aria-hidden="true"></span>
										</a>
									</div>
								</div>
							</div>
							<div class="dropdown-footer">
								<a href="/notifications/" class="button read-more">All Notifications</a>
							</div>
						</div>
					</div> -->
					<div class="user-link-wrap header-notifications-dropdown-toggle">
						<a class="user-link dropdown-toggle" href="/members/info/">
							<span class="rg-user"><?php echo esc_html( $PeepSoUser->get_firstname() ); ?></span>
						</a>
						<a class="user-link" href="/my-account/">
							<img class="avatar avatar-200 photo" src="<?php echo esc_url( $PeepSoUser->get_avatar( 'full' ) ); ?>" alt="<?php printf( __( '%s avatar', 'peepso-core' ), $PeepSoUser->get_fullname() ); ?>" height="200" width="200" decoding="async" />
						</a>
						<ul id="user-profile-menu" class="user-profile-menu header-notifications-dropdown-menu">
							<li id="menu-item-2854" class="bp-menu bp-activity-nav menu-item menu-item-type-custom menu-item-object-custom menu-item-2854">
								<a href="<?php echo esc_url( $profile_url ); ?>"><i class="_mi _before reign fa fa-chart-line" aria-hidden="true"></i><span>Stream</span></a>
							</li>
							<li id="menu-item-2855" class="bp-menu bp-profile-nav menu-item menu-item-type-custom menu-item-object-custom menu-item-2855">
								<a href="<?php echo esc_url( $profile_url ) . 'about/'; ?>"><i class="_mi _before reign fa fa-user-alt" aria-hidden="true"></i><span>About</span></a>
							</li>
							<li id="menu-item-2858" class="bp-menu bp-friends-nav menu-item menu-item-type-custom menu-item-object-custom menu-item-2858">
								<a href="<?php echo esc_url( $profile_url ) . 'followers/'; ?>"><i class="_mi _before reign fa fa-users" aria-hidden="true"></i><span>Followers</span><span class="count"><?php echo esc_html( count( $followers ) ); ?></span></a>
							</li>
							<li id="menu-item-2860" class="bp-menu bp-settings-nav menu-item menu-item-type-custom menu-item-object-custom menu-item-2860">
								<a href="<?php echo esc_url( $profile_url ) . 'about/preferences/'; ?>"><i class="_mi _before reign fa fa-users-cog" aria-hidden="true"></i><span>Settings</span></a>
							</li>
							<li id="menu-item-2861" class="bp-menu bp-logout-nav menu-item menu-item-type-custom menu-item-object-custom menu-item-2861">
								<a href="<?php echo esc_url( wp_logout_url() ); ?>">
									<i class="_mi _before reign fa fa-sign-out-alt" aria-hidden="true"></i>
									<span>Log Out</span>
								</a>
							</li>
							<li id="menu-item-2907" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-2907">
								<a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>"><i class="_mi _before reign fa fa-shopping-bag" aria-hidden="true"></i><span>Shop</span></a>
							</li>
							<li id="menu-item-2978" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-2978">
								<a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'myaccount' ) ) ); ?>"><i class="_mi _before reign fa fa-user-circle" aria-hidden="true"></i><span>My account</span></a>
							</li>
							<li id="menu-item-2995" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-2995">
								<a href="/members/"><i class="_mi _before dashicons dashicons-admin-users" aria-hidden="true"></i><span>Members</span></a>
							</li>
							<li id="menu-item-2993" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-2993">
								<a href="/activity/"><i class="_mi _before dashicons dashicons-desktop" aria-hidden="true"></i><span>Activity</span></a>
							</li>
						</ul>
					</div>
				<?php } else {?>
					<div class="rg-icon-wrap rg-login-btn-wrap">
						<a href="/wp-login.php" class="btn-login button" title="Login">Login<span class="far fa-sign-in"></span></a>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>
