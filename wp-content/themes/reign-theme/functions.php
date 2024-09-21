<?php

class REIGN_Theme_Class {

	/**
	 * Main Theme Class Constructor
	 *
	 * @since   1.0.0
	 */
	public function __construct() {
		// Define constants
		add_action( 'after_setup_theme', array( 'REIGN_Theme_Class', 'constants' ), 0 );

		// Load all core theme function files
		add_action( 'after_setup_theme', array( 'REIGN_Theme_Class', 'include_functions' ), 1 );

		/**
		 * Manage bp-nouveau support.
		 */
		add_filter( 'bp_get_template_stack', array( 'REIGN_Theme_Class', 'reign_bp_get_template_stack' ), 10, 1 );
		add_filter( 'rtmedia_media_template_include', array( 'REIGN_Theme_Class', 'nouveau_rtmedia_media_template_include' ), 10, 1 );
		add_filter( 'bp_nouveau_get_loop_classes', array( 'REIGN_Theme_Class', 'reign_bp_nouveau_get_loop_classes' ), 10, 2 );
		add_filter( 'bp_nouveau_get_loop_classes', array( 'REIGN_Theme_Class', 'bpgt_filter_nouveau_get_loop_classes' ), 10, 2 );

		/* Manage bp followers following member page layout */
		add_filter( 'bp_nouveau_get_loop_classes', array( 'REIGN_Theme_Class', 'reign_bp_nouveau_follow_get_loop_classes' ), 10, 2 );

		add_filter( 'bp_nouveau_avatar_args', array( 'REIGN_Theme_Class', 'reign_bp_nouveau_avatar_args_member_layout_1' ), 10, 1 );
		add_action( 'wp_enqueue_scripts', array( 'REIGN_Theme_Class', 'bp_nouveau_enqueue_script' ) );
		// SVG Support.
		add_filter( 'mime_types', array( $this, 'reign_theme_upload_mimes' ) );
	}

	public static function bp_nouveau_enqueue_script() {
		if ( function_exists( 'amp_is_request' ) && amp_is_request() || ( function_exists( 'amp_is_legacy' ) && amp_is_legacy() ) ) {
			return;
		}

		if ( function_exists( 'buddypress' ) && ! isset( buddypress()->buddyboss ) && ! is_user_logged_in() ) {
			do_action( 'bp_enqueue_community_scripts' );
			wp_enqueue_script( 'user-profile' );
			wp_enqueue_style( 'dashicons' );
		}

		if ( function_exists( 'buddypress' ) && ! is_user_logged_in() ) {
			wp_enqueue_script( 'bp-nouveau-xprofile' );
			wp_enqueue_script( 'bp-nouveau-magnific-popup' );
		}

		if ( function_exists( 'bp_get_theme_package_id' ) ) {
			$theme_package_id = bp_get_theme_package_id();
		} else {
			$theme_package_id = 'legacy';
		}
		if ( 'nouveau' === $theme_package_id ) {
			wp_register_script(
				'reign-nouveau-js',
				get_template_directory_uri() . '/assets/js/reign-nouveau.js',
				array( 'jquery' ),
				REIGN_THEME_VERSION,
				true
			);
			wp_enqueue_script( 'reign-nouveau-js' );
		}

		wp_enqueue_script( 'reign-infinity-scroll-js', get_template_directory_uri() . '/assets/js/infinite-scroll.pkgd.min.js', array( 'jquery' ), REIGN_THEME_VERSION, true );
		wp_enqueue_script( 'reign-custom-nouveau-js', get_template_directory_uri() . '/assets/js/custom.js', array( 'jquery' ), REIGN_THEME_VERSION, true );
	}

	public static function reign_bp_nouveau_avatar_args_member_layout_1( $args ) {
		if ( bp_is_groups_directory() ) {
			$bp_nouveau_appearance = bp_get_option( 'bp_nouveau_appearance', array() );
			if ( ! isset( $bp_nouveau_appearance['groups_layout'] ) ) {
				$bp_nouveau_appearance['groups_layout'] = 1;
			}
			if ( 1 !== $bp_nouveau_appearance['groups_layout'] ) {
				global $wbtm_reign_settings;
				$group_directory_type = isset( $wbtm_reign_settings['reign_buddyextender']['group_directory_type'] ) ? $wbtm_reign_settings['reign_buddyextender']['group_directory_type'] : 'wbtm-group-directory-type-2';
				if ( 'wbtm-group-directory-type-1' === $group_directory_type ) {
					$args['width']  = 300;
					$args['height'] = 300;
				}
			}
		}
		return $args;
	}

