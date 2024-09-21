<?php
/**
 * Support For WooCommerce
 *
 * @package reign
 */

add_filter( 'reign_alter_display_right_sidebar', 'reign_alter_display_right_sidebar_for_woo', 10, 1 );

/**
 *
 * Function to hide right sideabr at woocommerce cart and shop page.
 *
 * @since 2.6.0
 */
function reign_alter_display_right_sidebar_for_woo( $display ) {
	if ( class_exists( 'WooCommerce' ) ) {
		if ( is_cart() || is_checkout() ) {
			$display = false;
		}
	}
	return $display;
}

// add_action( 'woocommerce_before_cart', 'reign_display_breadcrumb_at_checkout' );
// add_action( 'woocommerce_before_checkout_form', 'reign_display_breadcrumb_at_checkout' );
if ( ! class_exists( 'WooCommerce_Germanized' ) ) {
	add_action( 'rtm_post_begins', 'reign_display_breadcrumb_at_checkout' );
}

/**
 *
 * Function to display breadcrumb at woocommerce cart and checkout page.
 *
 * @since 2.6.0
 */
function reign_display_breadcrumb_at_checkout() {
	if ( class_exists( 'WooCommerce' ) ) {
		if ( is_cart() || is_checkout() || is_wc_endpoint_url( 'order-received' ) ) {
			?>
			<div class="rg-woo-breadcrumbs-wrapper page-title">
				<nav class="rg-woo-breadcrumbs breadcrumbs heading-font checkout-breadcrumbs h3">
					<a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="<?php echo esc_attr( reign_woo_checkout_breadcrumb_class( 'cart' ) ); ?>"><?php _e( 'Shopping Cart', 'reign' ); ?></a>
					<span class="divider hide-for-small"><i class="far fa-arrow-right"></i></span>
					<a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" class="<?php echo esc_attr( reign_woo_checkout_breadcrumb_class( 'checkout' ) ); ?>"><?php _e( 'Checkout details', 'reign' ); ?></a>
					<span class="divider hide-for-small"><i class="far fa-arrow-right"></i></span>
					<a href="#" class="no-click <?php echo esc_attr( reign_woo_checkout_breadcrumb_class( 'order-received' ) ); ?>"><?php esc_html_e( 'Order Complete', 'reign' ); ?></a>
				</nav>
			</div><!-- .page-title -->
			<?php
		}
	}
}

function reign_woo_checkout_breadcrumb_class( $endpoint ) {
	$classes = array();
	if ( $endpoint == 'cart' && is_cart() || $endpoint == 'checkout' && is_checkout() && ! is_wc_endpoint_url( 'order-received' ) ||
	$endpoint == 'order-received' && is_wc_endpoint_url( 'order-received' ) ) {
		$classes[] = 'current';
	} else {
		$classes[] = 'hide-for-small';
	}
	return implode( ' ', $classes );
}

add_action( 'woocommerce_before_account_navigation', 'reign_woo_my_account_avatar' );

function reign_woo_my_account_avatar() {
	$logout_url = ( function_exists( 'wc_logout_url' ) ) ? wc_logout_url() : wc_get_endpoint_url( 'customer-logout', '' );
	?>
	<div class="rg-woo-account-user circle">
		<div class="rg-woo-account-content-wrapper">
			<div class="rg-woo-user-avatar">
				<?php
				$current_user = wp_get_current_user();
				$user_id      = $current_user->ID;
				echo get_avatar( $user_id, 150 );
				?>
			</div>
			<div class="rg-woo-user-info">
				<div class="user-name">
					<?php
					echo $current_user->display_name; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					?>
				</div>
				<div class="user-email">
					<?php
					$current_user = wp_get_current_user();
					echo $current_user->user_email; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					?>
				</div>
				<div class="user-logout"><a href="<?php echo esc_url( $logout_url ); ?>"><?php esc_html_e( 'Logout', 'reign' ); ?></a></div>
			</div>
		</div>
	</div>
	<?php
}

if ( ! function_exists( 'reign_sanitize_checkbox' ) ) {
	/**
	 * Checkbox sanitization callback
	 *
	 * @since 7.1.2
	 */
	if ( class_exists( 'WooCommerce' ) ) {
		function reign_sanitize_checkbox( $checked ) {
			// Boolean check.
			return ( ( isset( $checked ) && true == $checked ) ? true : false );
		}
	}
}

