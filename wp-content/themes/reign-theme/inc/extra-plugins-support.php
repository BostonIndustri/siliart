<?php
/* Resolving Changeset Related Issue In Theme Customizer */
add_filter(
	'get_post_status',
	function ( $post_status, $post ) {
		if ( ( $post->post_type == 'customize_changeset' ) && is_admin() ) {
			$post_status = '';
		}
		return $post_status;
	},
	10,
	2
);

/**
 * Compatibility with BP Create Group Type plugin
 * Return default group search form html
 * filter defined in BP Create Group Type plugin
 *
 * @since 1.0.0
 */
add_filter(
	'bpgt_modified_group_search_form',
	function ( $altered_search_form_html, $search_form_html ) {
		return $search_form_html;
	},
	10,
	2
);


/*
 * Support Added For WordPress Customizer API
 */
/**
 * Store current post ID
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'reigntm_post_id' ) ) {

	function reigntm_post_id() {

		// Default value
		$id = '';

		// If singular get_the_ID
		if ( is_singular() ) {
			$id = get_the_ID();
		}

		// Get ID of WooCommerce product archive
		elseif ( REIGN_WOOCOMMERCE_ACTIVE && is_shop() ) {
			$shop_id = wc_get_page_id( 'shop' );
			if ( isset( $shop_id ) ) {
				$id = $shop_id;
			}
		}

		// Posts page
		elseif ( is_home() && $page_for_posts = get_option( 'page_for_posts' ) ) {
			$id = $page_for_posts;
		}

		// Apply filters
		$id = apply_filters( 'wbcom_post_id', $id );

		// Sanitize
		$id = $id ? $id : '';

		// Return ID
		return $id;
	}
}

/* register_elementor_locations */
if ( ! function_exists( 'reign_register_elementor_locations' ) ) {
	function reign_register_elementor_locations( $elementor_theme_manager ) {

			// $elementor_theme_manager->register_all_core_location();
			$elementor_theme_manager->register_location( 'header' );
			$elementor_theme_manager->register_location( 'footer' );
	}
	add_action( 'elementor/theme/register_locations', 'reign_register_elementor_locations' );
}

/* Add Cart icon and count to header if WC is active */

function my_wc_cart_count() {
	if ( is_admin() ) {
		return;
	}
	if ( class_exists( 'WooCommerce' ) ) {
		if ( is_admin() ) {
			$count = '';
		} else {
			$count = WC()->cart->get_cart_contents_count();
		}
		?>
		<div class="woo-cart-wrapper header-notifications-dropdown-toggle">
			<a class="rg-icon-wrap woo-cart-wrap dropdown-toggle" href="#" title="<?php esc_attr_e( 'View your shopping cart', 'reign' ); ?>">
				<span class="far fa-shopping-cart"></span>
				<?php
				if ( $count > 0 ) {
					?>
					<span class="cart-contents-count rg-count"><?php echo esc_html( $count ); ?></span>
					<?php
				}
				?>
			</a>

			<div class="rg-woocommerce_mini_cart header-notifications-dropdown-menu">
				<?php woocommerce_mini_cart(); ?>
			</div>
		</div>
		<?php
	}

	if ( class_exists( 'Easy_Digital_Downloads' ) ) {
		if ( is_admin() ) {
			$count = '0';
		} else {
			$count = edd_get_cart_quantity();
		}
		?>
		<div class="edd-cart-wrapper header-notifications-dropdown-toggle">
			<a class="rg-icon-wrap edd-cart-wrap dropdown-toggle" href="<?php echo esc_url( edd_get_checkout_uri() ); ?>" title="<?php esc_attr_e( 'View your shopping cart', 'reign' ); ?>">
				<span class="far fa-shopping-cart"></span>
				<span class="cart-contents-count rg-count edd-cart-quantity"><?php echo esc_html( $count ); ?></span>
			</a>
			<div class="rg-edd_mini_cart header-notifications-dropdown-menu">
				<?php echo do_shortcode( '[download_cart]' ); ?>
			</div>
		</div>
		<?php
	}
}

/**
 * WooCommerce Mini Cart
 */

/* Ensure cart contents update when products are added to the cart via AJAX */
add_filter( 'woocommerce_add_to_cart_fragments', 'my_header_add_to_cart_fragment' );

function my_header_add_to_cart_fragment( $fragments ) {
	$count = WC()->cart->get_cart_contents_count();
	ob_start();
	?>
	<a class="rg-icon-wrap woo-cart-wrap dropdown-toggle" href="#" title="<?php esc_attr_e( 'View your shopping cart', 'reign' ); ?>">
		<span class="far fa-shopping-cart"></span>
		<?php
		if ( $count > 0 ) {
			?>
			<span class="cart-contents-count rg-count"><?php echo esc_html( $count ); ?></span>
			<?php
		}
		?>
	</a>
	<?php
	$fragments['a.rg-icon-wrap.woo-cart-wrap.dropdown-toggle'] = ob_get_clean();
	return $fragments;
}

/* Ensure mini cart contents update when products are added to the cart via AJAX */
add_filter(
	'woocommerce_add_to_cart_fragments',
	function ( $fragments ) {

		ob_start();
		?>

		<div class="rg-woocommerce_mini_cart header-notifications-dropdown-menu">
			<?php woocommerce_mini_cart(); ?>
		</div>

		<?php
		$fragments['.rg-woocommerce_mini_cart.header-notifications-dropdown-menu'] = ob_get_clean();

		return $fragments;
	}
);