	public static function reign_bp_nouveau_get_loop_classes( $classes, $component ) {
		if ( bp_is_user() && 'requests' === bp_current_action() ) {
			$index = array_search( 'friends-list', $classes );
			if ( false !== $index ) {
				unset( $classes[ $index ] );
			}
			$index = array_search( 'friends-request-list', $classes );
			if ( false !== $index ) {
				unset( $classes[ $index ] );
			}

			$customizer_option = sprintf( '%s_layout', 'members_friends' );
			$layout_prefs      = bp_nouveau_get_temporary_setting(
				$customizer_option,
				bp_nouveau_get_appearance_settings( $customizer_option )
			);
			if ( $layout_prefs && (int) $layout_prefs > 1 && function_exists( 'bp_nouveau_customizer_grid_choices' ) ) {
				$grid_classes = bp_nouveau_customizer_grid_choices( 'classes' );

				if ( isset( $grid_classes[ $layout_prefs ] ) ) {
					$classes = array_merge(
						$classes,
						array(
							'grid',
							$grid_classes[ $layout_prefs ],
						)
					);
				}
			}

			$classes = array_merge(
				$classes,
				array(
					'members-list',
					'rg-nouveau-friends-request-list',
				)
			);
		}

		return $classes;
	}

	public static function reign_bp_nouveau_follow_get_loop_classes( $classes, $component ) {

		global $bp;
		if ( class_exists( 'BP_Follow_Component' ) ) {
			if ( bp_is_current_component( $bp->follow->followers->slug ) || bp_is_current_component( $bp->follow->following->slug ) ) {

				$layout_prefs = bp_nouveau_get_temporary_setting(
					'members_layout',
					bp_nouveau_get_appearance_settings( 'members_layout' )
				);
				if ( $layout_prefs && (int) $layout_prefs > 1 && function_exists( 'bp_nouveau_customizer_grid_choices' ) ) {
					$grid_classes = bp_nouveau_customizer_grid_choices( 'classes' );

					if ( isset( $grid_classes[ $layout_prefs ] ) ) {
						$classes = array_merge(
							$classes,
							array(
								'grid',
								$grid_classes[ $layout_prefs ],
							)
						);
					}
				}

				$classes = array_merge(
					$classes,
					array(
						'members-list',
						'rg-nouveau-friends-request-list',
					)
				);
			}
		}
		return $classes;
	}

	public static function bpgt_filter_nouveau_get_loop_classes( $classes, $component ) {
		if ( 'groups' === $component ) {
			$layout_prefs = bp_nouveau_get_temporary_setting(
				'groups_layout',
				bp_nouveau_get_appearance_settings( 'groups_layout' )
			);
			if ( $layout_prefs && (int) $layout_prefs > 1 && function_exists( 'bp_nouveau_customizer_grid_choices' ) ) {
				$grid_classes = bp_nouveau_customizer_grid_choices( 'classes' );

				if ( isset( $grid_classes[ $layout_prefs ] ) ) {
					$classes = array_merge(
						$classes,
						array(
							'grid',
							$grid_classes[ $layout_prefs ],
						)
					);
				}
			}
		}

		return $classes;
	}

	public static function reign_bp_get_template_stack( $stack ) {
		if ( function_exists( 'bp_get_theme_package_id' ) ) {
			$theme_package_id = bp_get_theme_package_id();
		} else {
			$theme_package_id = 'legacy';
		}
		if ( 'nouveau' === $theme_package_id ) {
			if ( function_exists( 'buddypress' ) && isset( buddypress()->buddyboss ) ) {
				$index = array_search( get_stylesheet_directory() . '/buddypress', $stack );
				if ( false !== $index ) {
					$stack[ $index ] = get_stylesheet_directory() . '/bb-buddypress';
				}
				$index = array_search( get_template_directory() . '/buddypress', $stack );
				if ( false !== $index ) {
					$stack[ $index ] = get_template_directory() . '/bb-buddypress';
				}
			} else {
				$index = array_search( get_stylesheet_directory() . '/buddypress', $stack );
				if ( false !== $index ) {
					$stack[ $index ] = get_stylesheet_directory() . '/bp-nouveau';
				}
				$index = array_search( get_template_directory() . '/buddypress', $stack );
				if ( false !== $index ) {
					$stack[ $index ] = get_template_directory() . '/bp-nouveau';
				}
			}
		}
		return $stack;
	}