// Remove orderby if disabled.
if ( ! get_theme_mod( 'reign_woo_shop_sort', true ) ) {
	remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
}

// Remove result count if disabled.
if ( ! get_theme_mod( 'reign_woo_shop_result_count', true ) ) {
	remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
}

/**
 * Checks if on the WooCommerce shop page.
 *
 * @since 7.1.2
 */
if ( ! function_exists( 'reign_is_woo_shop' ) ) {
	if ( class_exists( 'WooCommerce' ) ) {
		function reign_is_woo_shop() {
			if ( ! class_exists( 'WooCommerce' ) ) {
				return false;
			} elseif ( function_exists( 'is_shop' ) && is_shop() ) {
				return true;
			}
		}
	}
}

/**
 * Checks if on a WooCommerce tax.
 *
 * @since 7.1.2
 */
if ( ! function_exists( 'reign_is_woo_tax' ) ) {
	if ( class_exists( 'WooCommerce' ) ) {
		function reign_is_woo_tax() {
			if ( ! class_exists( 'WooCommerce' ) ) {
				return false;
			} elseif ( ! is_tax() ) {
				return false;
			} elseif ( function_exists( 'is_product_taxonomy' ) ) {
				if ( is_product_taxonomy() ) {
					return true;
				}
			}
		}
	}
}

/**
 * Add off canvas filter button.
 *
 * @since 7.1.2
 */

// if ( class_exists( 'WooCommerce' ) && true === get_theme_mod( 'reign_woo_off_canvas_filter', false ) ) {
// add_action( 'woocommerce_before_shop_loop', 'off_canvas_filter_button', 29 );
// }

