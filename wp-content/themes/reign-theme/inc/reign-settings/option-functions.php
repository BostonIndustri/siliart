<?php

/**
 * Managing number of groups to show per page.
 *
 * @since 1.0.2
 */
add_filter( 'bp_after_has_groups_parse_args', 'reign_theme_alter_groups_parse_args' );

function reign_theme_alter_groups_parse_args( $loop ) {
	if ( bp_is_groups_directory() ) {
		global $wbtm_reign_settings;
		if ( isset( $wbtm_reign_settings['reign_buddyextender']['groups_per_page'] ) && ! empty( $wbtm_reign_settings['reign_buddyextender']['groups_per_page'] ) ) {
			$loop['per_page'] = intval( $wbtm_reign_settings['reign_buddyextender']['groups_per_page'] );
		}
	}
	return $loop;
}

/**
 * Managing number of members to show per page
 *
 * @since 1.0.2
 */
add_filter( 'bp_after_has_members_parse_args', 'reign_theme_alter_members_parse_args' );

function reign_theme_alter_members_parse_args( $loop ) {
	if ( bp_is_members_directory() ) {
		global $wbtm_reign_settings;
		if ( isset( $wbtm_reign_settings['reign_buddyextender']['members_per_page'] ) && ! empty( $wbtm_reign_settings['reign_buddyextender']['members_per_page'] ) ) {
			$loop['per_page'] = intval( $wbtm_reign_settings['reign_buddyextender']['members_per_page'] );
		}
	}
	return $loop;
}

/*
 * All the functions related to reign theme settings
 */