	public static function nouveau_rtmedia_media_template_include( $template ) {
		if ( function_exists( 'bp_get_theme_package_id' ) ) {
			$theme_package_id = bp_get_theme_package_id();
		} else {
			$theme_package_id = 'legacy';
		}
		if ( 'nouveau' === $theme_package_id ) {
			$template = str_replace( '/rtmedia/main.php', '/rtmedia/main-nouveau.php', $template );
		}
		return $template;
	}

	/**
	 * Define Constants
	 *
	 * @since   1.0.0
	 */
	public static function constants() {

		$theme = wp_get_theme( get_template() );
		// Return theme version
		$version = $theme->get( 'Version' );

		// Core Constants
		define( 'REIGN_THEME_DIR', get_template_directory() );
		define( 'REIGN_THEME_URI', get_template_directory_uri() );

		if ( function_exists( 'bp_get_theme_package_id' ) ) {
			$theme_package_id = bp_get_theme_package_id();
		} else {
			$theme_package_id = 'legacy';
		}
		if ( 'legacy' === $theme_package_id ) {
			define( 'BP_AVATAR_THUMB_WIDTH', 150 );
			define( 'BP_AVATAR_THUMB_HEIGHT', 150 );
			define( 'BP_AVATAR_FULL_WIDTH', 300 );
			define( 'BP_AVATAR_FULL_HEIGHT', 300 );
		}

		// Define the theme version constant.
		if ( ! defined( 'REIGN_THEME_VERSION' ) ) {
			define( 'REIGN_THEME_VERSION', $version );
		}

		// Javascript and CSS Paths
		define( 'REIGN_JS_DIR_URI', REIGN_THEME_URI . '/assets/js/' );
		define( 'REIGN_CSS_DIR_URI', REIGN_THEME_URI . '/assets/css/' );

		// Include Paths
		define( 'REIGN_INC_DIR', REIGN_THEME_DIR . '/inc/' );
		define( 'REIGN_INC_DIR_URI', REIGN_THEME_URI . '/inc/' );

		// Check if plugins are active
		define( 'REIGN_ELEMENTOR_ACTIVE', class_exists( 'Elementor\Plugin' ) );
		define( 'REIGN_BEAVER_BUILDER_ACTIVE', class_exists( 'FLBuilder' ) );
		define( 'REIGN_WOOCOMMERCE_ACTIVE', class_exists( 'WooCommerce' ) );

		$optionKey = 'reign_theme_is_activated';
		if ( ! get_option( $optionKey ) ) {

			$bp_nouveau_appearance = array(
				'members_layout'         => 3,
				'members_friends_layout' => 2,
				'groups_layout'          => 3,
				'members_group_layout'   => 2,
				'group_front_page'       => 0,
				'group_front_boxes'      => 0,
				'user_front_page'        => 0,
				'user_nav_display'       => 1,
				'group_nav_display'      => 1,
			);
			update_option( 'bp_nouveau_appearance', $bp_nouveau_appearance );
			update_option( $optionKey, 1 );
		}
	}