// add_shortcode( 'reign_woo_mini_cart', 'reign_woo_mini_cart_render' );

function reign_woo_mini_cart_render() {
	if ( class_exists( 'WooCommerce' ) ) {
		if ( is_admin() ) {
			$count = '0';
		} else {
			$count = WC()->cart->get_cart_contents_count();
		}
		?>
		<div id="rg-mobile-icon-toggle" data-id="rg-slidebar-toggle">
			<a class="rg-icon-wrap woo-cart-wrap dropdown-toggle" href="#" title="<?php esc_attr_e( 'View your shopping cart', 'reign' ); ?>">
				<span class="far fa-shopping-cart"></span>
				<span class="cart-contents-count rg-count"><?php echo esc_html( $count ); ?></span>
			</a>
		</div>
		<?php
	}
}

add_shortcode( 'reign_bp_user_menu', 'reign_bp_user_menu_toggle_render' );

function reign_bp_user_menu_toggle_render() {
	if ( is_user_logged_in() ) {
		$current_user = wp_get_current_user();
		if ( ( $current_user instanceof WP_User ) ) {
			if ( function_exists( 'buddypress' ) && version_compare( buddypress()->version, '12.0', '>=' ) ) {
				$user_link = function_exists( 'bp_members_get_user_url' ) ? bp_members_get_user_url( get_current_user_id() ) : '#';
			} else {
				$user_link = function_exists( 'bp_core_get_user_domain' ) ? bp_core_get_user_domain( get_current_user_id() ) : '#';
			}
			echo '<div id="rg-mobile-icon-toggle" data-id="rg-slidebar-toggle">';
			echo '<div class="user-link">';
			echo get_avatar( $current_user->user_email, 200 );
			echo '</div>';
			echo '</div>';
		}
	} else {
		// Login Page Redirect.
		$login_page_id  = get_theme_mod( 'reign_login_page', 0 );
		$login_page_url = ( $login_page_id ) ? get_permalink( $login_page_id ) : wp_login_url();

		// Register Page Redirect.
		$registration_page_id  = get_theme_mod( 'reign_registration_page', 0 );
		$registration_page_url = ( $registration_page_id ) ? get_permalink( $registration_page_id ) : wp_registration_url();
		?>
		<div class="rg-icon-wrap">
			<a href="<?php echo esc_url( $login_page_url ); ?>" class="btn-login" title="<?php esc_attr_e( 'Login', 'reign' ); ?>">
				<span class="far fa-sign-in"></span>
			</a>
		</div>
		<?php
		if ( get_option( 'users_can_register' ) ) {
			?>
			<span class="sep">|</span>
			<div class="rg-icon-wrap">
				<a href="<?php echo esc_url( $registration_page_url ); ?>" class="btn-register" title="<?php esc_attr_e( 'Register', 'reign' ); ?>">
					<span class="far fa-address-book"></span>
				</a>
			</div>
			<?php
		}
	}
}