add_filter(
	'body_class',
	function ( $classes ) {
		if ( is_search() ) {
			return $classes;
		}
		global $wbtm_reign_settings;

		/* top bar support */
		global $wp_query;
		if ( isset( $wp_query ) && (bool) $wp_query->is_posts_page ) {
			$post_id = get_option( 'page_for_posts' );
			$post    = get_post( $post_id );
		} else {
			global $post;
		}

		if ( $post ) {
			$reign_ele_topbar = get_post_meta( $post->ID, 'reign_ele_topbar', true );
			if ( ! empty( $reign_ele_topbar ) && ( $reign_ele_topbar != '-1' ) ) {
				$topbar_id = $reign_ele_topbar;
			} else {
				global $wbtm_reign_settings;
				$topbar_id = isset( $wbtm_reign_settings['reign_pages']['global_ele_topbar'] ) ? $wbtm_reign_settings['reign_pages']['global_ele_topbar'] : '0';
			}

			if ( ! empty( $topbar_id ) && ( $topbar_id != '-1' ) ) {
				$classes = array_merge( $classes, array( 'rg-header-top-bar' ) );
			}

			$reign_header_topbar_type = get_theme_mod( 'reign_header_topbar_type', '' );
			if ( $reign_header_topbar_type == '1' ) {
				$classes = array_merge( $classes, array( 'rg-header-top-bar' ) );
			}
		}

		/* reign elementor header mobile */
		$reign_elementor_header_mobile = get_theme_mod( 'reign_elementor_header_mobile', '' );
		if ( $reign_elementor_header_mobile == '1' ) {
			$classes = array_merge( $classes, array( 'rg-ele-header-show' ) );
		}

		/* sticky header support */
		$header_design_type = isset( $wbtm_reign_settings['reign_pages']['header_design_type'] ) ? $wbtm_reign_settings['reign_pages']['header_design_type'] : 'full_width';
		if ( $header_design_type == 'sticky' ) {
			$classes = array_merge( $classes, array( 'rg-sticky-menu' ) );
		}

		/*
		boxed and fluid layout support */
		// $active_site_layout   = isset( $wbtm_reign_settings[ 'reign_pages' ][ 'active_site_layout' ] ) ? $wbtm_reign_settings[ 'reign_pages' ][ 'active_site_layout' ] : 'full_width';
		$active_site_layout = get_theme_mod( 'reign_site_layout', 'full_width' );
		if ( $active_site_layout == 'box_width' ) {
			$classes = array_merge( $classes, array( 'rg-boxed-layout' ) );
		}

		/* fallback header support */
		if ( defined( 'WBCOM_ELEMENTOR_ADDONS_VERSION' ) ) {
			$classes[] = 'reign-manage-fallback-header';
		}

		/* content layout support added */
		if ( $post ) {
			$theme_slug         = apply_filters( 'wbcom_essential_theme_slug', 'reign' );
			$wbcom_metabox_data = get_post_meta( $post->ID, $theme_slug . '_wbcom_metabox_data', true );
			$site_layout        = isset( $wbcom_metabox_data['layout']['site_layout'] ) ? $wbcom_metabox_data['layout']['site_layout'] : '';
			if ( $site_layout ) {
				$classes[] = 'reign-' . $site_layout;
			}
		}

		/* top cover image support */

		if ( class_exists( 'BuddyPress' ) && ( bp_is_group() || bp_is_user() ) ) {
			$member_header_position = isset( $wbtm_reign_settings['reign_buddyextender']['member_header_position'] ) ? $wbtm_reign_settings['reign_buddyextender']['member_header_position'] : 'inside';
			$member_header_position = apply_filters( 'wbtm_rth_manage_member_header_position', $member_header_position );
			$classes[]              = 'reign-cover-image-' . $member_header_position;
		}

		/**
		 * Manage Main Menu Hover Style.
		 */
		$reign_header_main_menu_hover_style = get_theme_mod( 'reign_header_main_menu_hover_style', false );
		if ( $reign_header_main_menu_hover_style === 'style1' ) {
			$classes[] = 'menu-hover-style1';
		}
		if ( $reign_header_main_menu_hover_style === 'style2' ) {
			$classes[] = 'menu-hover-style2';
		}
		if ( $reign_header_main_menu_hover_style === 'style3' ) {
			$classes[] = 'menu-hover-style3';
		}
		if ( $reign_header_main_menu_hover_style === 'style4' ) {
			$classes[] = 'menu-hover-style4';
		}
		if ( $reign_header_main_menu_hover_style === 'style5' ) {
			$classes[] = 'menu-hover-style5';
		}
		if ( $reign_header_main_menu_hover_style === 'style6' ) {
			$classes[] = 'menu-hover-style6';
		}

		/**
		 * Manage Single Post Layout.
		 */
		if ( is_single() && 'post' == get_post_type() ) {
			$reign_single_post_layout = get_theme_mod( 'reign_single_post_layout', 'default' );
			if ( $reign_single_post_layout === 'default' ) {
					$classes[] = 'single-post-default-layout';
			}
			if ( $reign_single_post_layout === 'wide' ) {
					$classes[] = 'single-post-wide-layout';
			}
			if ( $reign_single_post_layout === 'wide_sidebar' ) {
					$classes[] = 'single-post-wide-sidebar-layout';
			}
		}

		/**
		 * Manage body class when no sidebar.
		 *
		 * @since 2.0.2
		 */
		$reign_post_archive_layout = get_theme_mod( 'reign_post_archive_layout', '' );
		if ( 'full_width' === $reign_post_archive_layout ) {
			$classes[] = 'reign-no-sidebar-active';
		}

		/**
		 * Mobile view hide topbar support.
		 */
		$reign_header_topbar_mobile_view_disable = get_theme_mod( 'reign_header_topbar_mobile_view_disable', false );
		if ( $reign_header_topbar_mobile_view_disable ) {
			$classes[] = 'reign-topbar-hide-mobile';
		}

		$reign_header_topbar_enable = get_theme_mod( 'reign_header_topbar_enable', '1' );
		$reign_header_topbar_sticky = get_theme_mod( 'reign_header_topbar_sticky', false );
		if ( $reign_header_topbar_enable && $reign_header_topbar_sticky ) {
			$classes[] = 'reign-sticky-topbar';
		}

		$reign_header_sticky_menu_enable              = get_theme_mod( 'reign_header_sticky_menu_enable', true );
		$reign_header_sticky_menu_custom_style_enable = get_theme_mod( 'reign_header_sticky_menu_custom_style_enable', false );
		$sticky_menu_logo                             = get_theme_mod( 'reign_sticky_header_menu_logo', '' );
		if ( $reign_header_sticky_menu_enable && $reign_header_sticky_menu_custom_style_enable && $sticky_menu_logo ) {
			$classes[] = 'reign-custom-sticky-logo';
		}

		// BuddyPress round avatar body class.
		if ( class_exists( 'BuddyPress' ) ) {
			$reign_buddypress_avatar_style = get_theme_mod( 'reign_buddypress_avatar_style', false );

			if ( true === $reign_buddypress_avatar_style ) {
				$classes[] = 'round-avatars';
			}
		}

		// Left panel shift body.
		$reign_left_panel_shift_body = get_theme_mod( 'reign_left_panel_shift_body', false );
		if ( true === $reign_left_panel_shift_body ) {
			$classes[] = 'rg-shift-body';
		}

		return $classes;
	}
);