	/**
	 * Load all core theme function files
	 *
	 * @since 1.0.0
	 */
	public static function include_functions() {

		include_once 'inc/reign-deprecated-hooks.php';

		include_once 'inc/theme-functions.php';

		include_once 'inc/class-reign-theme-structure.php';

		/**
		 * Include the main plugin file of Kirki.
		 */
		include_once 'lib/kirki/kirki.php';

		if ( ! defined( 'KIRKI_PRO_VERSION' ) ) {
			require_once 'lib/kirki/pro-src/pro-index.php';
			new \Kirki\Pro\Init();
		}

		/**
		 * Include the main plugin file of Kirki.
		 */
		include_once 'lib/kirki-addon/kirki-addon.php';

		/**
		 * Include the custom-styles file of Kirki.
		 */
		include_once 'inc/custom-styles.php';

		/**
		 * Load reign theme blocks.
		 *
		 * @since 7.4.5
		 */
		include_once 'blocks/blocks.php';

		/* Theme Core Setup */
		require_once REIGN_INC_DIR . 'init.php';

		/* Theme Added Functionality Setup */
		require_once REIGN_INC_DIR . 'extras.php';

		/* Support Added For Extra Plugins */
		require_once REIGN_INC_DIR . 'extra-plugins-support.php';

		/* Load required plugins library */
		require_once REIGN_INC_DIR . '/reign-menu-icons/menu-icons.php';
		require_once REIGN_INC_DIR . 'reign-settings/class-left-menu-section.php';

		/* Custom Widgets */
		require REIGN_THEME_DIR . '/widgets/members-carousel-widget.php';
		require REIGN_THEME_DIR . '/widgets/sidewide-activity-widget.php';
		require REIGN_THEME_DIR . '/widgets/groups-widget.php';
		require REIGN_THEME_DIR . '/widgets/groups-carousel-widget.php';
		require REIGN_THEME_DIR . '/widgets/latest-news.php';
		require REIGN_THEME_DIR . '/widgets/bp-profile-completion-widget.php';
		require REIGN_THEME_DIR . '/widgets/login-widget.php';

		/* Added WooCommerce Support Files */
		if ( class_exists( 'WooCommerce' ) ) {
			require_once REIGN_INC_DIR . '/woocommerce/woocommerce-functions.php';
			require REIGN_THEME_DIR . '/widgets/woocommerce/class-reign-woo-widget-product-categories.php';
		}

		if ( class_exists( 'PeepSo' ) ) {
			require REIGN_THEME_DIR . '/widgets/peepso/widgetuserbar.php';
		}

		/* Theme Required Plugins Manager Files */
		require_once REIGN_INC_DIR . 'required-plugins/class-tgm-plugin-activation.php';
		require_once REIGN_INC_DIR . 'required-plugins/required-plugins.php';

		/* Theme Options Panel In Admin Dashboard */
		require_once REIGN_INC_DIR . 'reign-settings/reign-theme-options-manager.php';
		require_once REIGN_INC_DIR . 'reign-settings/option-functions.php';

		/* Theme License And Update Management */
		require_once REIGN_INC_DIR . 'edd-updater/theme-updater.php';
		require_once REIGN_INC_DIR . 'reign-settings/class-reign-license-manager.php';

		/* Include Shortcodes file */
		require_once REIGN_INC_DIR . 'shortcodes/shortcodes.php';

		/* Include postmeta management file */
		include_once REIGN_THEME_DIR . '/inc/wbcom-postmeta-mgmt/wbcom-postmeta-mgmt.php';

		if ( function_exists( 'bp_get_theme_package_id' ) ) {
			$theme_package_id = bp_get_theme_package_id();
		} else {
			$theme_package_id = 'legacy';
		}

		if ( class_exists( 'BuddyPress' ) ) {

			/* Special Support To BuddyPress */
			require REIGN_THEME_DIR . '/inc/buddypress/buddypress-functions.php';

			/* Social links xprofile customization file */
			include_once REIGN_THEME_DIR . '/inc/buddypress/reign-social-links-xprofile.php';

			/* Header view xprofile customization file */
			include_once REIGN_THEME_DIR . '/inc/buddypress/reign-header-view-xprofile.php';

			/* Include buddypress members customization file */
			include_once REIGN_THEME_DIR . '/inc/buddypress/reign-bp-member-customization.php';

			/* Include buddypress groups customization file */
			include_once REIGN_THEME_DIR . '/inc/buddypress/reign-bp-group-customization.php';
		}

		// Call rtmedia functions file.
		if ( class_exists( 'RTMedia' ) ) {
			require REIGN_THEME_DIR . '/inc/buddypress/rtmedia-functions.php';
		}

		/**
		 * Plugin specific support.
		 */
		if ( defined( 'PMPRO_VERSION' ) ) {
			include_once 'inc/plugins-support/class-rtm-pmpro-customization.php';
		}

		if ( class_exists( 'Easy_Digital_Downloads' ) ) {
			include_once 'inc/plugins-support/class-rtm-edd-customization.php';
		}

		if ( class_exists( 'PeepSo' ) ) {
			include_once 'inc/plugins-support/class-reign-walker-nav-menu-checklist.php';
		}

		if ( class_exists( 'WooCommerce' ) ) {
			include_once 'inc/plugins-support/class-rtm-woocommerce-customization.php';
		}

		// Custom Login.
		include_once REIGN_THEME_DIR . '/inc/login.php';
	}