function reign_get_image_id_from_url( $image_url ) {
	global $wpdb;
	$attachment_id = '';
	$attachment    = $wpdb->get_col( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE guid='%s';", $image_url ) );
	if ( $attachment ) {
		$attachment_id = $attachment[0];
	}
	return $attachment_id;
}

// add_shortcode( 'reign_download_cart', 'reign_edd_download_cart_render' );

function reign_edd_download_cart_render() {
	if ( class_exists( 'Easy_Digital_Downloads' ) ) {
		if ( is_admin() ) {
			$count = '0';
		} else {
			$count = edd_get_cart_quantity();
		}
		?>
		<div id="rg-mobile-icon-toggle" data-id="rg-slidebar-toggle">
			<a class="rg-icon-wrap edd-cart-wrap dropdown-toggle" href="#" title="<?php esc_attr_e( 'View your shopping cart', 'reign' ); ?>">
				<span class="far fa-shopping-cart"></span>
				<span class="cart-contents-count rg-count edd-cart-quantity"><?php echo esc_html( $count ); ?></span>
			</a>
		</div>
		<?php
	} else {

	}
}

add_action( 'after_switch_theme', 'reign_peepso_set_default_social_fields' );

function reign_peepso_set_default_social_fields() {
	global $wbtm_reign_settings;

	$wbtm_peepso_social_links = isset( $wbtm_reign_settings['reign_peepsoextender']['wbtm_social_links'] ) ? $wbtm_reign_settings['reign_peepsoextender']['wbtm_social_links'] : array();
	if ( empty( $wbtm_peepso_social_links ) ) {
		$wbtm_peepso_social_links = array(
			'facebook' => array(
				'img_url' => '',
				'name'    => __( 'Facebook', 'reign' ),
			),
			'twitter'  => array(
				'img_url' => '',
				'name'    => __( 'Twitter', 'reign' ),
			),
			'linkedin' => array(
				'img_url' => '',
				'name'    => __( 'Linkedin', 'reign' ),
			),
		);
		$wbtm_reign_settings['reign_peepsoextender']['wbtm_social_links'] = $wbtm_peepso_social_links;
		update_option( 'reign_options', $wbtm_reign_settings );
		$wbtm_reign_settings = get_option( 'reign_options', array() );
	}

	/*
	* Set Default value when activate reign theme
	*/
	if ( empty( $wbtm_reign_settings['reign_buddyextender'] ) ) {
		$wbtm_reign_settings['reign_buddyextender']['member_header_position'] = 'top';
		$wbtm_reign_settings['reign_buddyextender']['member_header_type']     = 'wbtm-cover-header-type-3';
		$wbtm_reign_settings['reign_buddyextender']['group_header_type']      = 'wbtm-cover-header-type-3';
		$wbtm_reign_settings['reign_buddyextender']['member_directory_type']  = 'wbtm-member-directory-type-2';
		$wbtm_reign_settings['reign_buddyextender']['group_directory_type']   = 'wbtm-group-directory-type-2';

		$wbtm_reign_settings['reign_buddyextender']['member_cover_image'] = 'on';
		$wbtm_reign_settings['reign_buddyextender']['group_image']        = 'on';
		$wbtm_reign_settings['reign_buddyextender']['group_cover_image']  = 'on';
		update_option( 'reign_options', $wbtm_reign_settings );
		$wbtm_reign_settings = get_option( 'reign_options', array() );
	}
}

/**
 * Showing PeepSo group cover image.
 */
if ( ! function_exists( 'reign_render_peepso_group_cover_image' ) ) {

	function reign_render_peepso_group_cover_image() {
		global $wbtm_reign_settings;
		$cover_img_url = isset( $wbtm_reign_settings['reign_peepsoextender']['default_group_cover_image_url'] ) ? $wbtm_reign_settings['reign_peepsoextender']['default_group_cover_image_url'] : REIGN_INC_DIR_URI . 'reign-settings/imgs/default-cover.jpg';
		if ( empty( $cover_img_url ) ) {
			$cover_img_url = REIGN_INC_DIR_URI . 'reign-settings/imgs/default-cover.jpg';
		}
		return $cover_img_url;
	}
}

/**
 * Showing PeepSo member cover image.
 */
if ( ! function_exists( 'reign_render_peepso_member_cover_image' ) ) {

	function reign_render_peepso_member_cover_image() {
		global $wbtm_reign_settings;
		$cover_img_url = isset( $wbtm_reign_settings['reign_peepsoextender']['default_profile_cover_image_url'] ) ? $wbtm_reign_settings['reign_peepsoextender']['default_profile_cover_image_url'] : REIGN_INC_DIR_URI . 'reign-settings/imgs/default-cover.jpg';
		if ( empty( $cover_img_url ) ) {
			$cover_img_url = REIGN_INC_DIR_URI . 'reign-settings/imgs/default-cover.jpg';
		}
		return $cover_img_url;
	}
}

/**
 * Get PeepSo member cover image.
 */
if ( ! function_exists( 'reign_get_peepso_member_cover_image' ) ) {

	function reign_get_peepso_member_cover_image( $size = 0 ) {
		$cover         = null;
		$PeepSoProfile = PeepSoProfile::get_instance();
		$PeepSoUser    = $PeepSoProfile->user;
		$cover_hash    = get_user_meta( $PeepSoUser->get_id(), 'peepso_cover_hash', true );

		if ( $cover_hash ) {
			$cover_hash = $cover_hash . '-';
		}
		$filename = $cover_hash . 'cover.jpg';
		if ( file_exists( $PeepSoUser->get_image_dir() . $filename ) ) {
			$cover = $PeepSoUser->get_image_url() . $filename;

			if ( is_int( $size ) && $size > 0 ) {
				$filename_scaled = $cover_hash . 'cover-' . $size . '.jpg';
				if ( ! file_exists( $PeepSoUser->get_image_dir() . $filename_scaled ) ) {
					$si = new PeepSoSimpleImage();
					$si->png_to_jpeg( $PeepSoUser->get_image_dir() . $filename );
					$si->load( $PeepSoUser->get_image_dir() . $filename );
					$si->resizeToWidth( $size );
					$si->save( $PeepSoUser->get_image_dir() . $filename_scaled, IMAGETYPE_JPEG );
				}

				$cover = $PeepSoUser->get_image_url() . $filename_scaled;
			}
		}

		return $cover;
	}
}

/**
 * Get all social fields added in backend.
 */
function reign_get_peepso_user_social_array() {
	global $wbtm_reign_settings;
	$wbtm_social_links = isset( $wbtm_reign_settings['reign_peepsoextender']['wbtm_social_links'] ) ? $wbtm_reign_settings['reign_peepsoextender']['wbtm_social_links'] : array();
	return $wbtm_social_links;
}

/**
 * Added a class for group directory in body class.
 */
add_filter( 'body_class', 'reign_peepso_body_class', 999, 2 );

function reign_peepso_body_class( $classes, $class ) {
	if ( class_exists( 'PeepSo' ) ) {
		array_push( $classes, 'reign_peepso_active' );
		$peepso_url_segments = PeepSoUrlSegments::get_instance();
		if ( ( 'peepso_groups' === $peepso_url_segments->_shortcode ) && ( sizeof( $peepso_url_segments->_segments ) == 1 ) ) {
			if ( is_array( $classes ) ) {
				array_push( $classes, 'reign_peepso_group_directory_page' );
			}
		}
	}
	return $classes;
}

/**
 * Added social links fields in user profile.
 */
add_filter( 'peepso_profile_edit_form', 'reign_peepso_profile_edit_form', 10, 1 );

function reign_peepso_profile_edit_form( $form ) {
	$user_id = get_current_user_id();
	if ( ! empty( $form ) ) {
		if ( isset( $form['fields'] ) ) {
			$fields        = $form['fields'];
			$social_fields = reign_get_peepso_user_social_array();
			if ( ! empty( $social_fields ) ) {
				foreach ( $social_fields as $field_slug => $social ) {
					$social_link = get_user_meta( $user_id, 'wbcom_social_' . $field_slug, true );
					if ( empty( $social_link ) ) {
						$social_link = '';
					}
					$val    = array(
						'section' => esc_html__( 'Your Account', 'reign' ),
						'label'   => $social['name'],
						'type'    => 'text',
						'value'   => $social_link,
						'html'    => $social_link,
					);
					$fields = array_slice( $fields, 0, count( $fields ) - 2, true ) +
					array( 'wbcom_social_' . $field_slug => $val ) +
					array_slice( $fields, count( $fields ) - 2, count( $fields ) - ( count( $fields ) - 2 ), true );
				}
				$form['fields'] = $fields;
			}
		}
	}
	return $form;
}

add_action( 'peepso_save_profile_form', 'reign_peepso_profile_after_save', 10, 1 );

function reign_peepso_profile_after_save( $userid ) {
	$form_arr = filter_input_array( INPUT_POST, FILTER_DEFAULT, FILTER_REQUIRE_ARRAY );
	if ( filter_input( INPUT_POST, 'account' ) ) {
		foreach ( $form_arr as $key => $value ) {
			if ( strpos( $key, 'wbcom_social_' ) !== false ) {
				$social_link = sanitize_text_field( $form_arr[ $key ] );
				update_user_meta( $userid, $key, $social_link );
			}
		}
	}
}

function reign_peepso_social_not_all_empty( $userid ) {
	$social_fields = reign_get_peepso_user_social_array();
	if ( ! empty( $social_fields ) ) {
		foreach ( $social_fields as $field_slug => $social ) {
			$social_link = get_user_meta( $userid, 'wbcom_social_' . $field_slug, true );
			if ( ! empty( $social_link ) ) {
				return true;
			}
		}
	}
	return false;
}

/**
 * Added social links fields in user profile.
 */
function reign_peepso_user_social_links( $userid ) {
	$social_fields = reign_get_peepso_user_social_array();
	if ( ! empty( $social_fields ) && reign_peepso_social_not_all_empty( $userid ) ) {

		$html_to_render = '';
		$counter        = 0;
		$first_time     = true;

		foreach ( $social_fields as $field_slug => $social ) {
			++$counter;
			$social_link = get_user_meta( $userid, 'wbcom_social_' . $field_slug, true );

			if ( ! isset( $social_link ) || empty( $social_link ) ) {
				continue;
			}

			if ( $first_time ) {
				$html_to_render .= '<ul>';
				$first_time      = false;
			}

			$html_to_render .= '<li>';
			$html_to_render .= '<a href="' . esc_url( $social_link ) . '" title="' . esc_attr( $social['name'] ) . '">';

			if ( empty( $social['img_url'] ) ) {
				$html_to_render .= '<i class="fab fa-' . esc_attr( strtolower( trim( $social['name'] ) ) ) . '"></i>';
			} else {
				$html_to_render .= '<img src="' . esc_url( $social['img_url'] ) . '" alt="' . esc_attr( $social['name'] ) . '" />';
			}

			$html_to_render .= '</a>';
			$html_to_render .= '</li>';

			if ( $counter == count( $social_fields ) ) {
				$html_to_render .= '</ul>';
			}
		}
		echo wp_kses_post( $html_to_render );
	}
}

add_action( 'reign_header_v4_middle_section_html', 'reign_header_v4_middle_section_search' );
function reign_header_v4_middle_section_search() {
	$choose_search = get_theme_mod( 'reign_header_search_option', 'product_search' );

	if ( class_exists( 'WooCommerce' ) ) {
		$check_search = $choose_search;
	} else {
		$check_search = 'default_search';
	}

	if ( 'product_search' === $check_search ) {
		the_widget( 'WC_Widget_Product_Search' );
	} elseif ( function_exists( 'get_search_form' ) ) {
			get_search_form();
	}
}

add_action( 'init', 'reign_peepso_default_widgets', 15 );

/**
 * Set default widgets in Left, Right sidebars and Header Widget area.
 */
function reign_peepso_default_widgets() {
	$active_widgets       = get_option( 'sidebars_widgets' );
	$default_reign_widget = get_option( 'set_default_peepso_reign_widgets' );

	if ( empty( $default_reign_widget ) ) {
		$default_reign_widget = array();
	}
	if ( class_exists( 'PeepSo' ) ) {

		// Set default widgets in Header Area.
		if ( ! array_key_exists( 'peepso_reign_header_widget', $default_reign_widget ) ) {
			$default_widget_content = array();
			$counter                = ! empty( $active_widgets['reign-header-widget-area'] ) ? count( $active_widgets['reign-header-widget-area'] ) + 1 : '';
			if ( empty( $active_widgets['reign-header-widget-area'] ) ) {
				$active_widgets['reign-header-widget-area'][0] = 'peepsowidgetuserbar-' . $counter;
			} else {
				array_push( $active_widgets['reign-header-widget-area'], 'peepsowidgetuserbar-' . $counter );
			}
			$default_widget_content[ $counter ] = array(
				'content_position'   => 'left',
				'show_avatar'        => 1,
				'show_name'          => 1,
				'show_notifications' => 1,
				'show_usermenu'      => 1,
				'show_logout'        => 1,
			);
			update_option( 'widget_peepsowidgetuserbar', $default_widget_content );
			$default_reign_widget['peepso_reign_header_widget'] = 1;
		}

		// Set default widgets in left sidebar.
		if ( ! array_key_exists( 'peepso_reign_sidebar_left_profile', $default_reign_widget ) ) {
			$default_widget_content = array();
			$counter                = ! empty( $active_widgets['sidebar-left'] ) ? count( $active_widgets['sidebar-left'] ) + 1 : '';
			if ( empty( $active_widgets['sidebar-left'] ) ) {
				$active_widgets['sidebar-left'][0] = 'peepsowidgetme-' . $counter;
			} else {
				array_unshift( $active_widgets['sidebar-left'], 'peepsowidgetme-' . $counter );
			}
			$default_widget_content[ $counter ] = array(
				'show_notifications'   => 1,
				'show_community_links' => 1,
				'show_cover'           => 1,
			);
			update_option( 'widget_peepsowidgetme', $default_widget_content );
			$default_reign_widget['peepso_reign_sidebar_left_profile'] = 1;
		}

		// Set default widget in right sidebar.
		// 1. Set online members widget.
		if ( ! array_key_exists( 'peepso_reign_sidebar_right_online_members', $default_reign_widget ) ) {
			$default_widget_content = array();
			$counter                = 1;
			if ( empty( $active_widgets['sidebar-right'] ) ) {
				$active_widgets['sidebar-right'][0] = 'peepsowidgetonlinemembers-' . $counter;
			} else {
				array_unshift( $active_widgets['sidebar-right'], 'peepsowidgetonlinemembers-' . $counter );
			}
			$default_widget_content[ $counter ] = array( 'limit' => 12 );
			update_option( 'widget_peepsowidgetonlinemembers', $default_widget_content );
			$default_reign_widget['peepso_reign_sidebar_right_online_members'] = 1;
		}

		// 2. Set community audio-video widget.
		if ( class_exists( 'PeepSoVideos' ) ) {
			if ( ! array_key_exists( 'peepso_reign_sidebar_right_community_videos', $default_reign_widget ) ) {
				$default_widget_content = array();
				$counter                = 1;
				if ( empty( $active_widgets['sidebar-right'] ) ) {
					$active_widgets['sidebar-right'][0] = 'peepsowidgetcommunityvideos-' . $counter;
				} else {
					array_unshift( $active_widgets['sidebar-right'], 'peepsowidgetcommunityvideos-' . $counter );
				}
				$default_widget_content[ $counter ] = array(
					'limit'      => 12,
					'media_type' => 'video',
					'hideempty'  => 0,
				);
				update_option( 'widget_peepsowidgetcommunityvideos', $default_widget_content );
				$default_reign_widget['peepso_reign_sidebar_right_community_videos'] = 1;
			}
		}

		// 3. Set photos widget.
		if ( class_exists( 'PeepSoSharePhotos' ) ) {
			if ( ! array_key_exists( 'peepso_reign_sidebar_right_photos', $default_reign_widget ) ) {
				$default_widget_content = array();
				$counter                = 1;
				if ( empty( $active_widgets['sidebar-right'] ) ) {
					$active_widgets['sidebar-right'][0] = 'peepsowidgetphotos-' . $counter;
				} else {
					array_unshift( $active_widgets['sidebar-right'], 'peepsowidgetphotos-' . $counter );
				}
				$default_widget_content[ $counter ] = array(
					'limit'     => 12,
					'hideempty' => 0,
				);
				update_option( 'widget_peepsowidgetphotos', $default_widget_content );
				$default_reign_widget['peepso_reign_sidebar_right_photos'] = 1;
			}
		}

		// 4. Set hashtag widget.
		if ( class_exists( 'PeepSoWidgetHashtags' ) ) {
			if ( ! array_key_exists( 'peepso_reign_sidebar_right_hashtags', $default_reign_widget ) ) {
				$default_widget_content = array();
				$counter                = 1;
				if ( empty( $active_widgets['sidebar-right'] ) ) {
					$active_widgets['sidebar-right'][0] = 'peepsowidgethashtags-' . $counter;
				} else {
					array_unshift( $active_widgets['sidebar-right'], 'peepsowidgethashtags-' . $counter );
				}
				$default_widget_content[ $counter ] = array( 'limit' => 12 );
				update_option( 'widget_peepsowidgethashtags', $default_widget_content );
				$default_reign_widget['peepso_reign_sidebar_right_hashtags'] = 1;
			}
		}

		update_option( 'sidebars_widgets', $active_widgets );
		update_option( 'set_default_peepso_reign_widgets', $default_reign_widget );
	}
}

add_action( 'peepso_init', 'reign_peepso_page_default_sidebar', 15 );

/**
 * Set default sidebar and page template in PeepSo pages.
 */
function reign_peepso_page_default_sidebar() {
	$pages         = array(
		'page_activity'  => PeepSo::get_option( 'page_activity' ),
		'page_members'   => PeepSo::get_option( 'page_members' ),
		'page_profile'   => PeepSo::get_option( 'page_profile' ),
		'page_groups'    => PeepSo::get_option( 'page_groups' ),
		'page_messages'  => PeepSo::get_option( 'page_messages' ),
		'page_wpadverts' => 'wpadverts',
	);
	$updated_pages = get_option( 'set_default_peepso_reign_page_sidebar' );
	$theme_slug    = apply_filters( 'wbcom_essential_theme_slug', 'reign' );

	if ( empty( $updated_pages ) ) {
		$updated_pages = array();
	}

	foreach ( $pages as $key => $slug ) {
		if ( PeepSo::get_page( $slug ) ) {
			if ( ! isset( $updated_pages[ $slug ] ) ) {
				$wbcom_metabox_data = get_post_meta( url_to_postid( PeepSo::get_page( $slug ) ), $theme_slug . '_wbcom_metabox_data', true );
				if ( empty( $wbcom_metabox_data ) ) {
					$wbcom_metabox_data = array();
				}
				$wbcom_metabox_data['layout'] = array(
					'site_layout'       => 'both_sidebar',
					'primary_sidebar'   => 'sidebar-right',
					'secondary_sidebar' => 'sidebar-left',
				);
				update_post_meta( url_to_postid( PeepSo::get_page( $slug ) ), $theme_slug . '_wbcom_metabox_data', $wbcom_metabox_data );
				$updated_pages[ $slug ] = 1;
			}

			// Set Page template.
			if ( 'page_profile' === $key || 'page_groups' === $key ) {
				if ( ! isset( $updated_pages[ $key . '_template' ] ) ) {
					$template                            = update_post_meta( url_to_postid( PeepSo::get_page( $slug ) ), '_wp_page_template', 'page-peepso-single-layout.php' );
					$updated_pages[ $key . '_template' ] = 1;
				}
			}
		}
	}
	update_option( 'set_default_peepso_reign_page_sidebar', $updated_pages );
}

add_filter( 'reign_alter_display_right_sidebar', 'reign_peepso_display_right_sidebar_for_woo', 11, 1 );

/**
 * Display Right sidebar for cart and checkout tab in PeepSo pages.
 */
function reign_peepso_display_right_sidebar_for_woo( $display ) {
	if ( class_exists( 'PeepSo' ) ) {
		$peepso_url_segments = PeepSoUrlSegments::get_instance();
		if ( ( 'peepso_profile' === $peepso_url_segments->_shortcode ) ) {
			if ( class_exists( 'WooCommerce' ) ) {
				if ( is_cart() || is_checkout() ) {
					$display = true;
				}
			}
		}
	}
	return $display;
}

add_filter( 'peepso_hovercard', 'reign_peepso_member_hovercard', 10, 2 );

function reign_peepso_member_hovercard( $res, $uid ) {
	$cover      = null;
	$size       = 750;
	$PeepSoUser = PeepSoUser::get_instance( $uid );
	$cover_hash = get_user_meta( $uid, 'peepso_cover_hash', true );

	if ( $cover_hash ) {
		$cover_hash = $cover_hash . '-';
	}
	$filename = $cover_hash . 'cover.jpg';
	if ( file_exists( $PeepSoUser->get_image_dir() . $filename ) ) {
		$cover = $PeepSoUser->get_image_url() . $filename;

		if ( is_int( $size ) && $size > 0 ) {
			$filename_scaled = $cover_hash . 'cover-' . $size . '.jpg';
			if ( ! file_exists( $PeepSoUser->get_image_dir() . $filename_scaled ) ) {
				$si = new PeepSoSimpleImage();
				$si->png_to_jpeg( $PeepSoUser->get_image_dir() . $filename );
				$si->load( $PeepSoUser->get_image_dir() . $filename );
				$si->resizeToWidth( $size );
				$si->save( $PeepSoUser->get_image_dir() . $filename_scaled, IMAGETYPE_JPEG );
			}

			$cover = $PeepSoUser->get_image_url() . $filename_scaled;
		}
	}
	if ( empty( $cover ) ) {
		$cover = reign_render_peepso_member_cover_image();
	}
	$res['cover'] = $cover;
	return $res;
}

/**
 * Reign Dokan :: Product Edit Page Add Class
 */
function wb_reign_manage_body_class( $classes ) {
	if ( function_exists( 'is_product' ) ) {
		if ( is_product() && get_query_var( 'edit' ) ) {
			$classes[] = 'rda-product-edit-screen';
		}
	}
	return $classes;
}

add_action( 'body_class', 'wb_reign_manage_body_class', 10, 1 );

function reign_bbp_get_reply_avtar( $topic_id = 0 ) {
	if ( class_exists( 'bbPress' ) ) {

		$topic_id = bbp_get_topic_id( $topic_id );

		$r = array(
			'post_type'      => 'reply',
			'post_parent'    => $topic_id,
			'post_status'    => 'publish',
			'posts_per_page' => 4,
			'orderby'        => 'date',
			'order'          => 'DESC',
		);

		$replies = new WP_Query( $r );
		if ( isset( $replies->posts ) ) {
			$reply_author_avtar = '';
			foreach ( $replies->posts as $key => $reply ) {
				echo get_avatar( $reply->post_author );
			}
		}
	}
	wp_reset_postdata();
}

/**
 * Shortcode for Buddypress Member Carousel
 *
 * @param array $atts shortcode attributes
 */
function reign_bp_memeber_carousel( $atts ) {
	global $members_template, $wbtm_reign_settings;
	// Attributes
	$atts = shortcode_atts(
		array(
			'max_members' => '5',
			'member_sort' => 'active',
			'member_name' => 'show',
		),
		$atts
	);

	// Setup args for querying members.
	$members_args = array(
		'user_id'         => 0,
		'type'            => $atts['member_sort'],
		'per_page'        => $atts['max_members'],
		'max'             => $atts['max_members'],
		'populate_extras' => true,
		'search_terms'    => false,
	);

	$args = array(
		'object_dir' => 'members',
		'item_id'    => $user_id = bp_get_member_user_id(),
		'type'       => 'cover-image',
	);
	$cover_img_url = bp_attachments_get_attachment( 'url', $args );
	if ( empty( $cover_img_url ) ) {
		$cover_img_url = isset( $wbtm_reign_settings['reign_buddyextender']['default_xprofile_cover_image_url'] ) ? $wbtm_reign_settings['reign_buddyextender']['default_xprofile_cover_image_url'] : REIGN_INC_DIR_URI . 'reign-settings/imgs/default-cover.jpg';
		if ( empty( $cover_img_url ) ) {
			$cover_img_url = REIGN_INC_DIR_URI . 'reign-settings/imgs/default-cover.jpg';
		}
	}

	ob_start();

	// Back up the global.
	$old_members_template = $members_template;
	?>
	<div id="rg-member-section" class="rg-members-section rg-home-section rg-slick-list-wrapper">
		<div id="members-carousel-list" class="rg-slick-list-container container">
	<?php if ( bp_has_members( $members_args ) ) : ?>
		<?php
		while ( bp_members() ) :
			bp_the_member();
			?>
			<?php $user_id = bp_get_member_user_id(); ?>
				<div class="rg-member rg-image-box">
					<div class="wbtm-mem-cover-img"><img src="<?php echo esc_url( $cover_img_url ); ?>" /></div>
					<div class="item-avatar">
						<a href="<?php bp_member_permalink(); ?>"><?php echo reign_get_online_status( $user_id ); ?><?php echo get_avatar( bp_get_member_user_id() ); ?></a>
					</div>
					<?php if ( 'show' === $atts['member_name'] ) : ?>
						<div class="rg-member-decription">
							<h3><a class="name fn rg-member-title" href="<?php bp_member_permalink(); ?>"><?php bp_member_name(); ?></a></h3>
						</div>
					<?php endif; ?>
				</div>

		<?php endwhile; ?>
			<?php else : ?>
				<div class="widget-error">
				<?php esc_html_e( 'No one has signed up yet!', 'buddypress' ); ?>
				</div>

			<?php endif; ?>
		</div>
	</div>

	<?php
	// Restore the global.
	$members_template = $old_members_template;
	return ob_get_clean();
}
add_shortcode( 'bp_memeber_carousel', 'reign_bp_memeber_carousel' );



/**
 * Shortcode for Buddypress Member Carousel
 *
 * @param array $atts shortcode attributes
 */
function reign_bp_group_carousel( $atts ) {
	global $groups_template, $wbtm_reign_settings;
	// Attributes
	$atts = shortcode_atts(
		array(
			'max_groups' => 10,
			'group_sort' => 'active',
		),
		$atts
	);

	if ( empty( $atts['group_sort'] ) ) {
		$atts['group_sort'] = 'popular';
	}

	/**
	 * Filters the user ID to use with the widget atts.
	 *
	 * @since 1.5.0
	 *
	 * @param string $value Empty user ID.
	 */
	$user_id = apply_filters( 'bp_group_carousel_user_id', '0' );

	$max_groups = ! empty( $atts['max_groups'] ) ? (int) $atts['max_groups'] : 10;

	// Setup args for querying groups.
	$group_args = array(
		'user_id'  => $user_id,
		'type'     => $atts['group_sort'],
		'per_page' => $max_groups,
		'max'      => $max_groups,
	);
	ob_start();
	// Back up the global.
	$old_groups_template = $groups_template;
	?>
			<div id="rg-group-carousel-section" class="rg-group-carousel-section rg-group">
				<?php if ( bp_has_groups( $group_args ) ) : ?>
						<ul id="groups-carousel-list" class="groups-carousel-container container" aria-live="assertive" aria-atomic="true" aria-relevant="all">

								<?php
								while ( bp_groups() ) :
										bp_the_group();
											$args = array(
												'object_dir' => 'groups',
												'item_id' => $group_id = bp_get_group_id(),
												'type'    => 'cover-image',
											);

											$cover_img_url = bp_attachments_get_attachment( 'url', $args );

											if ( empty( $cover_img_url ) ) {
												$cover_img_url = isset( $wbtm_reign_settings['reign_buddyextender']['default_group_cover_image_url'] ) ? $wbtm_reign_settings['reign_buddyextender']['default_group_cover_image_url'] : REIGN_INC_DIR_URI . 'reign-settings/imgs/default-cover.jpg';
												if ( empty( $cover_img_url ) ) {
													$cover_img_url = REIGN_INC_DIR_URI . 'reign-settings/imgs/default-cover.jpg';
												}
											}
											?>
										<li <?php bp_group_class(); ?> >
											<div class="bp-group-inner-wrap">
												<div class="wbtm-group-cover-img"><img src="<?php echo esc_url( $cover_img_url ); ?>" /></div>
												<?php if ( ! bp_disable_group_avatar_uploads() ) : ?>
													<?php if ( function_exists( 'buddypress' ) && version_compare( buddypress()->version, '12.0', '>=' ) ) : ?>
														<a class="item-avatar-group" href="<?php bp_group_url(); ?>"><?php bp_group_avatar( '' ); ?></a>
													<?php else : ?>
														<a class="item-avatar-group" href="<?php bp_group_permalink(); ?>"><?php bp_group_avatar( '' ); ?></a>
													<?php endif; ?>
													<?php endif; ?>
													<div class="group-content-wrap">
														<div class="item">
															<h3 class="item-title"><?php bp_group_link(); ?></h3>
															<?php
															/**
															 * Fires inside the listing of an individual group listing item.
															 *
															 * @since 1.1.0
															 */
															do_action( 'bp_directory_groups_item' );
															?>
														</div>
													</div>
												</div>
										</li>
								<?php endwhile; ?>
						</ul>
				<?php else : ?>
						<div class="widget-error">
								<?php esc_html_e( 'There are no groups to display.', 'buddypress' ); ?>
						</div>
				<?php endif; ?>
			</div>
	<?php
	// Restore the global.
	$groups_template = $old_groups_template;

	return ob_get_clean();
}
add_shortcode( 'bp_group_carousel', 'reign_bp_group_carousel' );

if ( class_exists( 'bbPress' ) ) {
	/**
	 * Setup the post types for forums
	 *
	 * @since bbPress (r2597)
	 * @uses register_post_type() To register the post types
	 * @uses apply_filters() Calls various filters to modify the arguments
	 *                        sent to register_post_type()
	 */
	if ( ! function_exists( 'register_post_types' ) ) {
		function register_post_types() {
			/** Forums */
			// Register Forum content type
			register_post_type(
				bbp_get_forum_post_type(),
				apply_filters(
					'bbp_register_forum_post_type',
					array(
						'labels'              => bbp_get_forum_post_type_labels(),
						'rewrite'             => bbp_get_forum_post_type_rewrite(),
						'supports'            => bbp_get_forum_post_type_supports(),
						'description'         => __( 'Forums', 'reign' ),
						'capabilities'        => bbp_get_forum_caps(),
						'capability_type'     => array( 'forum', 'forums' ),
						'menu_position'       => 555555,
						'has_archive'         => bbp_get_root_slug(),
						'exclude_from_search' => true,
						'show_in_nav_menus'   => true,
						'public'              => true,
						'show_ui'             => current_user_can( 'bbp_forums_admin' ),
						'can_export'          => true,
						'hierarchical'        => true,
						'query_var'           => true,
						'menu_icon'           => '',
						'show_in_menu'        => false,
						'source'              => 'bbpress',
					)
				)
			);
		}

		add_post_type_support( bbp_get_forum_post_type(), 'thumbnail' );
	}

	/**
	 * Get the forum thumbnail's image tag
	 *
	 * @since reign 7.2.1
	 */
	if ( ! function_exists( 'bbp_get_forum_thumbnail_image' ) ) {
		function bbp_get_forum_thumbnail_image( $forum_id = null, $size = null, $type = null ) {
			$thumbnail_id = get_post_thumbnail_id( $forum_id );
			if ( $thumbnail_id ) {
				return wp_get_attachment_image( $thumbnail_id, $size );
			}

			$group_ids = bbp_get_forum_group_ids( $forum_id );
			if ( $group_ids ) {
				$group_id = $group_ids[0];

				if ( bp_is_active( 'groups' ) && ! bp_disable_group_cover_image_uploads() && bp_attachments_get_group_has_cover_image( $group_id ) ) {
					$group_cover_image = bp_attachments_get_attachment(
						'url',
						array(
							'object_dir' => 'groups',
							'item_id'    => $group_id,
						)
					);

					if ( ! empty( $group_cover_image ) ) {
						return '<img src="' . esc_url( $group_cover_image ) . '" alt="' . esc_attr( bbp_get_forum_title( $forum_id ) ) . '" />';
					}
				}

				if ( bp_is_active( 'groups' ) && ! bp_disable_group_avatar_uploads() && bp_get_group_has_avatar( $group_id ) ) {
					return bp_core_fetch_avatar(
						array(
							'item_id'       => $group_id,
							'object'        => 'group',
							'type'          => $type,
							'force_default' => false,
						)
					);
				}
			}

			return '';
		}
	}
}

/**
 * Add the Divi page builder class.
 */
function reign_divi_body_class( $classes ) {
	if ( et_pb_is_pagebuilder_used( get_the_ID() ) && ! ET_GB_Block_Layout::is_layout_block_preview() ) {
		$classes[] = 'et_pb_pagebuilder_layout';
	}
	return $classes;
}

if ( class_exists( 'ET_Builder_Plugin' ) ) {
	add_action( 'body_class', 'reign_divi_body_class', 10, 1 );
}