/* enqueue custom code to head */
add_action(
	'wp_head',
	function () {
		if ( function_exists( 'amp_is_request' ) && amp_is_request() || ( function_exists( 'amp_is_legacy' ) && amp_is_legacy() ) ) {
			return;
		}

		// global $wbtm_reign_settings;
		// $reign_tracking_code = isset( $wbtm_reign_settings[ 'reign_pages' ][ 'reign_tracking_code' ] ) ? $wbtm_reign_settings[ 'reign_pages' ][ 'reign_tracking_code' ] : '';
		// $reign_tracking_code = stripslashes( $reign_tracking_code );
		// echo $reign_tracking_code;

		$reign_tracking_code = get_theme_mod( 'reign_tracking_code', '' );
		echo $reign_tracking_code;

		$reign_custom_js_header = get_theme_mod( 'reign_custom_js_header', '' );
		echo '<script type="text/javascript">' . $reign_custom_js_header . '</script>';
	},
	99
);

add_action(
	'wp_footer',
	function () {
		if ( function_exists( 'amp_is_request' ) && amp_is_request() || ( function_exists( 'amp_is_legacy' ) && amp_is_legacy() ) ) {
			return;
		}
		$reign_custom_js_footer = get_theme_mod( 'reign_custom_js_footer', '' );
		echo '<script type="text/javascript">' . $reign_custom_js_footer . '</script>';
	},
	99
);

/**
 * Add 404 page redirect
 */
if ( ! function_exists( 'reign_404_redirect' ) ) {
	add_action( 'template_redirect', 'reign_404_redirect' );

	/**
	 * Redirects users to a custom 404 page.
	 *
	 * This function is hooked to the 'template_redirect' action. It checks if the current request
	 * is a 404 error page. If a custom 404 page is set in the theme customizer, the user is redirected
	 * to that page.
	 *
	 * @return void
	 */
	function reign_404_redirect() {
		if ( is_404() ) {
			$reign_404_page_id = get_theme_mod( 'reign_404_page', 0 );

			if ( $reign_404_page_id && $reign_404_page_id != '-1' && get_post_status( $reign_404_page_id ) ) {
				wp_safe_redirect( get_permalink( $reign_404_page_id ) );
				exit;
			}
		}
	}
}

/**
 * Runs BP configuration filters on bp_include
 *
 * @return void
 */
function reign_run_bp_included_settings() {

	global $wbtm_reign_settings;

	if ( ! $wbtm_reign_settings ) {
		return;
	}

	$options = isset( $wbtm_reign_settings['reign_buddyextender'] ) ? $wbtm_reign_settings['reign_buddyextender'] : array();

	if ( empty( $options ) || ! is_array( $options ) ) {
		return;
	}
}

add_action( 'init', 'reign_run_bp_included_settings' );

add_action( 'admin_enqueue_scripts', 'reign_options_enqueue_scripts' );

/**
 * Enqueues scripts and styles for the admin options pages.
 *
 * This function ensures that necessary scripts and styles are loaded on specific admin pages,
 * such as the Reign theme options page and post edit/create pages. It includes the WordPress
 * media uploader, jQuery UI tabs, and a custom admin JavaScript file, with proper versioning
 * and footer placement for the custom script.
 *
 * @return void
 */
function reign_options_enqueue_scripts() {
	global $pagenow;

	// Retrieve the 'page' query parameter and sanitize it.
	$page = isset( $_GET['page'] ) ? sanitize_text_field( $_GET['page'] ) : '';

	// Check if the request is for an admin page related to Reign options or post edit/create.
	if ( is_admin() && ( ( $page && 'reign-options' === $page ) || 'post.php' === $pagenow || 'post-new.php' === $pagenow ) ) {
		// Enqueue WordPress media uploader scripts.
		wp_enqueue_media();

		// Enqueue jQuery UI tabs script.
		wp_enqueue_script( 'jquery-ui-tabs' );

		// Register and enqueue custom admin JavaScript file.
		wp_register_script( 'reign-admin-js', get_template_directory_uri() . '/assets/js/admin.js', array( 'jquery' ), REIGN_THEME_VERSION, true );
		wp_enqueue_script( 'reign-admin-js' );
	}
}