	/**
	 * Added support for svg.
	 */
	public function reign_theme_upload_mimes( $file_types ) {
		$file_types['svg'] = 'image/svg+xml';

		return $file_types;
	}

}

$reigntm_theme_class = new REIGN_Theme_Class();

/*
 * Call amp templates for archive single post, post category/tag, search and author page when amp request get
 *
 */
add_filter( 'template_include', 'reign_theme_amp_templatre_include', '9999992233720368547758099' );
function reign_theme_amp_templatre_include( $template_file ) {

	if ( function_exists( 'amp_is_request' ) && amp_is_request() || ( function_exists( 'amp_is_legacy' ) && amp_is_legacy() ) ) {
		if ( is_single() && get_post_type() == 'post' ) {
			$template_file = get_template_directory() . '/amp/single.php';
		}

		if ( ( is_home() && get_post_type() == 'post' ) || is_category() || is_tag() || is_author() ) {
			$template_file = get_template_directory() . '/amp/archive.php';
		}
		if ( is_search() ) {
			$template_file = get_template_directory() . '/amp/search.php';
		}

		if ( is_archive() && get_post_type() == 'post' ) {
			$template_file = get_template_directory() . '/amp/archive.php';
		}
	}
	return $template_file;
}


/*
 * Call amp comments template when amp request get
 *
 */
add_filter( 'comments_template', 'reign_theme_amp_single_comments_template' );
function reign_theme_amp_single_comments_template( $comments_template ) {
	if ( function_exists( 'amp_is_request' ) && amp_is_request() || ( function_exists( 'amp_is_legacy' ) && amp_is_legacy() ) ) {
		if ( is_single() && get_post_type() == 'post' ) {
			$comments_template = get_template_directory() . '/amp/comments.php';
		}
	}
	return $comments_template;
}


/*
 * Call switch theme to  child theme and update parent theme mod to child theme
 *
 */
function reign_theme_switch_to_child_theme( $new_name, $new_theme, $old_theme ) {

	if ( $new_name == 'REIGN Child' ) {
		$theme_mods = get_option( 'theme_mods_' . get_template(), true );
		update_option( 'theme_mods_' . get_stylesheet(), $theme_mods );
	}
}

add_action( 'switch_theme', 'reign_theme_switch_to_child_theme', 99, 3 );

/**
 * WP_Navwalker class.
 */
class Reign_Left_Panel_Menu_Walker extends Walker_Nav_Menu {

	/**
	 * Starts the element output.
	 *
	 * @param string   $output Used to append additional content (passed by reference).
	 * @param WP_Post  $item Menu item data object.
	 * @param int      $depth Depth of menu item. Used for padding.
	 * @param stdClass $args An object of wp_nav_menu() arguments.
	 * @param int      $id Current item ID.
	 *
	 * @see Walker_Nav_Menu::start_el()
	 *
	 * @since Reign 7.1.2
	 * @since WP 4.4.0 The {@see 'nav_menu_item_args'} filter was added.
	 */
	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