if ( ! function_exists( 'off_canvas_filter_button' ) ) {
	if ( class_exists( 'WooCommerce' ) ) {
		function off_canvas_filter_button() {

			// Return if is not in shop page.
			if ( ! reign_is_woo_shop()
				&& ! reign_is_woo_tax() ) {
				return;
			}

			// Get filter text.
			$text = get_theme_mod( 'reign_woo_off_canvas_filter_text' );
			$text = $text ? $text : esc_html__( 'Filter', 'reign' );

			$output = '<a href="#" class="reign-woo-canvas-filter"><i class="far fa-filter" aria-hidden="true"></i><span class="off-canvas-filter-text">' . esc_html( $text ) . '</span></a>';

			echo apply_filters( 'reign_off_canvas_filter_button_output', $output ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Need to output HTML.
		}
	}
}

if ( ! function_exists( 'reign_has_woo_filter_button' ) ) {
	if ( class_exists( 'WooCommerce' ) ) {
		function reign_has_woo_filter_button() {
			if ( true === get_theme_mod( 'reign_woo_off_canvas_filter', false ) ) {
				return true;
			} else {
				return false;
			}
		}
	}
}

/**
 * Show WooCommerce Filter In Shop Page
 *
 * @since 7.1.2
 */
if ( ! function_exists( 'reign_filters_widget_side' ) ) {

	function reign_filters_widget_side() {
		$text = get_theme_mod( 'reign_woo_off_canvas_filter_text' );
		$text = $text ? $text : esc_html__( 'Filter', 'reign' );
		?>
		<div class="reign-filter-widget-side">
			<div class="widget-heading">
				<h3 class="widget-title"><?php echo esc_html( $text ); ?></h3>
				<a href="#" class="widget-close"><?php esc_html_e( 'close', 'reign' ); ?></a>
			</div>
			<div class="reign-module-filter">
				<div class="woocommerce">
					<div class="reign-woo-filter">
					<aside id="secondary" class="woo-off-canvas-sidebar">
						<?php dynamic_sidebar( 'reign_off_canvas_sidebar' ); ?>
					</aside>
					</div>
				</div>
			</div>
		</div>
		<?php
	}

	if ( class_exists( 'WooCommerce' ) && true === get_theme_mod( 'reign_woo_off_canvas_filter', false ) ) {
		add_action( 'reign_before_page', 'reign_filters_widget_side', 9 );
	}
}

/**
 * WooCommerce Filter Close
 *
 * @since 7.1.2
 */
if ( ! function_exists( 'reign_filters_widget_close_side' ) ) {
	function reign_filters_widget_close_side() {

		?>
		<div class="reign-woo-filter-close"></div>
		<?php
	}

	if ( class_exists( 'WooCommerce' ) && true === get_theme_mod( 'reign_woo_off_canvas_filter', false ) ) {
		add_action( 'reign_footer', 'reign_filters_widget_close_side' );
	}
}

/**
 * Product Thumbnail Hover Effect
 *
 * @since 7.1.2
 */
if ( ! function_exists( 'rg_woocommerce_before_shop_loop_item_title' ) ) {
	if ( class_exists( 'WooCommerce' ) && true === get_theme_mod( 'reign_woo_product_thumbnail_hover_effect', true ) ) {

		remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );

		function rg_woocommerce_before_shop_loop_item_title() {
			echo rg_woocommerce_get_product_thumbnail(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}

		add_action( 'woocommerce_before_shop_loop_item_title', 'rg_woocommerce_before_shop_loop_item_title', 10 );
	}
}

if ( ! function_exists( 'rg_woocommerce_get_product_thumbnail' ) ) {

	if ( class_exists( 'WooCommerce' ) && true === get_theme_mod( 'reign_woo_product_thumbnail_hover_effect', true ) ) {
		function rg_woocommerce_get_product_thumbnail( $size = 'woocommerce_thumbnail', $placeholder_width = 0, $placeholder_height = 0 ) {

			global $post, $product, $woocommerce;
			$image_ids = $product->get_gallery_image_ids();

			$output = '';

			if ( has_post_thumbnail() ) {

				$output .= '<div class="rg-product-images">';
				$output .= '<div class="primary-img">' . get_the_post_thumbnail( $post->ID, $size ) . '</div>';

				if ( ! empty( $image_ids ) ) {
					$secondary_image_id = $image_ids['0'];
					$output            .= '<div class="secondary-img">' . wp_get_attachment_image( $secondary_image_id, $size ) . '</div>';
				}

				$output .= '</div>';
			} elseif ( wc_placeholder_img_src() ) {

				$output .= '<div class="rg-product-images">';
				$output .= wc_placeholder_img( $size );
				$output .= '</div>';
			}

			return $output;
		}
	}
}

/**
 * Product archive layouts
 *
 * @since 7.5.2
 */
$reign_woo_product_layout = get_theme_mod( 'reign_woo_product_layout', 'woo_product_default' );

if ( 'woo_product_layout2' === $reign_woo_product_layout || 'woo_product_layout3' === $reign_woo_product_layout || 'woo_product_layout4' === $reign_woo_product_layout ) {
	// Add Woo Summary Wrap.
	remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
	add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_link_close', 24 );
	add_action(
		'woocommerce_shop_loop_item_title',
		function () {
			?>
			<div class="reign-woo-summary-wrap">
				<?php
		},
		9
	);

	add_action(
		'woocommerce_after_shop_loop_item',
		function () {
			?>
			</div>
			<?php
		},
		25
	);

	add_action( 'woocommerce_after_shop_loop_item_title', 'reign_wrapper_before_add_to_cart', 15 );

	if ( ! function_exists( 'reign_wrapper_before_add_to_cart' ) ) {
		function reign_wrapper_before_add_to_cart() {
			?>
			<div class="reign-woo-button-wrap">
			<?php
		}
	}

	add_action( 'woocommerce_after_shop_loop_item', 'reign_wrapper_after_add_to_cart', 15 );

	if ( ! function_exists( 'reign_wrapper_after_add_to_cart' ) ) {
		function reign_wrapper_after_add_to_cart() {
			?>
			</div>
			<?php
		}
	}
}

// Layout 2.
if ( 'woo_product_layout2' === $reign_woo_product_layout ) {

	remove_action( 'woocommerce_after_shop_loop_item_title', 'reign_wrapper_before_add_to_cart', 15 );
	remove_action( 'woocommerce_after_shop_loop_item', 'reign_wrapper_after_add_to_cart', 15 );

	// Move button inside image wrap.
	remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart' );

	/**
	 * Wrap image loop
	 */
	add_action(
		'woocommerce_before_shop_loop_item',
		function () {
			echo '<div class="loop-image-wrap">';
		},
		9
	);
	add_action(
		'woocommerce_before_shop_loop_item_title',
		function () {
			echo '</div>';
		},
		11
	);

	/**
	 * Wrap loop button
	 */
	function reign_wrap_loop_button_start() {

		$loop_button_wrap_classes = array( 'reign-woo-button-wrap' );

		/**
		 * Hook 'reign_loop_button_wrap_classes'
		 *
		 * @since 1.0.0
		 */
		echo '<div class="' . esc_attr( implode( ' ', apply_filters( 'reign_loop_button_wrap_classes', $loop_button_wrap_classes ) ) ) . '">';
	}

	add_action(
		'woocommerce_before_shop_loop_item_title',
		function () {
			reign_wrap_loop_button_start();
			woocommerce_template_loop_add_to_cart();
			echo '</div>';
		}
	);
}

if ( 'woo_product_layout4' === $reign_woo_product_layout ) {

	add_action( 'woocommerce_shop_loop_item_title', 'reign_wrapper_before_title', 9 );

	if ( ! function_exists( 'reign_wrapper_before_title' ) ) {
		function reign_wrapper_before_title() {
			?>
			<div class="reign-woo-summary-inner-wrap">
			<?php
		}
	}

	add_action( 'woocommerce_after_shop_loop_item_title', 'reign_wrapper_after_price', 10 );

	if ( ! function_exists( 'reign_wrapper_after_price' ) ) {
		function reign_wrapper_after_price() {
			?>
			</div>
			<?php
		}
	}

	remove_action( 'woocommerce_after_shop_loop_item_title', 'reign_wrapper_after_price', 10 );
	remove_action( 'woocommerce_after_shop_loop_item_title', 'reign_wrapper_before_add_to_cart', 15 );
	remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
	add_action( 'woocommerce_after_shop_loop_item', 'reign_wrapper_before_add_to_cart_layout_4', 15 );

	if ( ! function_exists( 'reign_wrapper_before_add_to_cart_layout_4' ) ) {
		function reign_wrapper_before_add_to_cart_layout_4() {
			?>
			<div class="reign-woo-button-wrap">
				<?php woocommerce_template_loop_add_to_cart(); ?>
			</div>
			<?php
		}
	}
}

/**
 * Product archive layouts switcher
 *
 * @since 7.5.2
 */

/**
 * Get default view for product catalog
 *
 * @return string
 */
function reign_get_default_catalog_view_mod() {

	$default = 'grid-four';

	$use_cookies = true;
	if ( is_customize_preview() ) {
		$use_cookies = false;
	}

	$reign_woo_layout_view_buttons = get_theme_mod( 'reign_woo_layout_view_buttons', true );

	if ( true === $reign_woo_layout_view_buttons ) {
		$use_cookies = false;
	}

	if ( $use_cookies ) { // Do not use cookie in customize.
		$cookie_mod = ( isset( $_COOKIE['reign_wc_pl_view_mod'] ) && $_COOKIE['reign_wc_pl_view_mod'] ) ? sanitize_text_field( $_COOKIE['reign_wc_pl_view_mod'] ) : false; // WPCS: sanitization ok.
		if ( $cookie_mod ) {
			if ( 'grid-four' == $cookie_mod ) {
				$default = $cookie_mod;
			}
		}
	}

	if ( ! $default ) {
		$default = 'grid-four';
	}

	return apply_filters( 'reign_get_default_catalog_view_mod', $default );
}

add_action( 'woocommerce_before_shop_loop', 'reign_wc_catalog_view_mod', 29 );
/**
 * Display switcher mod view
 *
 * @return string
 */
function reign_wc_catalog_view_mod() {

	$reign_woo_layout_view_buttons = get_theme_mod( 'reign_woo_layout_view_buttons', true );

	if ( false === $reign_woo_layout_view_buttons ) {
		return '';
	}

	if ( is_shop() || is_product_category() || is_product_tag() || is_product_taxonomy() ) {

		$default = reign_get_default_catalog_view_mod();
		$columns = intval( wc_get_loop_prop( 'columns', 4 ) );
		?>
		<div class="rg-wc-view-switcher">
			<a class="wc-view-mod one <?php echo ( 'grid-one' == $default ) ? 'active' : ''; ?>" href="#" data-mod="1">
				<svg width="6" height="16" viewBox="0 0 6 16" fill="none" xmlns="http://www.w3.org/2000/svg"> <rect width="2" height="16" rx="1" fill="#dddddd"></rect> </svg>
			</a>
			<a class="wc-view-mod two <?php echo ( 'grid-two' == $default ) ? 'active' : ''; ?>" href="#" data-mod="2">
				<svg width="6" height="16" viewBox="0 0 6 16" fill="none" xmlns="http://www.w3.org/2000/svg"> <rect width="2" height="16" rx="1" fill="#dddddd"></rect> <rect x="4" width="2" height="16" rx="1" fill="#dddddd"></rect> </svg>
			</a>
			<a class="wc-view-mod three <?php echo ( 'grid-three' == $default ) ? 'active' : ''; ?>" href="#" data-mod="3">
				<svg width="10" height="16" viewBox="0 0 10 16" fill="none" xmlns="http://www.w3.org/2000/svg"> <rect width="2" height="16" rx="1" fill="#dddddd"></rect> <rect x="4" width="2" height="16" rx="1" fill="#dddddd"></rect> <rect x="8" width="2" height="16" rx="1" fill="#dddddd"></rect> </svg>
			</a>
			<a class="wc-view-mod four <?php echo ( 'grid-four' == $default ) ? 'active' : ''; ?>" href="#" data-mod="4">
				<svg width="14" height="16" viewBox="0 0 14 16" fill="none" xmlns="http://www.w3.org/2000/svg"> <rect width="2" height="16" rx="1" fill="#dddddd"></rect> <rect x="4" width="2" height="16" rx="1" fill="#dddddd"></rect> <rect x="8" width="2" height="16" rx="1" fill="#dddddd"></rect> <rect x="12" width="2" height="16" rx="1" fill="#dddddd"></rect> </svg>
			</a>
			<?php if ( 5 === $columns ) : ?>
				<a class="wc-view-mod five <?php echo ( 'grid-five' == $default ) ? 'active' : ''; ?>" href="#" data-mod="5">
					<svg width="14" height="16" viewBox="0 0 14 16" fill="none" xmlns="http://www.w3.org/2000/svg"> <rect width="2" height="16" rx="1" fill="#dddddd"></rect> <rect x="4" width="2" height="16" rx="1" fill="#dddddd"></rect> <rect x="8" width="2" height="16" rx="1" fill="#dddddd"></rect> <rect x="12" width="2" height="16" rx="1" fill="#dddddd"></rect> <rect x="12" width="2" height="16" rx="1" fill="#dddddd"></rect> </svg>
				</a>
			<?php endif; ?>
		</div>
		<?php
	}
}

if ( class_exists( 'WooCommerce' ) && true === get_theme_mod( 'reign_woo_off_canvas_filter', false ) ) {
	add_action( 'woocommerce_before_shop_loop', 'off_canvas_filter_button', 29 );
}

if ( ! function_exists( 'rg_woocommerce_loader' ) ) {

	$reign_woo_layout_view_buttons = get_theme_mod( 'reign_woo_layout_view_buttons', true );

	/**
	 * Add WooCommerce shop page loader.
	 */
	function rg_woocommerce_loader() {
		if ( is_customize_preview() ) {
			return;
		}
		?>
		<div class="rg-woocommerce-loading-overlay">
			<div class="spinner"></div>
		</div>
		<?php
	}

	if ( true === $reign_woo_layout_view_buttons ) {
		add_action( 'woocommerce_before_shop_loop', 'rg_woocommerce_loader', 30 );
	}
}

/**
 * Identify products with manage stock and only one instock
 * This is needed because since WooCommerce 7.4.0 the quantity input is automatically hidden when the product has only one instock or is defined to "Limit purchases to 1 item per order"
 */
function reign_woocommerce_post_class( $classes, $product ) {

	if ( ! empty( $product->get_gallery_image_ids() ) ) {
		$classes[] = 'has-gallery-images';
	}

	return $classes;
}
add_filter( 'woocommerce_post_class', 'reign_woocommerce_post_class', 10, 2 );

/**
 * Single product top area wrapper
 */
function reign_single_product_wrap_before() {
	$classes = array( 'product-gallery-summary' );

	// Gallery layout.
	$reign_woo_single_product_image = get_theme_mod( 'reign_woo_single_product_image', 'product_image_layout1' );
	if ( 'product_image_layout2' === $reign_woo_single_product_image ) {
		$classes[] = 'gallery-vertical';
	} else {
		$classes[] = 'gallery-default';
	}

	// Thumbs slider.
	$classes[] = 'has-thumbs-slider';

	// Output.
	echo '<div class="' . esc_attr( implode( ' ', $classes ) ) . '">';
}
add_action( 'woocommerce_before_single_product_summary', 'reign_single_product_wrap_before', -99 );

/**
 * Single product top area wrapper
 */
function reign_single_product_wrap_after() {
	echo '</div>';
}
add_action( 'woocommerce_after_single_product_summary', 'reign_single_product_wrap_after', 9 );


$reign_woo_review_position = get_theme_mod( 'reign_woo_review_position', 'inside' );
/**
 * Single product review tab
 */
if ( 'outside' === $reign_woo_review_position ) {
	add_filter( 'woocommerce_product_tabs', 'reign_remove_reviews_tab', 98 );
}
/**
 * Function to remove the default Reviews tab
 *
 * @param array $tabs The existing tabs array.
 */
function reign_remove_reviews_tab( $tabs ) {
	unset( $tabs['reviews'] );
	return $tabs;
}

if ( 'outside' === $reign_woo_review_position ) {
	add_action( 'woocommerce_after_single_product_summary', 'reign_show_reviews', 14 );
}
/**
 * Function to display the reviews section after the single product summary
 */
function reign_show_reviews() {
	comments_template();
}

if ( ! function_exists( 'reign_reviews_summary_bar' ) ) {
	/**
	 * Custom function to display reviews summary bar.
	 */
	function reign_reviews_summary_bar() {
		global $product;
		$reign_woo_summary_bar = get_theme_mod( 'reign_woo_summary_bar', 'on' );

		// Get the total number of ratings.
		$rating_count   = $product->get_rating_count();
		$average_rating = $product->get_average_rating();
		$rating_counts  = $product->get_rating_counts();
		$total_ratings  = array_sum( $rating_counts );

		// Hide summary bar if there are no ratings.
		if ( 0 === $total_ratings || false === $reign_woo_summary_bar ) {
			return;
		}

		?>
		<div class="reign-summary-bar-wrapper">
			<?php
			// Display stars for the average rating.
			echo '<div class="summary-bar-left">';
			echo '<span class="average-rating-value"><strong>' . esc_html( $average_rating ) . '</strong></span>';
			echo '<span class="average-rating">';
			for ( $i = 1; $i <= 5; $i++ ) {
				// Add a CSS class to color the stars based on the review count.
				$star_class = $i <= round( $average_rating ) ? 'star-filled' : 'star-empty';
				echo '<i class="fas fa-star ' . esc_html( $star_class ) . '"></i>';
			}
			echo '</span>';
			// translators: %s is the number of reviews.
			echo '<span class="rating-count">' . sprintf( esc_attr( _n( 'Based on %s review', 'Based on %s reviews', $rating_count, 'reign' ) ), esc_attr( $rating_count ) ) . '</span>';
			echo '</div>';

			if ( $total_ratings > 0 ) {
				echo '<div class="summary-bar-right">';
				// Loop through each rating value (1 to 5) and display a bar for each.
				for ( $i = 5; $i >= 1; $i-- ) {
					$rating_count = isset( $rating_counts[ $i ] ) ? $rating_counts[ $i ] : 0;
					$percentage   = ( $rating_count / $total_ratings ) * 100;

					// Output the rating bar with all five stars and corresponding percentage.
					echo '<div class="rating-bar">';
					echo '<span class="rating-label">';
					for ( $j = 1; $j <= 5; $j++ ) {
						// Add a CSS class to color the stars based on the review count.
						$star_class = $j <= $i ? 'star-filled' : 'star-empty';
						echo '<i class="fas fa-star ' . esc_html( $star_class ) . '"></i>';
					}
					echo '</span>';
					echo '<div class="bar-container">';
					echo '<div class="bar" style="width: ' . esc_attr( $percentage ) . '%;"></div>';
					echo '</div>';
					// Translators: %s is a placeholder for the rating count.
					echo '<span class="rating-count">' . sprintf( esc_html( _n( '(%s)', '(%s)', $rating_count, 'reign' ) ), esc_html( $rating_count ) ) . '</span>';
					echo '</div>';
				}
				echo '</div>';
			}
			?>
		</div>
		<?php
	}

	// Hook the custom function into the desired position.
	add_action( 'woocommerce_after_single_product_summary', 'reign_reviews_summary_bar', 13 );
}

/**
 * Cart page.
 *
 * @since 7.5.2
 */
remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );
add_action( 'woocommerce_after_cart', 'woocommerce_cross_sell_display', 10 );