/**
 * Function To Change The Default Group Cover Image
 */
add_filter( 'bp_before_groups_cover_image_settings_parse_args', 'reign_bp_before_groups_cover_image_settings_parse_args', 10, 1 );

function reign_bp_before_groups_cover_image_settings_parse_args( $settings ) {
	global $wbtm_reign_settings;
	$default_group_cover_image_url = isset( $wbtm_reign_settings['reign_buddyextender']['default_group_cover_image_url'] ) ? $wbtm_reign_settings['reign_buddyextender']['default_group_cover_image_url'] : REIGN_INC_DIR_URI . 'reign-settings/imgs/default-cover.jpg';
	if ( empty( $default_group_cover_image_url ) ) {
		$default_group_cover_image_url = REIGN_INC_DIR_URI . 'reign-settings/imgs/default-cover.jpg';
	}
	if ( ! empty( $default_group_cover_image_url ) ) {
		$settings['default_cover'] = $default_group_cover_image_url;
	}
	return $settings;
}

/**
 * Function To Change The Default xProfile Cover Image
 */
if ( ! has_filter( 'the_content', 'example_alter_the_content' ) ) {
	add_filter( 'bp_before_members_cover_image_settings_parse_args', 'reign_bp_before_xprofile_cover_image_settings_parse_args', 10, 1 );
} else {
	add_filter( 'bp_before_members_cover_image_settings_parse_args', 'reign_bp_before_xprofile_cover_image_settings_parse_args', 10, 1 );
}

if ( function_exists( 'buddypress' ) && isset( buddypress()->buddyboss ) ) {
	add_filter( 'bp_before_xprofile_cover_image_settings_parse_args', 'reign_bp_before_xprofile_cover_image_settings_parse_args', 10, 1 );
}

/**
 * Modify the default cover image settings for xProfile.
 *
 * @param array $settings The current xProfile cover image settings.
 * @return array Modified xProfile cover image settings with the updated default cover image URL.
 */
function reign_bp_before_xprofile_cover_image_settings_parse_args( $settings ) {

	global $wbtm_reign_settings;
	$default_xprofile_cover_image_url = isset( $wbtm_reign_settings['reign_buddyextender']['default_xprofile_cover_image_url'] ) ? $wbtm_reign_settings['reign_buddyextender']['default_xprofile_cover_image_url'] : REIGN_INC_DIR_URI . 'reign-settings/imgs/default-cover.jpg';
	if ( empty( $default_xprofile_cover_image_url ) ) {
		$default_xprofile_cover_image_url = REIGN_INC_DIR_URI . 'reign-settings/imgs/default-cover.jpg';
	}
	if ( ! empty( $default_xprofile_cover_image_url ) ) {
		$settings['default_cover'] = esc_url( $default_xprofile_cover_image_url );
	}

	return $settings;
}

/**
 * @since 1.0.4
 * changing default image for user :: buddypress
 */
add_filter( 'bp_core_fetch_avatar_no_grav', 'reign_alter_bp_core_fetch_avatar_no_grav', 10, 2 );

function reign_alter_bp_core_fetch_avatar_no_grav( $no_grav, $params ) {
	if ( apply_filters( 'reign_show_wordpress_default_avatar', false ) ) {
		return $no_grav;
	}

	if ( ! is_admin() || wp_doing_ajax() ) {
		$userdata = get_userdata( $params['item_id'] );
		if ( ! $userdata ) {
			return $no_grav;
		}
		$email = $userdata->user_email;
		if ( $params['object'] == 'user' ) {
			$has_validate_gravatar = false;
			if ( $has_validate_gravatar ) {
				return $no_grav;
			}
			global $wbtm_reign_settings;
			$avatar_default_image = isset( $wbtm_reign_settings['reign_buddyextender']['avatar_default_image'] ) ? $wbtm_reign_settings['reign_buddyextender']['avatar_default_image'] : REIGN_INC_DIR_URI . 'reign-settings/imgs/default-mem-avatar.png';
			if ( empty( $avatar_default_image ) ) {
				$avatar_default_image = REIGN_INC_DIR_URI . 'reign-settings/imgs/default-mem-avatar.png';
			}
			if ( ! empty( $avatar_default_image ) ) {
				$no_grav = true;
			}
		}
	}
	return $no_grav;
}