		if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}
		$indent = ( $depth ) ? str_repeat( $t, $depth ) : '';

		$classes   = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;

		// Left panel section.
		if ( isset( $item->post_content ) && 'reign-theme-section' === $item->post_content ) {
			$classes[] = 'reign-menu-section';
		}

		// Stick to bottom of the menu.
		if ( isset( $item->stick_to_bottom ) && '1' == $item->stick_to_bottom ) {
			$classes[] = 'bp-menu-item-at-bottom';
		}

		// Add the count for the messages in Left panel.
		if (
			function_exists( 'bp_is_active' ) &&
			bp_is_active( 'messages' ) &&
			function_exists( 'bp_loggedin_user_id' ) &&
			function_exists( 'bp_get_messages_slug' ) &&
			in_array( 'bp-' . bp_get_messages_slug() . '-nav', $classes, true )
		) {
			$classes[] = 'bp-left-panel-menu-item-' . bp_get_messages_slug() . '-count-' . bp_loggedin_user_id();
		}

		/**
		 * Filters the arguments for a single nav menu item.
		 *
		 * @since 4.4.0
		 *
		 * @param stdClass $args  An object of wp_nav_menu() arguments.
		 * @param WP_Post  $item  Menu item data object.
		 * @param int      $depth Depth of menu item. Used for padding.
		 */
		$args = apply_filters( 'nav_menu_item_args', $args, $item, $depth );

		/**
		 * Filters the CSS class(es) applied to a menu item's list item element.
		 *
		 * @since 3.0.0
		 * @since 4.1.0 The `$depth` parameter was added.
		 *
		 * @param array    $classes The CSS classes that are applied to the menu item's `<li>` element.
		 * @param WP_Post  $item    The current menu item.
		 * @param stdClass $args    An object of wp_nav_menu() arguments.
		 * @param int      $depth   Depth of menu item. Used for padding.
		 */
		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		/**
		 * Filters the ID applied to a menu item's list item element.
		 *
		 * @since 3.0.1
		 * @since 4.1.0 The `$depth` parameter was added.
		 *
		 * @param string   $menu_id The ID that is applied to the menu item's `<li>` element.
		 * @param WP_Post  $item    The current menu item.
		 * @param stdClass $args    An object of wp_nav_menu() arguments.
		 * @param int      $depth   Depth of menu item. Used for padding.
		 */
		$id = apply_filters( 'nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth );
		$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

		$output .= $indent . '<li' . $id . $class_names . '>';

		$atts           = array();
		$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
		$atts['target'] = ! empty( $item->target ) ? $item->target : '';
		$atts['rel']    = ! empty( $item->xfn ) ? $item->xfn : '';
		$atts['href']   = ! empty( $item->url ) ? $item->url : '';

		/**
		 * Filters the HTML attributes applied to a menu item's anchor element.
		 *
		 * @since 3.6.0
		 * @since 4.1.0 The `$depth` parameter was added.
		 *
		 * @param array $atts {
		 *     The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
		 *
		 *     @type string $title  Title attribute.
		 *     @type string $target Target attribute.
		 *     @type string $rel    The rel attribute.
		 *     @type string $href   The href attribute.
		 * }
		 * @param WP_Post  $item  The current menu item.
		 * @param stdClass $args  An object of wp_nav_menu() arguments.
		 * @param int      $depth Depth of menu item. Used for padding.
		 */
		$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

		$attributes = '';
		foreach ( $atts as $attr => $value ) {
			if ( ! empty( $value ) ) {
				$value       = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
				$attributes .= ' ' . $attr . '="' . $value . '"';
			}
		}

		/** This filter is documented in wp-includes/post-template.php */
		$title = apply_filters( 'the_title', $item->title, $item->ID );

		/**
		 * Filters a menu item's title.
		 *
		 * @since 4.4.0
		 *
		 * @param string   $title The menu item's title.
		 * @param WP_Post  $item  The current menu item.
		 * @param stdClass $args  An object of wp_nav_menu() arguments.
		 * @param int      $depth Depth of menu item. Used for padding.
		 */
		$title        = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );
		$item_output  = ( isset( $args->before ) ? $args->before : '' );
		$item_output .= '<a' . $attributes . '>';
		$item_output .= ( isset( $args->link_before ) ? $args->link_before : '' ) . $title . ( isset( $args->link_after ) ? $args->link_after : '' );
		$item_output .= '</a>';
		$item_output .= ( isset( $args->after ) ? $args->after : '' );

		/**
		 * Filters a menu item's starting output.
		 *
		 * The menu item's starting output only includes `$args->before`, the opening `<a>`,
		 * the menu item's title, the closing `</a>`, and `$args->after`. Currently, there is
		 * no filter for modifying the opening and closing `<li>` for a menu item.
		 *
		 * @since 3.0.0
		 *
		 * @param string   $item_output The menu item's starting HTML output.
		 * @param WP_Post  $item        Menu item data object.
		 * @param int      $depth       Depth of menu item. Used for padding.
		 * @param stdClass $args        An object of wp_nav_menu() arguments.
		 */
		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );

	}
}