add_filter( 'bp_core_default_avatar_user', 'reign_alter_bp_core_default_avatar_user', 10, 2 );

/**
 * Alters the default avatar for BuddyPress users.
 *
 * @param string $avatar_default The current default avatar URL.
 * @param array  $params         Array of parameters related to the avatar, including the object type (e.g., 'user').
 *
 * @return string The modified avatar URL, or the original if no custom avatar is set.
 */
function reign_alter_bp_core_default_avatar_user( $avatar_default, $params ) {
	if ( apply_filters( 'reign_show_wordpress_default_avatar', false ) ) {
		return $avatar_default;
	}

	if ( ! is_admin() || wp_doing_ajax() ) {

		$object = isset( $params['object'] ) ? sanitize_text_field( $params['object'] ) : '';

		if ( 'user' === $object ) {
			global $wbtm_reign_settings;
			$avatar_default_image = isset( $wbtm_reign_settings['reign_buddyextender']['avatar_default_image'] ) ? $wbtm_reign_settings['reign_buddyextender']['avatar_default_image'] : REIGN_INC_DIR_URI . 'reign-settings/imgs/default-mem-avatar.png';

			if ( empty( $avatar_default_image ) ) {
				$avatar_default_image = REIGN_INC_DIR_URI . 'reign-settings/imgs/default-mem-avatar.png';
			}

			// Buddypress Private Community Pro return default avatar.
			if ( class_exists( 'Buddypress_Lock_Pro_Public' ) ) {
				$blpro_profile_progress = get_option( 'blpro_profile_progress' );
				if ( ! empty( $blpro_profile_progress ) && isset( $blpro_profile_progress['req_profile_photo'] ) && 'yes' === $blpro_profile_progress['req_profile_photo'] ) {
					return $avatar_default;
				}
			}

			if ( ! empty( $avatar_default_image ) ) {
				$avatar_default = $avatar_default_image;
			}
		}
	}
	return $avatar_default;
}

/**
 * @since 1.0.4
 * changing default image for group :: buddypress
 */

if ( function_exists( 'buddypress' ) && version_compare( buddypress()->version, '8.0.0', '>=' ) ) {
	add_filter( 'bp_core_default_avatar', 'reign_alter_bp_core_avatar_default', 10, 2 );
	add_filter( 'bp_core_fetch_avatar_no_grav', 'reign_bp_core_fetch_avatar_no_grav', 10, 2 );
} else {
	add_filter( 'bp_core_avatar_default', 'reign_alter_bp_core_avatar_default', 10, 2 );
}

add_filter( 'bb_attachments_get_default_profile_group_avatar_image', 'reign_alter_bp_core_avatar_default', 10, 2 );

function reign_alter_bp_core_avatar_default( $default_grav, $params ) {
	global $wbtm_reign_settings;

	if ( ! $params ) {
		return $default_grav;
	}

	if ( ! isset( $params['object'] ) ) {
		return $default_grav;
	}

	if ( $params['object'] == 'group' ) {
		$group_default_image = isset( $wbtm_reign_settings['reign_buddyextender']['group_default_image'] ) ? $wbtm_reign_settings['reign_buddyextender']['group_default_image'] : REIGN_INC_DIR_URI . 'reign-settings/imgs/default-grp-avatar.png';
		if ( empty( $group_default_image ) ) {
			$group_default_image = REIGN_INC_DIR_URI . 'reign-settings/imgs/default-grp-avatar.png';
		}
		if ( ! empty( $group_default_image ) ) {
			$default_grav = $group_default_image;
		}
	}
	return $default_grav;
}

function reign_bp_core_fetch_avatar_no_grav( $no_grav, $params ) {
	if ( apply_filters( 'reign_show_wordpress_default_avatar', false ) ) {
		return $no_grav;
	}

	if ( ! is_admin() || wp_doing_ajax() ) {
		return true;
	}
	return $no_grav;
}

add_filter( 'bb_attachments_get_default_profile_group_cover_image', 'reign_bb_get_default_profile_group_cover', 10 );
function reign_bb_get_default_profile_group_cover( $cover_image_url ) {
	return '';
}
