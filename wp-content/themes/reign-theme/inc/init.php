<?php

// Require plugin.php to use is_plugin_active() below.
if ( ! function_exists( 'is_plugin_active' ) ) {
	include_once ABSPATH . 'wp-admin/includes/plugin.php';
}

/**
 * Reign functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Reign
 */
if ( ! function_exists( 'reign_setup' ) ) {

	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function reign_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Reign, use a find and replace
		 * to change 'reign' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'reign', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		add_theme_support( 'custom-logo' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		if ( function_exists( 'add_image_size' ) ) {

			add_image_size( 'reign-featured-large', 1200, 675 );
			add_image_size( 'reign-thumb', 600, 300 );
		}

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'menu-1'                 => esc_html__( 'Primary - Logged in users', 'reign' ),
				'menu-1-logout'          => esc_html__( 'Primary - Logged out users', 'reign' ),
				'panel-menu'             => esc_html__( 'Left Panel - Logged in users', 'reign' ),
				'panel-menu-loggedout'   => esc_html__( 'Left Panel - Logged out users', 'reign' ),
				'mobile-menu-logged-in'  => esc_html__( 'Mobile Menu - Logged in', 'reign' ),
				'mobile-menu-logged-out' => esc_html__( 'Mobile Menu - Logged out', 'reign' ),
				'menu-2'                 => esc_html__( 'User Profile', 'reign' ),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);

		/*
		 * Enable support for Post Formats.
		 * See http://codex.wordpress.org/Post_Formats
		 */
		add_theme_support(
			'post-formats',
			array(
				'aside',
				'image',
				'gallery',
				'video',
				'audio',
				'quote',
				'link',
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'wbcom_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		// Add support for Block Styles.
		add_theme_support( 'wp-block-styles' );

		// Add support for full and wide align images.
		add_theme_support( 'align-wide' );

		// Add support for editor styles.
		add_theme_support( 'editor-styles' );

		// Enqueue editor styles.
		add_editor_style( 'style-editor.css' );

		// Add custom editor font sizes.
		add_theme_support( 'editor-font-sizes', array() );

		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );
		add_theme_support( 'woocommerce' );

		add_theme_support(
			'amp',
			array(
				'comments_live_list' => true,
			)
		);
	}

	add_action( 'after_setup_theme', 'reign_setup' );
}

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
if ( ! function_exists( 'reign_content_width' ) ) {

	function reign_content_width() {
		$GLOBALS['content_width'] = apply_filters( 'wbcom_content_width', 640 );
	}

	add_action( 'after_setup_theme', 'reign_content_width', 0 );
}

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
if ( ! function_exists( 'reign_widgets_init' ) ) {

	function reign_widgets_init() {
		register_sidebar(
			array(
				'name'          => esc_html__( 'Right Sidebar', 'reign' ),
				'id'            => 'sidebar-right',
				'description'   => esc_html__( 'Widgets in this area are used in the right sidebar region.', 'reign' ),
				'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<h4 class="widget-title"><span>',
				'after_title'   => '</span></h4>',
			)
		);

		register_sidebar(
			array(
				'name'          => esc_html__( 'Left Sidebar', 'reign' ),
				'id'            => 'sidebar-left',
				'description'   => esc_html__( 'Widgets in this area are used in the left sidebar region.', 'reign' ),
				'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<h4 class="widget-title"><span>',
				'after_title'   => '</span></h4>',
			)
		);

		if ( class_exists( 'WooCommerce' ) ) {
			register_sidebar(
				array(
					'name'          => esc_html__( 'WooCommerce Right Sidebar', 'reign' ),
					'id'            => 'woocommerce-sidebar-right',
					'description'   => esc_html__( 'Widgets in this area are used in the woocommerce right sidebar region.', 'reign' ),
					'before_widget' => '<section id="%1$s" class="widget %2$s">',
					'after_widget'  => '</section>',
					'before_title'  => '<h4 class="widget-title"><span>',
					'after_title'   => '</span></h4>',
				)
			);

			register_sidebar(
				array(
					'name'          => esc_html__( 'WooCommerce Left Sidebar', 'reign' ),
					'id'            => 'woocommerce-sidebar-left',
					'description'   => esc_html__( 'Widgets in this area are used in the woocommerce left sidebar region.', 'reign' ),
					'before_widget' => '<section id="%1$s" class="widget %2$s">',
					'after_widget'  => '</section>',
					'before_title'  => '<h4 class="widget-title"><span>',
					'after_title'   => '</span></h4>',
				)
			);

			// Off Canvas Sidebar.
			if ( true === get_theme_mod( 'reign_woo_off_canvas_filter', false ) ) {
				register_sidebar(
					array(
						'name'          => esc_html__( 'Off Canvas Sidebar', 'reign' ),
						'id'            => 'reign_off_canvas_sidebar',
						'description'   => esc_html__( 'Widgets in this area are used in the woocommerce Off Canvas sidebar region.', 'reign' ),
						'before_widget' => '<section id="%1$s" class="widget %2$s">',
						'after_widget'  => '</section>',
						'before_title'  => '<h4 class="widget-title"><span>',
						'after_title'   => '</span></h4>',
					)
				);
			}
		}

		/* Dedicated widget support for BuddyPress */
		if ( class_exists( 'BuddyPress' ) ) {
			if ( ! class_exists( 'Youzify' ) ) {
				register_sidebar(
					array(
						'name'          => esc_html__( 'Groups Index', 'reign' ),
						'id'            => 'group-index',
						'description'   => esc_html__( 'Add widgets here.', 'reign' ),
						'before_widget' => '<section id="%1$s" class="widget %2$s">',
						'after_widget'  => '</section>',
						'before_title'  => '<h4 class="widget-title"><span>',
						'after_title'   => '</span></h4>',
					)
				);

				register_sidebar(
					array(
						'name'          => esc_html__( 'Member Index', 'reign' ),
						'id'            => 'member-index',
						'description'   => esc_html__( 'Add widgets here.', 'reign' ),
						'before_widget' => '<section id="%1$s" class="widget %2$s">',
						'after_widget'  => '</section>',
						'before_title'  => '<h4 class="widget-title"><span>',
						'after_title'   => '</span></h4>',
					)
				);

				register_sidebar(
					array(
						'name'          => esc_html__( 'Activity Index', 'reign' ),
						'id'            => 'activity-index',
						'description'   => esc_html__( 'Add widgets here.', 'reign' ),
						'before_widget' => '<section id="%1$s" class="widget %2$s">',
						'after_widget'  => '</section>',
						'before_title'  => '<h4 class="widget-title"><span>',
						'after_title'   => '</span></h4>',
					)
				);

				register_sidebar(
					array(
						'name'          => esc_html__( 'Group Single', 'reign' ),
						'id'            => 'group-single',
						'description'   => esc_html__( 'Add widgets here.', 'reign' ),
						'before_widget' => '<section id="%1$s" class="widget %2$s">',
						'after_widget'  => '</section>',
						'before_title'  => '<h4 class="widget-title"><span>',
						'after_title'   => '</span></h4>',
					)
				);

				register_sidebar(
					array(
						'name'          => esc_html__( 'Member Profile', 'reign' ),
						'id'            => 'member-profile',
						'description'   => esc_html__( 'Add widgets here.', 'reign' ),
						'before_widget' => '<section id="%1$s" class="widget %2$s">',
						'after_widget'  => '</section>',
						'before_title'  => '<h4 class="widget-title"><span>',
						'after_title'   => '</span></h4>',
					)
				);
			}
		}

		/* Dedicated widget support for EDD */
		if ( class_exists( 'Easy_Digital_Downloads' ) ) {

			register_sidebar(
				array(
					'name'          => esc_html__( 'Download Archive Sidebar', 'reign' ),
					'id'            => 'edd-download-archive-sidebar',
					'description'   => esc_html__( 'Widgets in this area are used in the EDD download archive page.', 'reign' ),
					'before_widget' => '<section id="%1$s" class="widget %2$s">',
					'after_widget'  => '</section>',
					'before_title'  => '<h4 class="widget-title"><span>',
					'after_title'   => '</span></h4>',
				)
			);

			register_sidebar(
				array(
					'name'          => esc_html__( 'Single Download Sidebar', 'reign' ),
					'id'            => 'edd-single-download-sidebar',
					'description'   => esc_html__( 'Widgets in this area are used in the EDD single download page.', 'reign' ),
					'before_widget' => '<section id="%1$s" class="widget %2$s">',
					'after_widget'  => '</section>',
					'before_title'  => '<h4 class="widget-title"><span>',
					'after_title'   => '</span></h4>',
				)
			);
		}

		// if ( !defined( 'WBCOM_ELEMENTOR_ADDONS_VERSION' ) ) {
		// }
		register_sidebar(
			array(
				'name'          => esc_html__( 'Footer Widget Area', 'reign' ),
				'id'            => 'footer-widget-area',
				'description'   => esc_html__( 'Add widgets here.', 'reign' ),
				'before_widget' => '<section id="%1$s" class="widget %2$s wb-grid-cell">',
				'after_widget'  => '</section>',
				'before_title'  => '<h4 class="widget-title"><span>',
				'after_title'   => '</span></h4>',
			)
		);

		// For PeepSo notification icons.
		if ( class_exists( 'PeepSo' ) ) {
			register_sidebar(
				array(
					'name'          => esc_html__( 'Header Widget Area', 'reign' ),
					'id'            => 'reign-header-widget-area',
					'before_widget' => '<section id="%1$s" class="widget %2$s">',
					'after_widget'  => '</section>',
					'before_title'  => '<h4 class="widget-title"><span>',
					'after_title'   => '</span></h4>',
				)
			);
		}
	}

	add_action( 'widgets_init', 'reign_widgets_init' );
}

/**
 * Enqueue scripts and styles.
 */
if ( ! function_exists( 'reign_scripts' ) ) {

	function reign_scripts() {

		$rtl_css = is_rtl() ? '-rtl' : '';

		// Styles.
		global $wbtm_reign_settings;
		wp_deregister_style( 'font-awesome' );
		wp_deregister_style( 'font-awesome-shims' );

		// EDD Main CSS Enqueue.
		if ( class_exists( 'Easy_Digital_Downloads' ) ) {
			wp_enqueue_style( 'reign_edd_style', get_template_directory_uri() . '/assets/css' . $rtl_css . '/edd-main.min.css', '', REIGN_THEME_VERSION );
		}

		// bbPress Main CSS Enqueue.
		if ( class_exists( 'bbPress' ) ) {
			wp_enqueue_style( 'reign_bbpress_style', get_template_directory_uri() . '/assets/css' . $rtl_css . '/bbpress-main.min.css', '', REIGN_THEME_VERSION );
		}

		// wpforo Main CSS Enqueue.
		if ( is_plugin_active( 'wpforo/wpforo.php' ) ) {
			wp_enqueue_style( 'reign_wpforo_style', get_template_directory_uri() . '/assets/css' . $rtl_css . '/wpforo-main.min.css', '', REIGN_THEME_VERSION );
		}

		// PeepSo Main CSS Enqueue.
		if ( class_exists( 'PeepSo' ) ) {
			wp_enqueue_style( 'reign_peepso_style', get_template_directory_uri() . '/assets/css' . $rtl_css . '/peepso-main.min.css', '', REIGN_THEME_VERSION );
		}

		// Events Calendar Main CSS Enqueue.
		if ( class_exists( 'Tribe__Events__Main' ) ) {
			wp_enqueue_style( 'reign_eventscalendar_style', get_template_directory_uri() . '/assets/css' . $rtl_css . '/eventscalendar-main.min.css', '', REIGN_THEME_VERSION );
		}

		// BuddyPress Package Condition.
		if ( function_exists( 'bp_get_theme_package_id' ) ) {
			$theme_package_id = bp_get_theme_package_id();
		} else {
			$theme_package_id = 'legacy';
		}

		// BuddyPress Legacy Main CSS Enqueue.
		if ( class_exists( 'BuddyPress' ) ) {
			if ( 'legacy' === $theme_package_id ) {
				wp_enqueue_style( 'reign_legacy_style', get_template_directory_uri() . '/assets/css' . $rtl_css . '/legacy-main.min.css', '', REIGN_THEME_VERSION );
			}

			// BuddyPress Nouveau Main CSS Enqueue.
			if ( 'nouveau' === $theme_package_id ) {
				wp_enqueue_style( 'reign_nouveau_style', get_template_directory_uri() . '/assets/css' . $rtl_css . '/nouveau-main.min.css', '', REIGN_THEME_VERSION );
			}
		}

		// BB Platform Main CSS Enqueue.
		if ( is_plugin_active( 'buddyboss-platform/bp-loader.php' ) ) {
			wp_enqueue_style( 'reign_bb_platform', get_template_directory_uri() . '/assets/css' . $rtl_css . '/bb-platform-main.min.css', '', REIGN_THEME_VERSION );
		}

		// Site AMP CSS Enqueue.
		if ( function_exists( 'amp_is_request' ) && amp_is_request() || ( function_exists( 'amp_is_legacy' ) && amp_is_legacy() ) ) {
			wp_enqueue_style( 'reign_amp', get_template_directory_uri() . '/assets/css/reign-amp.min.css', '', REIGN_THEME_VERSION );
		}

		// Site Youzify CSS Enqueue.
		if ( class_exists( 'Youzify' ) ) {
			wp_enqueue_style( 'reign_youzify', get_template_directory_uri() . '/assets/css' . $rtl_css . '/youzify-main.min.css', '', REIGN_THEME_VERSION );
		}

		// Site WP_Event_Manager CSS Enqueue.
		if ( class_exists( 'WP_Event_Manager' ) ) {
			wp_enqueue_style( 'wp_event_manager', get_template_directory_uri() . '/assets/css' . $rtl_css . '/wp-event-manager.min.css', '', REIGN_THEME_VERSION );
		}

		// Site Directories CSS Enqueue.
		if ( class_exists( 'Directorist_Base' ) ) {
			wp_enqueue_style( 'reign_youzify', get_template_directory_uri() . '/assets/css' . $rtl_css . '/directorist-main.min.css', '', REIGN_THEME_VERSION );
		}

		// Site Main CSS Enqueue.
		wp_enqueue_style( 'reign_main_style', get_template_directory_uri() . '/assets/css' . $rtl_css . '/main.min.css', '', REIGN_THEME_VERSION );

		// WooCommerce Main CSS Enqueue.
		if ( class_exists( 'woocommerce' ) ) {
			wp_enqueue_style( 'reign_woocommerce_style', get_template_directory_uri() . '/assets/css' . $rtl_css . '/woocommerce-main.min.css', '', REIGN_THEME_VERSION );
		}

		// Font Awesome Files Enqueue.
		$font_awesome_version = get_theme_mod( 'reign_font_awesome', true );
		if ( $font_awesome_version ) {
			wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/assets/font-awesome/css/all.min.css', '', '6.6.0' );
		} else {
			wp_enqueue_style( 'reign-icons', get_template_directory_uri() . '/assets/icons/reign-icons.css', '', REIGN_THEME_VERSION );
		}

		// Load theme font.
		wp_enqueue_style( 'theme-font', get_template_directory_uri() . '/assets/fonts/fonts.css', '', REIGN_THEME_VERSION );

		if ( function_exists( 'amp_is_request' ) && amp_is_request() || ( function_exists( 'amp_is_legacy' ) && amp_is_legacy() ) ) {
			return;
		}

		// Load Dark Mode JS File.
		$reign_dark_mode_option = get_theme_mod( 'reign_dark_mode_option' );

		if ( $reign_dark_mode_option === true ) {
			wp_enqueue_script( 'wp-dark-mode', get_template_directory_uri() . '/assets/js/dark-mode.js', array( 'jquery' ), REIGN_THEME_VERSION, true );
		}

		// Load GamiPress JS File.
		if ( class_exists( 'GamiPress' ) ) {
			wp_enqueue_script( 'reign-gamipress', get_template_directory_uri() . '/assets/js/gamipress.js', array( 'jquery' ), REIGN_THEME_VERSION, true );
		}

		// Scroll Up.
		if ( true == get_theme_mod( 'reign_enable_scrollup', false ) ) {
			wp_enqueue_script( 'scrollup', get_template_directory_uri() . '/assets/js/vendors/scrollup.min.js', array( 'jquery' ), REIGN_THEME_VERSION, true );
		}

		// Easy Digital Downloads JS File.
		if ( class_exists( 'Easy_Digital_Downloads' ) ) {
			wp_enqueue_script( 'reign-edd', get_template_directory_uri() . '/assets/js/reign-edd.min.js', array( 'jquery' ), REIGN_THEME_VERSION, true );
		}

		// PeepSo JS File.
		if ( class_exists( 'PeepSo' ) ) {
			wp_enqueue_script( 'reign-peepso', get_template_directory_uri() . '/assets/js/reign-peepso.min.js', array( 'jquery' ), REIGN_THEME_VERSION, true );
		}

		// bbPress JS File.
		if ( class_exists( 'bbPress' ) ) {
			wp_enqueue_script( 'reign-bbpress', get_template_directory_uri() . '/assets/js/reign-bbpress.min.js', array( 'jquery' ), REIGN_THEME_VERSION, true );
		}

		// BuddyPress JS File.
		if ( class_exists( 'BuddyPress' ) ) {
			wp_enqueue_script( 'reign-buddypress', get_template_directory_uri() . '/assets/js/reign-buddypress.min.js', array( 'jquery', 'password-strength-meter' ), REIGN_THEME_VERSION, true );
		}

		// WooCommerce JS File.
		if ( class_exists( 'WooCommerce' ) ) {
			wp_enqueue_script( 'reign-woocommerce', get_template_directory_uri() . '/assets/js/reign-woocommerce.min.js', array( 'jquery' ), REIGN_THEME_VERSION, true );

			$reign_woo_layout_view_buttons   = get_theme_mod( 'reign_woo_layout_view_buttons', true );
			$reign_woo_myaccount_menu_toggle = get_theme_mod( 'reign_woo_myaccount_menu_toggle', false );

			wp_localize_script(
				'reign-woocommerce',
				'wp_woocommerce_js_obj',
				array(
					'enable_layout_view_buttons'   => $reign_woo_layout_view_buttons,
					'enable_myaccount_menu_toggle' => $reign_woo_myaccount_menu_toggle,
				)
			);

		}

		if ( ! function_exists( 'check_masonry_view_in_shortcode' ) ) {
			/**
			 * Checks if the content contains the 'reign_display_posts' shortcode with 'masonry-view' layout.
			 *
			 * @param string $content The content to check for the shortcode.
			 * @return bool True if the shortcode with 'masonry-view' is found, false otherwise.
			 */
			function check_masonry_view_in_shortcode( $content ) {
				$pattern = get_shortcode_regex( array( 'reign_display_posts' ) );
				if ( preg_match_all( '/' . $pattern . '/s', $content, $matches )
					&& array_key_exists( 2, $matches )
					&& in_array( 'reign_display_posts', $matches[2] ) ) {
					$key  = array_search( 'reign_display_posts', $matches[2] );
					$atts = shortcode_parse_atts( $matches[3][ $key ] );
					if ( isset( $atts['posts_view'] ) && $atts['posts_view'] === 'masonry-view' ) {
						return true;
					}
				}
				return false;
			}
		}

		// Filter to set the enable_masonry value.
		add_filter(
			'reign_enable_masonry',
			function () {
				global $post;
				if ( isset( $post->post_content ) && check_masonry_view_in_shortcode( $post->post_content ) ) {
					return 'masonry-view';
				}
				return get_theme_mod( 'reign_blog_list_layout', 'default-view' );
			}
		);

		// Masonry JS File.
		if ( apply_filters( 'reign_enable_masonry', get_theme_mod( 'reign_blog_list_layout', 'default-view' ) ) == 'masonry-view' ) {
			wp_enqueue_script( 'reign-masonry', get_template_directory_uri() . '/assets/js/vendors/masonry.min.js', array( 'jquery' ), REIGN_THEME_VERSION, true );
		}

		// Theme JS File.
		wp_enqueue_script( 'wp-main', get_template_directory_uri() . '/assets/js/main.min.js', array( 'jquery' ), REIGN_THEME_VERSION, true );

		// Add More Header Script.
		$more_menu_enable = get_theme_mod( 'reign_header_main_menu_more_enable', true );

		// Elementor topbar check.
		$reign_header_topbar_type = get_theme_mod( 'reign_header_topbar_type', false );

		// Check if topbar is disabled in mobile view.
		$reign_header_topbar_mobile_view_disable = get_theme_mod( 'reign_header_topbar_mobile_view_disable', false );

		$rtl = false;
		if ( is_rtl() ) {
			$rtl = true;
		}

		$single_activity_page = false;

		if ( function_exists( 'bp_is_single_activity' ) && bp_is_single_activity() ) {
			$single_activity_page = true;
		}
		$append_text = apply_filters( 'bp_activity_excerpt_append_text', __( '[Read more]', 'buddypress' ) );
		if ( function_exists( 'bp_activity_get_excerpt_length' ) ) {
			$excerpt_length = bp_activity_get_excerpt_length();
		} else {
			$excerpt_length = 200;
		}

		if ( function_exists( 'bp_get_theme_package_id' ) ) {
			$theme_package_id = bp_get_theme_package_id();
		} else {
			$theme_package_id = 'legacy';
		}

		wp_localize_script(
			'wp-main',
			'wp_main_js_obj',
			array(
				'ajaxurl'                => admin_url( 'admin-ajax.php' ),
				'reign_more_menu_enable' => $more_menu_enable,
				'reign_ele_topbar'       => $reign_header_topbar_type,
				'logged_in'              => is_user_logged_in(),
				'topbar_mobile_disabled' => $reign_header_topbar_mobile_view_disable,
				'reign_rtl'              => $rtl,
				'single_activity_page'   => $single_activity_page,
				'append_text'            => $append_text,
				'excerpt_length'         => $excerpt_length,
				'theme_package_id'       => $theme_package_id,
				'reign_enable_scrollup'  => get_theme_mod( 'reign_enable_scrollup', false ),
				'reign_scrollup_style'   => get_theme_mod( 'reign_scrollup_style', 'style1' ),
				'rg_blog_category_color' => get_theme_mod( 'rg_blog_category_color', 'cat_color_random' ),
				'bp_subnav_view_style'   => get_theme_mod( 'buddypress_main_subnav_view_style', 'default' ),
				'enable_masonry'         => apply_filters( 'reign_enable_masonry', get_theme_mod( 'reign_blog_list_layout', 'default-view' ) ),
			)
		);

		$custom_logo = wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ), 'large' );
		wp_localize_script(
			'wp-dark-mode',
			'dark_mode_settings',
			array(
				'light_mode_logo' => ( ! empty( $custom_logo ) ) ? $custom_logo[0] : '',
				'dark_mod_logo'   => get_theme_mod( 'reign_dark_mode_logo' ),
				'images'          => get_option( 'reign_dark_mode_image_settings' ),
			)
		);

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

		// Adds UI scripts.
		if ( ! is_admin() ) {
			if ( function_exists( 'bp_is_activity_heartbeat_active' ) && bp_is_activity_heartbeat_active() ) {
				// Heartbeat
				wp_enqueue_script( 'heartbeat' );
			}
		}

		// Loads dynamic inline style.
		$css = load_color_palette();
		wp_add_inline_style( 'reign_main_style', $css );

		// Loads dynamic inline style.
		$reign_dark_mode_option        = get_theme_mod( 'reign_dark_mode_option' );
		$reign_custom_dark_mode_option = get_theme_mod( 'reign_custom_dark_mode_option' );

		if ( true === $reign_dark_mode_option && true === $reign_custom_dark_mode_option ) {
			$dark_css = load_color_dark_palette();
			wp_add_inline_style( 'reign_main_style', $dark_css );
		}

		// Loads dynamic border radius inline style.
		$radius_css = load_border_radius();
		wp_add_inline_style( 'reign_main_style', $radius_css );
	}

	add_action( 'wp_enqueue_scripts', 'reign_scripts', 5001 );
}

if ( ! function_exists( 'register_reign_menu_page' ) ) {

	/**
	 * Register Reign Menu Page
	 */
	function register_reign_menu_page() {
		// Set position with odd number to avoid confict with other plugin/theme.
		add_menu_page( __( 'Reign Settings', 'reign' ), __( 'Reign Settings', 'reign' ), 'manage_options', 'reign-settings', '', '', 61.000329 );

		// To remove empty parent menu item.
		add_submenu_page( 'reign-settings', __( 'Reign Settings', 'reign' ), __( 'Reign Settings', 'reign' ), 'manage_options', 'reign-settings' );
		remove_submenu_page( 'reign-settings', 'reign-settings' );
	}

	add_action( 'admin_menu', 'register_reign_menu_page' );
}

/**
 * Remove Secondary Group Icon
 */
function my_remove_secondary_avatars( $bp_legacy ) {
	remove_filter( 'bp_get_activity_action_pre_meta', array( $bp_legacy, 'secondary_avatars' ), 10, 2 );
}

add_action( 'bp_theme_compat_actions', 'my_remove_secondary_avatars' );

/**
 * Heartbeat settings
 */
function reign_heartbeat_settings( $settings ) {
	$settings['interval'] = 5;
	return $settings;
}

add_filter( 'heartbeat_settings', 'reign_heartbeat_settings' );

/**
 * Sending a heartbeat for notification updates
 */
function reign_notification_count_heartbeat( $response, $data, $screen_id ) {
	$notifications = array();

	if ( function_exists( 'bp_friend_get_total_requests_count' ) ) {
		$friend_request_count = bp_friend_get_total_requests_count();
	}
	if ( function_exists( 'bp_notifications_get_all_notifications_for_user' ) ) {
		$notifications = bp_notifications_get_all_notifications_for_user( get_current_user_id() );
	}

	$notification_count = count( $notifications );

	if ( function_exists( 'bp_notifications_get_all_notifications_for_user' ) ) {
		$notifications        = bp_notifications_get_notifications_for_user( bp_loggedin_user_id() );
		$notification_content = array();
		if ( ! empty( $notifications ) ) {
			foreach ( (array) $notifications as $notification ) {
				if ( is_array( $notification ) ) {
					if ( isset( $notification['link'] ) && isset( $notification['text'] ) ) {
						$notification_content[] = "<a href='" . esc_url( $notification['link'] ) . "'>{$notification[ 'text' ]}</a>";
					}
				} else {
					$notification_content[] = $notification;
				}
			}
		}

		if ( empty( $notification_content ) ) {
			$notification_content[] = '<a href="' . bp_loggedin_user_domain() . '' . bp_get_notifications_slug() . '/">' . __( 'No new notifications', 'buddypress' ) . '</a>';
		}
	}
	if ( function_exists( 'messages_get_unread_count' ) ) {
		$unread_message_count = messages_get_unread_count();
	}

	$response['reign_notification_count'] = array(
		'friend_request'       => @intval( $friend_request_count ),
		'notification'         => @intval( $notification_count ),
		'notification_content' => @$notification_content,
		'unread_message'       => @intval( $unread_message_count ),
	);

	return $response;
}

// Logged in users.
if ( class_exists( 'BuddyPress' ) ) {
	add_filter( 'heartbeat_received', 'reign_notification_count_heartbeat', 10, 3 );
}

/**
 * Set the global variable for activated color scheme.
 *
 * @global string $color_scheme
 */
if ( ! function_exists( 'reign_color_scheme' ) ) {

	function reign_color_scheme() {
		$GLOBALS['rtm_color_scheme'] = get_theme_mod( 'reign_color_scheme', 'reign_clean' );
		$theme_mods                  = $mods                             = get_theme_mods();

		if ( isset( $mods[0] ) && $mods[0] == '' ) {
			unset( $mods[0] );
		}

		$flg = true;
		if ( empty( $mods ) ) {
			$stylesheet                       = get_option( 'stylesheet' );
			$theme_mod                        = 'theme_mods_' . $stylesheet;
			$theme_mods['reign_color_scheme'] = 'reign_clean';
			update_option( $theme_mod, $theme_mods );
			$flg = false;
		}

		/* Update Color scheme with new version */
		$update_reign_theme = get_option( 'update_reign_theme' );
		if ( ! empty( $mods ) && ! $update_reign_theme && $flg == true ) {
			$reign_color_scheme = ( isset( $theme_mods['reign_color_scheme'] ) && $theme_mods['reign_color_scheme'] != '' ) ? $theme_mods['reign_color_scheme'] : 'reign_default';

			$update_theme_mode_colors = array(
				'reign_header_topbar_bg_color',
				'reign_header_topbar_text_color',
				'reign_header_topbar_text_hover_color',
				'reign_header_bg_color',
				'reign_header_main_menu_text_hover_color',
				'reign_header_main_menu_text_active_color',
				'reign_header_main_menu_bg_hover_color',
				'reign_header_main_menu_bg_active_color',
				'reign_header_sub_menu_bg_color',
				'reign_header_sub_menu_text_hover_color',
				'reign_header_sub_menu_bg_hover_color',
				'reign_header_icon_color',
				'reign_header_icon_hover_color',
				'reign_footer_widget_area_bg_color',
				'reign_footer_widget_title_color',
				'reign_footer_widget_text_color',
				'reign_footer_widget_link_color',
				'reign_footer_widget_link_hover_color',
				'reign_footer_copyright_bg_color',
				'reign_footer_copyright_text_color',
				'reign_footer_copyright_link_color',
				'reign_footer_copyright_link_hover_color',
			);

			foreach ( $update_theme_mode_colors as $colors ) {
				/* Reign reign_header_topbar_bg_color Update with new version */
				if ( isset( $theme_mods[ $colors ] ) && $theme_mods[ $colors ] != '' && ! isset( $theme_mods[ $reign_color_scheme . '-' . $colors ] ) ) {
					$theme_mods[ $reign_color_scheme . '-' . $colors ] = $theme_mods[ $colors ];
				}
			}
			$update_theme_mode_colors_garoup = array(
				'reign_title_tagline_typography',
				'reign_header_main_menu_font',
				'reign_header_sub_menu_font',
			);
			foreach ( $update_theme_mode_colors_garoup as $colors ) {
				/* Reign reign_header_topbar_bg_color Update with new version */
				if ( isset( $theme_mods[ $colors ]['color'] ) && $theme_mods[ $colors ]['color'] != '' && ! isset( $theme_mods[ $reign_color_scheme . '-' . $colors ] ) ) {
					$theme_mods[ $reign_color_scheme . '-' . $colors ] = $theme_mods[ $colors ]['color'];
				}
			}
			$theme_mods['reign_color_scheme'] = $reign_color_scheme;
			$stylesheet                       = get_option( 'stylesheet' );
			$theme_mod                        = 'theme_mods_' . $stylesheet;
			update_option( $theme_mod, $theme_mods );
			update_option( 'update_reign_theme', true );
		}
	}

	add_action( 'after_setup_theme', 'reign_color_scheme' );
}

add_filter( 'body_class', 'reign_header_v4_body_class', 10, 1 );

/**
 *
 * Function to add body class when reign header v4 is active.
 */
function reign_header_v4_body_class( $classes ) {
	if ( ! get_theme_mod( 'reign_header_header_type', false ) && 'v4' === get_theme_mod( 'reign_header_layout', 'v2' ) ) {
		$classes[] = 'reign-header-v4';
	}

	if ( ! is_user_logged_in() ) {
		$classes[] = 'logged-out';
	}
	return $classes;
}

add_action( 'bp_init', 'reign_restrict_hearbeat_for_bp' );

/**
 *
 * Function to restrict heartbeat request being send on non required bp pages.
 */
function reign_restrict_hearbeat_for_bp() {
	if ( bp_is_activity_component() && ! bp_is_activity_directory() ) {
		remove_filter( 'heartbeat_received', 'bp_activity_heartbeat_last_recorded', 10, 2 );
		remove_filter( 'heartbeat_nopriv_received', 'bp_activity_heartbeat_last_recorded', 10, 2 );
	}
}

/*
 * Cartflow plugin compatibility with Canvas page builder.
 */
add_filter( 'cartflows_is_compatibility_theme', '__return_true' );

/**
 * Conver Hex to RGB
 *
 * @since 7.4.3
 *
 * @param string $color color.
 *
 * @return string
 */
function hex2rgb( string $color ) {

	$default = '0, 0, 0';

	if ( $color === '' ) {
		return '';
	}

	if ( strpos( $color, 'var(--' ) === 0 ) {
		return preg_replace( '/[^A-Za-z0-9_)(\-,.]/', '', $color );
	}

	// Convert hex to rgb.
	if ( $color[0] == '#' ) {
		$color = substr( $color, 1 );
	} else {
		return $default;
	}

	// Check if color has 6 or 3 characters and get values.
	if ( strlen( $color ) == 6 ) {
		$hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
	} elseif ( strlen( $color ) == 3 ) {
		$hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
	} else {
		return $default;
	}

	$rgb = array_map( 'hexdec', $hex );

	return implode( ', ', $rgb );
}


/**
 * Load color palette
 *
 * @since 6.9.2
 * @return string
 */
function load_color_palette() {
	$colors = array(
		'reign_header_topbar_bg_color'             => '--reign-header-topbar-bg-color',
		'reign_header_topbar_text_color'           => '--reign-header-topbar-text-color',
		'reign_header_topbar_text_hover_color'     => '--reign-header-topbar-text-hover-color',
		'reign_header_bg_color'                    => '--reign-header-bg-color',
		'reign_header_nav_bg_color'                => '--reign-header-nav-bg-color',
		'reign_title_tagline_typography'           => '--reign-title-tagline-typography',
		'reign_header_main_menu_font'              => '--reign-header-main-menu-font',
		'reign_header_main_menu_text_hover_color'  => '--reign-header-main-menu-text-hover-color',
		'reign_header_main_menu_text_active_color' => '--reign-header-main-menu-text-active-color',
		'reign_header_main_menu_bg_hover_color'    => '--reign-header-main-menu-bg-hover-color',
		'reign_header_main_menu_bg_active_color'   => '--reign-header-main-menu-bg-active-color',
		'reign_header_sub_menu_bg_color'           => '--reign-header-sub-menu-bg-color',
		'reign_header_sub_menu_font'               => '--reign-header-sub-menu-font',
		'reign_header_sub_menu_text_hover_color'   => '--reign-header-sub-menu-text-hover-color',
		'reign_header_sub_menu_bg_hover_color'     => '--reign-header-sub-menu-bg-hover-color',
		'reign_header_icon_color'                  => '--reign-header-icon-color',
		'reign_header_icon_hover_color'            => '--reign-header-icon-hover-color',
		'reign_mobile_menu_bg_color'               => '--reign-mobile-menu-bg-color',
		'reign_mobile_menu_color'                  => '--reign-mobile-menu-color',
		'reign_mobile_menu_hover_color'            => '--reign-mobile-menu-hover-color',
		'reign_mobile_menu_active_color'           => '--reign-mobile-menu-active-color',
		'reign_mobile_menu_active_bg_color'        => '--reign-mobile-menu-active-bg-color',
		'reign_left_panel_bg_color'                => '--reign-left-panel-bg-color',
		'reign_left_panel_toggle_color'            => '--reign-left-panel-toggle-color',
		'reign_left_panel_menu_font_color'         => '--reign-left-panel-menu-font-color',
		'reign_left_panel_menu_hover_color'        => '--reign-left-panel-menu-hover-color',
		'reign_left_panel_menu_active_color'       => '--reign-left-panel-menu-active-color',
		'reign_left_panel_menu_bg_hover_color'     => '--reign-left-panel-menu-bg-hover-color',
		'reign_left_panel_menu_bg_active_color'    => '--reign-left-panel-menu-bg-active-color',
		'reign_left_panel_menu_icon_active_color'  => '--reign-left-panel-menu-icon-active-color',
		'reign_left_panel_tooltip_bg_color'        => '--reign-left-panel-tooltip-bg-color',
		'reign_left_panel_tooltip_color'           => '--reign-left-panel-tooltip-color',
		'reign_site_body_bg_color'                 => '--reign-site-body-bg-color',
		'reign_site_body_text_color'               => '--reign-site-body-text-color',
		'reign_site_alternate_text_color'          => '--reign-site-alternate-text-color',
		'reign_site_sections_bg_color'             => '--reign-site-sections-bg-color',
		'reign_site_secondary_bg_color'            => '--reign-site-secondary-bg-color',
		'reign_colors_theme'                       => '--reign-colors-theme',
		'reign_site_headings_color'                => '--reign-site-headings-color',
		'reign_site_link_color'                    => '--reign-site-link-color',
		'reign_site_link_hover_color'              => '--reign-site-link-hover-color',
		'reign_accent_color'                       => '--reign-accent-color',
		'reign_accent_hover_color'                 => '--reign-accent-hover-color',
		'reign_site_button_text_color'             => '--reign-site-button-text-color',
		'reign_site_button_text_hover_color'       => '--reign-site-button-text-hover-color',
		'reign_site_button_bg_color'               => '--reign-site-button-bg-color',
		'reign_site_button_bg_hover_color'         => '--reign-site-button-bg-hover-color',
		'reign_site_border_color'                  => '--reign-site-border-color',
		'reign_site_hr_color'                      => '--reign-site-hr-color',
		'reign_footer_widget_area_bg_color'        => '--reign-footer-widget-area-bg-color',
		'reign_footer_widget_title_color'          => '--reign-footer-widget-title-color',
		'reign_footer_widget_text_color'           => '--reign-footer-widget-text-color',
		'reign_footer_widget_link_color'           => '--reign-footer-widget-link-color',
		'reign_footer_widget_link_hover_color'     => '--reign-footer-widget-link-hover-color',
		'reign_footer_copyright_bg_color'          => '--reign-footer-copyright-bg-color',
		'reign_footer_copyright_text_color'        => '--reign-footer-copyright-text-color',
		'reign_footer_copyright_link_color'        => '--reign-footer-copyright-link-color',
		'reign_footer_copyright_link_hover_color'  => '--reign-footer-copyright-link-hover-color',

		'reign_form_text_color'                    => '--reign-form-text-color',
		'reign_form_background_color'              => '--reign-form-background-color',
		'reign_form_border_color'                  => '--reign-form-border-color',
		'reign_form_placeholder_color'             => '--reign-form-placeholder-color',
		'reign_form_focus_text_color'              => '--reign-form-focus-text-color',
		'reign_form_focus_background_color'        => '--reign-form-focus-background-color',
		'reign_form_focus_border_color'            => '--reign-form-focus-border-color',
		'reign_form_focus_placeholder_color'       => '--reign-form-focus-placeholder-color',

	);

	// Customizer colors.
	$default_value_set      = reign_color_scheme_set();
	$default_value_set_form = reign_forms_color_scheme_default_set();
	$reign_color_scheme     = get_theme_mod( 'reign_color_scheme', 'reign_clean' );

	$reign_header_topbar_bg_color             = get_theme_mod( $reign_color_scheme . '-' . 'reign_header_topbar_bg_color', $default_value_set[ $reign_color_scheme ]['reign_header_topbar_bg_color'] );
	$reign_header_topbar_text_color           = get_theme_mod( $reign_color_scheme . '-' . 'reign_header_topbar_text_color', $default_value_set[ $reign_color_scheme ]['reign_header_topbar_text_color'] );
	$reign_header_topbar_text_hover_color     = get_theme_mod( $reign_color_scheme . '-' . 'reign_header_topbar_text_hover_color', $default_value_set[ $reign_color_scheme ]['reign_header_topbar_text_hover_color'] );
	$reign_header_bg_color                    = get_theme_mod( $reign_color_scheme . '-' . 'reign_header_bg_color', $default_value_set[ $reign_color_scheme ]['reign_header_bg_color'] );
	$reign_header_nav_bg_color                = get_theme_mod( $reign_color_scheme . '-' . 'reign_header_nav_bg_color', $default_value_set[ $reign_color_scheme ]['reign_header_nav_bg_color'] );
	$reign_title_tagline_typography           = get_theme_mod( $reign_color_scheme . '-' . 'reign_title_tagline_typography', $default_value_set[ $reign_color_scheme ]['reign_title_tagline_typography'] );
	$reign_header_main_menu_font              = get_theme_mod( $reign_color_scheme . '-' . 'reign_header_main_menu_font', $default_value_set[ $reign_color_scheme ]['reign_header_main_menu_font'] );
	$reign_header_main_menu_text_hover_color  = get_theme_mod( $reign_color_scheme . '-' . 'reign_header_main_menu_text_hover_color', $default_value_set[ $reign_color_scheme ]['reign_header_main_menu_text_hover_color'] );
	$reign_header_main_menu_text_active_color = get_theme_mod( $reign_color_scheme . '-' . 'reign_header_main_menu_text_active_color', $default_value_set[ $reign_color_scheme ]['reign_header_main_menu_text_active_color'] );
	$reign_header_main_menu_bg_hover_color    = get_theme_mod( $reign_color_scheme . '-' . 'reign_header_main_menu_bg_hover_color', $default_value_set[ $reign_color_scheme ]['reign_header_main_menu_bg_hover_color'] );
	$reign_header_main_menu_bg_active_color   = get_theme_mod( $reign_color_scheme . '-' . 'reign_header_main_menu_bg_active_color', $default_value_set[ $reign_color_scheme ]['reign_header_main_menu_bg_active_color'] );
	$reign_header_sub_menu_bg_color           = get_theme_mod( $reign_color_scheme . '-' . 'reign_header_sub_menu_bg_color', $default_value_set[ $reign_color_scheme ]['reign_header_sub_menu_bg_color'] );
	$reign_header_sub_menu_font               = get_theme_mod( $reign_color_scheme . '-' . 'reign_header_sub_menu_font', $default_value_set[ $reign_color_scheme ]['reign_header_sub_menu_font'] );
	$reign_header_sub_menu_text_hover_color   = get_theme_mod( $reign_color_scheme . '-' . 'reign_header_sub_menu_text_hover_color', $default_value_set[ $reign_color_scheme ]['reign_header_sub_menu_text_hover_color'] );
	$reign_header_sub_menu_bg_hover_color     = get_theme_mod( $reign_color_scheme . '-' . 'reign_header_sub_menu_bg_hover_color', $default_value_set[ $reign_color_scheme ]['reign_header_sub_menu_bg_hover_color'] );
	$reign_header_icon_color                  = get_theme_mod( $reign_color_scheme . '-' . 'reign_header_icon_color', $default_value_set[ $reign_color_scheme ]['reign_header_icon_color'] );
	$reign_header_icon_hover_color            = get_theme_mod( $reign_color_scheme . '-' . 'reign_header_icon_hover_color', $default_value_set[ $reign_color_scheme ]['reign_header_icon_hover_color'] );
	$reign_mobile_menu_bg_color               = get_theme_mod( $reign_color_scheme . '-' . 'reign_mobile_menu_bg_color', $default_value_set[ $reign_color_scheme ]['reign_mobile_menu_bg_color'] );
	$reign_mobile_menu_color                  = get_theme_mod( $reign_color_scheme . '-' . 'reign_mobile_menu_color', $default_value_set[ $reign_color_scheme ]['reign_mobile_menu_color'] );
	$reign_mobile_menu_hover_color            = get_theme_mod( $reign_color_scheme . '-' . 'reign_mobile_menu_hover_color', $default_value_set[ $reign_color_scheme ]['reign_mobile_menu_hover_color'] );
	$reign_mobile_menu_active_color           = get_theme_mod( $reign_color_scheme . '-' . 'reign_mobile_menu_active_color', $default_value_set[ $reign_color_scheme ]['reign_mobile_menu_active_color'] );
	$reign_mobile_menu_active_bg_color        = get_theme_mod( $reign_color_scheme . '-' . 'reign_mobile_menu_active_bg_color', $default_value_set[ $reign_color_scheme ]['reign_mobile_menu_active_bg_color'] );
	$reign_left_panel_bg_color                = get_theme_mod( $reign_color_scheme . '-' . 'reign_left_panel_bg_color', $default_value_set[ $reign_color_scheme ]['reign_left_panel_bg_color'] );
	$reign_left_panel_toggle_color            = get_theme_mod( $reign_color_scheme . '-' . 'reign_left_panel_toggle_color', $default_value_set[ $reign_color_scheme ]['reign_left_panel_toggle_color'] );
	$reign_left_panel_menu_font_color         = get_theme_mod( $reign_color_scheme . '-' . 'reign_left_panel_menu_font_color', $default_value_set[ $reign_color_scheme ]['reign_left_panel_menu_font_color'] );
	$reign_left_panel_menu_hover_color        = get_theme_mod( $reign_color_scheme . '-' . 'reign_left_panel_menu_hover_color', $default_value_set[ $reign_color_scheme ]['reign_left_panel_menu_hover_color'] );
	$reign_left_panel_menu_active_color       = get_theme_mod( $reign_color_scheme . '-' . 'reign_left_panel_menu_active_color', $default_value_set[ $reign_color_scheme ]['reign_left_panel_menu_active_color'] );
	$reign_left_panel_menu_bg_hover_color     = get_theme_mod( $reign_color_scheme . '-' . 'reign_left_panel_menu_bg_hover_color', $default_value_set[ $reign_color_scheme ]['reign_left_panel_menu_bg_hover_color'] );
	$reign_left_panel_menu_bg_active_color    = get_theme_mod( $reign_color_scheme . '-' . 'reign_left_panel_menu_bg_active_color', $default_value_set[ $reign_color_scheme ]['reign_left_panel_menu_bg_active_color'] );
	$reign_left_panel_menu_icon_active_color  = get_theme_mod( $reign_color_scheme . '-' . 'reign_left_panel_menu_icon_active_color', $default_value_set[ $reign_color_scheme ]['reign_left_panel_menu_icon_active_color'] );
	$reign_left_panel_tooltip_bg_color        = get_theme_mod( $reign_color_scheme . '-' . 'reign_left_panel_tooltip_bg_color', $default_value_set[ $reign_color_scheme ]['reign_left_panel_tooltip_bg_color'] );
	$reign_left_panel_tooltip_color           = get_theme_mod( $reign_color_scheme . '-' . 'reign_left_panel_tooltip_color', $default_value_set[ $reign_color_scheme ]['reign_left_panel_tooltip_color'] );
	$reign_site_body_bg_color                 = get_theme_mod( $reign_color_scheme . '-' . 'reign_site_body_bg_color', $default_value_set[ $reign_color_scheme ]['reign_site_body_bg_color'] );
	$reign_site_body_text_color               = get_theme_mod( $reign_color_scheme . '-' . 'reign_site_body_text_color', $default_value_set[ $reign_color_scheme ]['reign_site_body_text_color'] );
	$reign_site_alternate_text_color          = get_theme_mod( $reign_color_scheme . '-' . 'reign_site_alternate_text_color', $default_value_set[ $reign_color_scheme ]['reign_site_alternate_text_color'] );
	$reign_site_sections_bg_color             = get_theme_mod( $reign_color_scheme . '-' . 'reign_site_sections_bg_color', $default_value_set[ $reign_color_scheme ]['reign_site_sections_bg_color'] );
	$reign_site_secondary_bg_color            = get_theme_mod( $reign_color_scheme . '-' . 'reign_site_secondary_bg_color', $default_value_set[ $reign_color_scheme ]['reign_site_secondary_bg_color'] );
	$reign_colors_theme                       = get_theme_mod( $reign_color_scheme . '-' . 'reign_colors_theme', $default_value_set[ $reign_color_scheme ]['reign_colors_theme'] );
	$reign_site_headings_color                = get_theme_mod( $reign_color_scheme . '-' . 'reign_site_headings_color', $default_value_set[ $reign_color_scheme ]['reign_site_headings_color'] );
	$reign_site_link_color                    = get_theme_mod( $reign_color_scheme . '-' . 'reign_site_link_color', $default_value_set[ $reign_color_scheme ]['reign_site_link_color'] );
	$reign_site_link_hover_color              = get_theme_mod( $reign_color_scheme . '-' . 'reign_site_link_hover_color', $default_value_set[ $reign_color_scheme ]['reign_site_link_hover_color'] );
	$reign_accent_color                       = get_theme_mod( $reign_color_scheme . '-' . 'reign_accent_color', $default_value_set[ $reign_color_scheme ]['reign_accent_color'] );
	$reign_accent_hover_color                 = get_theme_mod( $reign_color_scheme . '-' . 'reign_accent_hover_color', $default_value_set[ $reign_color_scheme ]['reign_accent_hover_color'] );
	$reign_site_button_text_color             = get_theme_mod( $reign_color_scheme . '-' . 'reign_site_button_text_color', $default_value_set[ $reign_color_scheme ]['reign_site_button_text_color'] );
	$reign_site_button_text_hover_color       = get_theme_mod( $reign_color_scheme . '-' . 'reign_site_button_text_hover_color', $default_value_set[ $reign_color_scheme ]['reign_site_button_text_hover_color'] );
	$reign_site_button_bg_color               = get_theme_mod( $reign_color_scheme . '-' . 'reign_site_button_bg_color', $default_value_set[ $reign_color_scheme ]['reign_site_button_bg_color'] );
	$reign_site_button_bg_hover_color         = get_theme_mod( $reign_color_scheme . '-' . 'reign_site_button_bg_hover_color', $default_value_set[ $reign_color_scheme ]['reign_site_button_bg_hover_color'] );
	$reign_site_border_color                  = get_theme_mod( $reign_color_scheme . '-' . 'reign_site_border_color', $default_value_set[ $reign_color_scheme ]['reign_site_border_color'] );
	$reign_site_hr_color                      = get_theme_mod( $reign_color_scheme . '-' . 'reign_site_hr_color', $default_value_set[ $reign_color_scheme ]['reign_site_hr_color'] );
	$reign_footer_widget_area_bg_color        = get_theme_mod( $reign_color_scheme . '-' . 'reign_footer_widget_area_bg_color', $default_value_set[ $reign_color_scheme ]['reign_footer_widget_area_bg_color'] );
	$reign_footer_widget_title_color          = get_theme_mod( $reign_color_scheme . '-' . 'reign_footer_widget_title_color', $default_value_set[ $reign_color_scheme ]['reign_footer_widget_title_color'] );
	$reign_footer_widget_text_color           = get_theme_mod( $reign_color_scheme . '-' . 'reign_footer_widget_text_color', $default_value_set[ $reign_color_scheme ]['reign_footer_widget_text_color'] );
	$reign_footer_widget_link_color           = get_theme_mod( $reign_color_scheme . '-' . 'reign_footer_widget_link_color', $default_value_set[ $reign_color_scheme ]['reign_footer_widget_link_color'] );
	$reign_footer_widget_link_hover_color     = get_theme_mod( $reign_color_scheme . '-' . 'reign_footer_widget_link_hover_color', $default_value_set[ $reign_color_scheme ]['reign_footer_widget_link_hover_color'] );
	$reign_footer_copyright_bg_color          = get_theme_mod( $reign_color_scheme . '-' . 'reign_footer_copyright_bg_color', $default_value_set[ $reign_color_scheme ]['reign_footer_copyright_bg_color'] );
	$reign_footer_copyright_text_color        = get_theme_mod( $reign_color_scheme . '-' . 'reign_footer_copyright_text_color', $default_value_set[ $reign_color_scheme ]['reign_footer_copyright_text_color'] );
	$reign_footer_copyright_link_color        = get_theme_mod( $reign_color_scheme . '-' . 'reign_footer_copyright_link_color', $default_value_set[ $reign_color_scheme ]['reign_footer_copyright_link_color'] );
	$reign_footer_copyright_link_hover_color  = get_theme_mod( $reign_color_scheme . '-' . 'reign_footer_copyright_link_hover_color', $default_value_set[ $reign_color_scheme ]['reign_footer_copyright_link_hover_color'] );

	$reign_form_text_color              = get_theme_mod( $reign_color_scheme . '-' . 'reign_form_text_color', $default_value_set_form[ $reign_color_scheme ]['reign_form_text_color'] );
	$reign_form_background_color        = get_theme_mod( $reign_color_scheme . '-' . 'reign_form_background_color', $default_value_set_form[ $reign_color_scheme ]['reign_form_background_color'] );
	$reign_form_border_color            = get_theme_mod( $reign_color_scheme . '-' . 'reign_form_border_color', $default_value_set_form[ $reign_color_scheme ]['reign_form_border_color'] );
	$reign_form_placeholder_color       = get_theme_mod( $reign_color_scheme . '-' . 'reign_form_placeholder_color', $default_value_set_form[ $reign_color_scheme ]['reign_form_placeholder_color'] );
	$reign_form_focus_text_color        = get_theme_mod( $reign_color_scheme . '-' . 'reign_form_focus_text_color', $default_value_set_form[ $reign_color_scheme ]['reign_form_focus_text_color'] );
	$reign_form_focus_background_color  = get_theme_mod( $reign_color_scheme . '-' . 'reign_form_focus_background_color', $default_value_set_form[ $reign_color_scheme ]['reign_form_focus_background_color'] );
	$reign_form_focus_border_color      = get_theme_mod( $reign_color_scheme . '-' . 'reign_form_focus_border_color', $default_value_set_form[ $reign_color_scheme ]['reign_form_focus_border_color'] );
	$reign_form_focus_placeholder_color = get_theme_mod( $reign_color_scheme . '-' . 'reign_form_focus_placeholder_color', $default_value_set_form[ $reign_color_scheme ]['reign_form_focus_placeholder_color'] );

	$admin_colors = array(
		'--reign-header-topbar-bg-color'             => $reign_header_topbar_bg_color,
		'--reign-header-topbar-text-color'           => $reign_header_topbar_text_color,
		'--reign-header-topbar-text-hover-color'     => $reign_header_topbar_text_hover_color,
		'--reign-header-bg-color'                    => $reign_header_bg_color,
		'--reign-header-nav-bg-color'                => $reign_header_nav_bg_color,
		'--reign-title-tagline-typography'           => $reign_title_tagline_typography,
		'--reign-header-main-menu-font'              => $reign_header_main_menu_font,
		'--reign-header-main-menu-text-hover-color'  => $reign_header_main_menu_text_hover_color,
		'--reign-header-main-menu-text-active-color' => $reign_header_main_menu_text_active_color,
		'--reign-header-main-menu-bg-hover-color'    => $reign_header_main_menu_bg_hover_color,
		'--reign-header-main-menu-bg-active-color'   => $reign_header_main_menu_bg_active_color,
		'--reign-header-sub-menu-bg-color'           => $reign_header_sub_menu_bg_color,
		'--reign-header-sub-menu-font'               => $reign_header_sub_menu_font,
		'--reign-header-sub-menu-text-hover-color'   => $reign_header_sub_menu_text_hover_color,
		'--reign-header-sub-menu-bg-hover-color'     => $reign_header_sub_menu_bg_hover_color,
		'--reign-header-icon-color'                  => $reign_header_icon_color,
		'--reign-header-icon-hover-color'            => $reign_header_icon_hover_color,
		'--reign-mobile-menu-bg-color'               => $reign_mobile_menu_bg_color,
		'--reign-mobile-menu-color'                  => $reign_mobile_menu_color,
		'--reign-mobile-menu-hover-color'            => $reign_mobile_menu_hover_color,
		'--reign-mobile-menu-active-color'           => $reign_mobile_menu_active_color,
		'--reign-mobile-menu-active-bg-color'        => $reign_mobile_menu_active_bg_color,
		'--reign-left-panel-bg-color'                => $reign_left_panel_bg_color,
		'--reign-left-panel-toggle-color'            => $reign_left_panel_toggle_color,
		'--reign-left-panel-menu-font-color'         => $reign_left_panel_menu_font_color,
		'--reign-left-panel-menu-hover-color'        => $reign_left_panel_menu_hover_color,
		'--reign-left-panel-menu-active-color'       => $reign_left_panel_menu_active_color,
		'--reign-left-panel-menu-bg-hover-color'     => $reign_left_panel_menu_bg_hover_color,
		'--reign-left-panel-menu-bg-active-color'    => $reign_left_panel_menu_bg_active_color,
		'--reign-left-panel-menu-icon-active-color'  => $reign_left_panel_menu_icon_active_color,
		'--reign-left-panel-tooltip-bg-color'        => $reign_left_panel_tooltip_bg_color,
		'--reign-left-panel-tooltip-color'           => $reign_left_panel_tooltip_color,
		'--reign-site-body-bg-color'                 => $reign_site_body_bg_color,
		'--reign-site-body-text-color'               => $reign_site_body_text_color,
		'--reign-site-alternate-text-color'          => $reign_site_alternate_text_color,
		'--reign-site-sections-bg-color'             => $reign_site_sections_bg_color,
		'--reign-site-secondary-bg-color'            => $reign_site_secondary_bg_color,
		'--reign-colors-theme'                       => $reign_colors_theme,
		'--reign-site-headings-color'                => $reign_site_headings_color,
		'--reign-site-link-color'                    => $reign_site_link_color,
		'--reign-site-link-hover-color'              => $reign_site_link_hover_color,
		'--reign-accent-color'                       => $reign_accent_color,
		'--reign-accent-hover-color'                 => $reign_accent_hover_color,
		'--reign-site-button-text-color'             => $reign_site_button_text_color,
		'--reign-site-button-text-hover-color'       => $reign_site_button_text_hover_color,
		'--reign-site-button-bg-color'               => $reign_site_button_bg_color,
		'--reign-site-button-bg-hover-color'         => $reign_site_button_bg_hover_color,
		'--reign-site-border-color'                  => $reign_site_border_color,
		'--reign-site-hr-color'                      => $reign_site_hr_color,
		'--reign-footer-widget-area-bg-color'        => $reign_footer_widget_area_bg_color,
		'--reign-footer-widget-title-color'          => $reign_footer_widget_title_color,
		'--reign-footer-widget-text-color'           => $reign_footer_widget_text_color,
		'--reign-footer-widget-link-color'           => $reign_footer_widget_link_color,
		'--reign-footer-widget-link-hover-color'     => $reign_footer_widget_link_hover_color,
		'--reign-footer-copyright-bg-color'          => $reign_footer_copyright_bg_color,
		'--reign-footer-copyright-text-color'        => $reign_footer_copyright_text_color,
		'--reign-footer-copyright-link-color'        => $reign_footer_copyright_link_color,
		'--reign-footer-copyright-link-hover-color'  => $reign_footer_copyright_link_hover_color,

		'--reign-form-text-color'                    => $reign_form_text_color,
		'--reign-form-background-color'              => $reign_form_background_color,
		'--reign-form-border-color'                  => $reign_form_border_color,
		'--reign-form-placeholder-color'             => $reign_form_placeholder_color,
		'--reign-form-focus-text-color'              => $reign_form_focus_text_color,
		'--reign-form-focus-background-color'        => $reign_form_focus_background_color,
		'--reign-form-focus-border-color'            => $reign_form_focus_border_color,
		'--reign-form-focus-placeholder-color'       => $reign_form_focus_placeholder_color,
	);

	$fallback_colors = reign_color_scheme_set();

	$color_string = '';
	foreach ( $colors as $key => $property ) {
		$fallback_color = isset( $fallback_colors[ $key ] ) ? $fallback_colors[ $key ] : '';
		$color          = get_option( $key, $fallback_color );
		$color_rgb      = hex2rgb( $color );

		if ( isset( $admin_colors[ $property ] ) ) {
			$color     = $admin_colors[ $property ];
			$color_rgb = hex2rgb( $admin_colors[ $property ] );
		}

		if ( $color ) {
			$color_string .= $property . ':' . $color . ';';
		}

		if ( $color_rgb ) {
			$color_string .= $property . '-rgb:' . $color_rgb . ';';
		}
	}

	return ':root{' . $color_string . '}';
}

/**
 * Load dark color palette
 *
 * @since 6.9.2
 * @return string
 */
function load_color_dark_palette() {
	// Customizer colors.
	$reign_dark_mode_option        = get_theme_mod( 'reign_dark_mode_option' );
	$reign_custom_dark_mode_option = get_theme_mod( 'reign_custom_dark_mode_option' );

	if ( true === $reign_dark_mode_option && true === $reign_custom_dark_mode_option ) {
		$colors = array(
			'reign_header_topbar_bg_color'             => '--reign-header-topbar-bg-color',
			'reign_header_topbar_text_color'           => '--reign-header-topbar-text-color',
			'reign_header_topbar_text_hover_color'     => '--reign-header-topbar-text-hover-color',
			'reign_header_bg_color'                    => '--reign-header-bg-color',
			'reign_header_nav_bg_color'                => '--reign-header-nav-bg-color',
			'reign_title_tagline_typography'           => '--reign-title-tagline-typography',
			'reign_header_main_menu_font'              => '--reign-header-main-menu-font',
			'reign_header_main_menu_text_hover_color'  => '--reign-header-main-menu-text-hover-color',
			'reign_header_main_menu_text_active_color' => '--reign-header-main-menu-text-active-color',
			'reign_header_main_menu_bg_hover_color'    => '--reign-header-main-menu-bg-hover-color',
			'reign_header_main_menu_bg_active_color'   => '--reign-header-main-menu-bg-active-color',
			'reign_header_sub_menu_bg_color'           => '--reign-header-sub-menu-bg-color',
			'reign_header_sub_menu_font'               => '--reign-header-sub-menu-font',
			'reign_header_sub_menu_text_hover_color'   => '--reign-header-sub-menu-text-hover-color',
			'reign_header_sub_menu_bg_hover_color'     => '--reign-header-sub-menu-bg-hover-color',
			'reign_header_icon_color'                  => '--reign-header-icon-color',
			'reign_header_icon_hover_color'            => '--reign-header-icon-hover-color',
			'reign_mobile_menu_bg_color'               => '--reign-mobile-menu-bg-color',
			'reign_mobile_menu_color'                  => '--reign-mobile-menu-color',
			'reign_mobile_menu_hover_color'            => '--reign-mobile-menu-hover-color',
			'reign_mobile_menu_active_color'           => '--reign-mobile-menu-active-color',
			'reign_mobile_menu_active_bg_color'        => '--reign-mobile-menu-active-bg-color',
			'reign_left_panel_bg_color'                => '--reign-left-panel-bg-color',
			'reign_left_panel_toggle_color'            => '--reign-left-panel-toggle-color',
			'reign_left_panel_menu_font_color'         => '--reign-left-panel-menu-font-color',
			'reign_left_panel_menu_hover_color'        => '--reign-left-panel-menu-hover-color',
			'reign_left_panel_menu_active_color'       => '--reign-left-panel-menu-active-color',
			'reign_left_panel_menu_bg_hover_color'     => '--reign-left-panel-menu-bg-hover-color',
			'reign_left_panel_menu_bg_active_color'    => '--reign-left-panel-menu-bg-active-color',
			'reign_left_panel_menu_icon_active_color'  => '--reign-left-panel-menu-icon-active-color',
			'reign_left_panel_tooltip_bg_color'        => '--reign-left-panel-tooltip-bg-color',
			'reign_left_panel_tooltip_color'           => '--reign-left-panel-tooltip-color',
			'reign_site_body_bg_color'                 => '--reign-site-body-bg-color',
			'reign_site_body_text_color'               => '--reign-site-body-text-color',
			'reign_site_alternate_text_color'          => '--reign-site-alternate-text-color',
			'reign_site_sections_bg_color'             => '--reign-site-sections-bg-color',
			'reign_site_secondary_bg_color'            => '--reign-site-secondary-bg-color',
			'reign_colors_theme'                       => '--reign-colors-theme',
			'reign_site_headings_color'                => '--reign-site-headings-color',
			'reign_site_link_color'                    => '--reign-site-link-color',
			'reign_site_link_hover_color'              => '--reign-site-link-hover-color',
			'reign_accent_color'                       => '--reign-accent-color',
			'reign_accent_hover_color'                 => '--reign-accent-hover-color',
			'reign_site_button_text_color'             => '--reign-site-button-text-color',
			'reign_site_button_text_hover_color'       => '--reign-site-button-text-hover-color',
			'reign_site_button_bg_color'               => '--reign-site-button-bg-color',
			'reign_site_button_bg_hover_color'         => '--reign-site-button-bg-hover-color',
			'reign_site_border_color'                  => '--reign-site-border-color',
			'reign_site_hr_color'                      => '--reign-site-hr-color',
			'reign_footer_widget_area_bg_color'        => '--reign-footer-widget-area-bg-color',
			'reign_footer_widget_title_color'          => '--reign-footer-widget-title-color',
			'reign_footer_widget_text_color'           => '--reign-footer-widget-text-color',
			'reign_footer_widget_link_color'           => '--reign-footer-widget-link-color',
			'reign_footer_widget_link_hover_color'     => '--reign-footer-widget-link-hover-color',
			'reign_footer_copyright_bg_color'          => '--reign-footer-copyright-bg-color',
			'reign_footer_copyright_text_color'        => '--reign-footer-copyright-text-color',
			'reign_footer_copyright_link_color'        => '--reign-footer-copyright-link-color',
			'reign_footer_copyright_link_hover_color'  => '--reign-footer-copyright-link-hover-color',

			'reign_form_text_color'                    => '--reign-form-text-color',
			'reign_form_background_color'              => '--reign-form-background-color',
			'reign_form_border_color'                  => '--reign-form-border-color',
			'reign_form_placeholder_color'             => '--reign-form-placeholder-color',
			'reign_form_focus_text_color'              => '--reign-form-focus-text-color',
			'reign_form_focus_background_color'        => '--reign-form-focus-background-color',
			'reign_form_focus_border_color'            => '--reign-form-focus-border-color',
			'reign_form_focus_placeholder_color'       => '--reign-form-focus-placeholder-color',
		);

		$reign_header_topbar_bg_color             = get_theme_mod( 'reign_dark-reign_header_topbar_bg_color' );
		$reign_header_topbar_text_color           = get_theme_mod( 'reign_dark-reign_header_topbar_text_color' );
		$reign_header_topbar_text_hover_color     = get_theme_mod( 'reign_dark-reign_header_topbar_text_hover_color' );
		$reign_header_bg_color                    = get_theme_mod( 'reign_dark-reign_header_bg_color' );
		$reign_header_nav_bg_color                = get_theme_mod( 'reign_dark-reign_header_nav_bg_color' );
		$reign_title_tagline_typography           = get_theme_mod( 'reign_dark-reign_title_tagline_typography' );
		$reign_header_main_menu_font              = get_theme_mod( 'reign_dark-reign_header_main_menu_font' );
		$reign_header_main_menu_text_hover_color  = get_theme_mod( 'reign_dark-reign_header_main_menu_text_hover_color' );
		$reign_header_main_menu_text_active_color = get_theme_mod( 'reign_dark-reign_header_main_menu_text_active_color' );
		$reign_header_main_menu_bg_hover_color    = get_theme_mod( 'reign_dark-reign_header_main_menu_bg_hover_color' );
		$reign_header_main_menu_bg_active_color   = get_theme_mod( 'reign_dark-reign_header_main_menu_bg_active_color' );
		$reign_header_sub_menu_bg_color           = get_theme_mod( 'reign_dark-reign_header_sub_menu_bg_color' );
		$reign_header_sub_menu_font               = get_theme_mod( 'reign_dark-reign_header_sub_menu_font' );
		$reign_header_sub_menu_text_hover_color   = get_theme_mod( 'reign_dark-reign_header_sub_menu_text_hover_color' );
		$reign_header_sub_menu_bg_hover_color     = get_theme_mod( 'reign_dark-reign_header_sub_menu_bg_hover_color' );
		$reign_header_icon_color                  = get_theme_mod( 'reign_dark-reign_header_icon_color' );
		$reign_header_icon_hover_color            = get_theme_mod( 'reign_dark-reign_header_icon_hover_color' );
		$reign_mobile_menu_bg_color               = get_theme_mod( 'reign_dark-reign_mobile_menu_bg_color' );
		$reign_mobile_menu_color                  = get_theme_mod( 'reign_dark-reign_mobile_menu_color' );
		$reign_mobile_menu_hover_color            = get_theme_mod( 'reign_dark-reign_mobile_menu_hover_color' );
		$reign_mobile_menu_active_color           = get_theme_mod( 'reign_dark-reign_mobile_menu_active_color' );
		$reign_mobile_menu_active_bg_color        = get_theme_mod( 'reign_dark-reign_mobile_menu_active_bg_color' );
		$reign_left_panel_bg_color                = get_theme_mod( 'reign_dark-reign_left_panel_bg_color' );
		$reign_left_panel_toggle_color            = get_theme_mod( 'reign_dark-reign_left_panel_toggle_color' );
		$reign_left_panel_menu_font_color         = get_theme_mod( 'reign_dark-reign_left_panel_menu_font_color' );
		$reign_left_panel_menu_hover_color        = get_theme_mod( 'reign_dark-reign_left_panel_menu_hover_color' );
		$reign_left_panel_menu_active_color       = get_theme_mod( 'reign_dark-reign_left_panel_menu_active_color' );
		$reign_left_panel_menu_bg_hover_color     = get_theme_mod( 'reign_dark-reign_left_panel_menu_bg_hover_color' );
		$reign_left_panel_menu_bg_active_color    = get_theme_mod( 'reign_dark-reign_left_panel_menu_bg_active_color' );
		$reign_left_panel_menu_icon_active_color  = get_theme_mod( 'reign_dark-reign_left_panel_menu_icon_active_color' );
		$reign_left_panel_tooltip_bg_color        = get_theme_mod( 'reign_dark-reign_left_panel_tooltip_bg_color' );
		$reign_left_panel_tooltip_color           = get_theme_mod( 'reign_dark-reign_left_panel_tooltip_color' );
		$reign_site_body_bg_color                 = get_theme_mod( 'reign_dark-reign_site_body_bg_color' );
		$reign_site_body_text_color               = get_theme_mod( 'reign_dark-reign_site_body_text_color' );
		$reign_site_alternate_text_color          = get_theme_mod( 'reign_dark-reign_site_alternate_text_color' );
		$reign_site_sections_bg_color             = get_theme_mod( 'reign_dark-reign_site_sections_bg_color' );
		$reign_site_secondary_bg_color            = get_theme_mod( 'reign_dark-reign_site_secondary_bg_color' );
		$reign_colors_theme                       = get_theme_mod( 'reign_dark-reign_colors_theme' );
		$reign_site_headings_color                = get_theme_mod( 'reign_dark-reign_site_headings_color' );
		$reign_site_link_color                    = get_theme_mod( 'reign_dark-reign_site_link_color' );
		$reign_site_link_hover_color              = get_theme_mod( 'reign_dark-reign_site_link_hover_color' );
		$reign_accent_color                       = get_theme_mod( 'reign_dark-reign_accent_color' );
		$reign_accent_hover_color                 = get_theme_mod( 'reign_dark-reign_accent_hover_color' );
		$reign_site_button_text_color             = get_theme_mod( 'reign_dark-reign_site_button_text_color' );
		$reign_site_button_text_hover_color       = get_theme_mod( 'reign_dark-reign_site_button_text_hover_color' );
		$reign_site_button_bg_color               = get_theme_mod( 'reign_dark-reign_site_button_bg_color' );
		$reign_site_button_bg_hover_color         = get_theme_mod( 'reign_dark-reign_site_button_bg_hover_color' );
		$reign_site_border_color                  = get_theme_mod( 'reign_dark-reign_site_border_color' );
		$reign_site_hr_color                      = get_theme_mod( 'reign_dark-reign_site_hr_color' );
		$reign_footer_widget_area_bg_color        = get_theme_mod( 'reign_dark-reign_footer_widget_area_bg_color' );
		$reign_footer_widget_title_color          = get_theme_mod( 'reign_dark-reign_footer_widget_title_color' );
		$reign_footer_widget_text_color           = get_theme_mod( 'reign_dark-reign_footer_widget_text_color' );
		$reign_footer_widget_link_color           = get_theme_mod( 'reign_dark-reign_footer_widget_link_color' );
		$reign_footer_widget_link_hover_color     = get_theme_mod( 'reign_dark-reign_footer_widget_link_hover_color' );
		$reign_footer_copyright_bg_color          = get_theme_mod( 'reign_dark-reign_footer_copyright_bg_color' );
		$reign_footer_copyright_text_color        = get_theme_mod( 'reign_dark-reign_footer_copyright_text_color' );
		$reign_footer_copyright_link_color        = get_theme_mod( 'reign_dark-reign_footer_copyright_link_color' );
		$reign_footer_copyright_link_hover_color  = get_theme_mod( 'reign_dark-reign_footer_copyright_link_hover_color' );

		$reign_form_text_color              = get_theme_mod( 'reign_dark-reign_form_text_color' );
		$reign_form_background_color        = get_theme_mod( 'reign_dark-reign_form_background_color' );
		$reign_form_border_color            = get_theme_mod( 'reign_dark-reign_form_border_color' );
		$reign_form_placeholder_color       = get_theme_mod( 'reign_dark-reign_form_placeholder_color' );
		$reign_form_focus_text_color        = get_theme_mod( 'reign_dark-reign_form_focus_text_color' );
		$reign_form_focus_background_color  = get_theme_mod( 'reign_dark-reign_form_focus_background_color' );
		$reign_form_focus_border_color      = get_theme_mod( 'reign_dark-reign_form_focus_border_color' );
		$reign_form_focus_placeholder_color = get_theme_mod( 'reign_dark-reign_form_focus_placeholder_color' );

		$admin_colors = array(
			'--reign-header-topbar-bg-color'             => $reign_header_topbar_bg_color,
			'--reign-header-topbar-text-color'           => $reign_header_topbar_text_color,
			'--reign-header-topbar-text-hover-color'     => $reign_header_topbar_text_hover_color,
			'--reign-header-bg-color'                    => $reign_header_bg_color,
			'--reign-header-nav-bg-color'                => $reign_header_nav_bg_color,
			'--reign-title-tagline-typography'           => $reign_title_tagline_typography,
			'--reign-header-main-menu-font'              => $reign_header_main_menu_font,
			'--reign-header-main-menu-text-hover-color'  => $reign_header_main_menu_text_hover_color,
			'--reign-header-main-menu-text-active-color' => $reign_header_main_menu_text_active_color,
			'--reign-header-main-menu-bg-hover-color'    => $reign_header_main_menu_bg_hover_color,
			'--reign-header-main-menu-bg-active-color'   => $reign_header_main_menu_bg_active_color,
			'--reign-header-sub-menu-bg-color'           => $reign_header_sub_menu_bg_color,
			'--reign-header-sub-menu-font'               => $reign_header_sub_menu_font,
			'--reign-header-sub-menu-text-hover-color'   => $reign_header_sub_menu_text_hover_color,
			'--reign-header-sub-menu-bg-hover-color'     => $reign_header_sub_menu_bg_hover_color,
			'--reign-header-icon-color'                  => $reign_header_icon_color,
			'--reign-header-icon-hover-color'            => $reign_header_icon_hover_color,
			'--reign-mobile-menu-bg-color'               => $reign_mobile_menu_bg_color,
			'--reign-mobile-menu-color'                  => $reign_mobile_menu_color,
			'--reign-mobile-menu-hover-color'            => $reign_mobile_menu_hover_color,
			'--reign-mobile-menu-active-color'           => $reign_mobile_menu_active_color,
			'--reign-mobile-menu-active-bg-color'        => $reign_mobile_menu_active_bg_color,
			'--reign-left-panel-bg-color'                => $reign_left_panel_bg_color,
			'--reign-left-panel-toggle-color'            => $reign_left_panel_toggle_color,
			'--reign-left-panel-menu-font-color'         => $reign_left_panel_menu_font_color,
			'--reign-left-panel-menu-hover-color'        => $reign_left_panel_menu_hover_color,
			'--reign-left-panel-menu-active-color'       => $reign_left_panel_menu_active_color,
			'--reign-left-panel-menu-bg-hover-color'     => $reign_left_panel_menu_bg_hover_color,
			'--reign-left-panel-menu-bg-active-color'    => $reign_left_panel_menu_bg_active_color,
			'--reign-left-panel-menu-icon-active-color'  => $reign_left_panel_menu_icon_active_color,
			'--reign-left-panel-tooltip-bg-color'        => $reign_left_panel_tooltip_bg_color,
			'--reign-left-panel-tooltip-color'           => $reign_left_panel_tooltip_color,
			'--reign-site-body-bg-color'                 => $reign_site_body_bg_color,
			'--reign-site-body-text-color'               => $reign_site_body_text_color,
			'--reign-site-alternate-text-color'          => $reign_site_alternate_text_color,
			'--reign-site-sections-bg-color'             => $reign_site_sections_bg_color,
			'--reign-site-secondary-bg-color'            => $reign_site_secondary_bg_color,
			'--reign-colors-theme'                       => $reign_colors_theme,
			'--reign-site-headings-color'                => $reign_site_headings_color,
			'--reign-site-link-color'                    => $reign_site_link_color,
			'--reign-site-link-hover-color'              => $reign_site_link_hover_color,
			'--reign-accent-color'                       => $reign_accent_color,
			'--reign-accent-hover-color'                 => $reign_accent_hover_color,
			'--reign-site-button-text-color'             => $reign_site_button_text_color,
			'--reign-site-button-text-hover-color'       => $reign_site_button_text_hover_color,
			'--reign-site-button-bg-color'               => $reign_site_button_bg_color,
			'--reign-site-button-bg-hover-color'         => $reign_site_button_bg_hover_color,
			'--reign-site-border-color'                  => $reign_site_border_color,
			'--reign-site-hr-color'                      => $reign_site_hr_color,
			'--reign-footer-widget-area-bg-color'        => $reign_footer_widget_area_bg_color,
			'--reign-footer-widget-title-color'          => $reign_footer_widget_title_color,
			'--reign-footer-widget-text-color'           => $reign_footer_widget_text_color,
			'--reign-footer-widget-link-color'           => $reign_footer_widget_link_color,
			'--reign-footer-widget-link-hover-color'     => $reign_footer_widget_link_hover_color,
			'--reign-footer-copyright-bg-color'          => $reign_footer_copyright_bg_color,
			'--reign-footer-copyright-text-color'        => $reign_footer_copyright_text_color,
			'--reign-footer-copyright-link-color'        => $reign_footer_copyright_link_color,
			'--reign-footer-copyright-link-hover-color'  => $reign_footer_copyright_link_hover_color,

			'--reign-form-text-color'                    => $reign_form_text_color,
			'--reign-form-background-color'              => $reign_form_background_color,
			'--reign-form-border-color'                  => $reign_form_border_color,
			'--reign-form-placeholder-color'             => $reign_form_placeholder_color,
			'--reign-form-focus-text-color'              => $reign_form_focus_text_color,
			'--reign-form-focus-background-color'        => $reign_form_focus_background_color,
			'--reign-form-focus-border-color'            => $reign_form_focus_border_color,
			'--reign-form-focus-placeholder-color'       => $reign_form_focus_placeholder_color,
		);

		$fallback_colors = reign_color_scheme_set();

		$color_string = '';
		foreach ( $colors as $key => $property ) {
			$fallback_color = isset( $fallback_colors[ $key ] ) ? $fallback_colors[ $key ] : '';
			$color          = get_option( $key, $fallback_color );
			$color_rgb      = hex2rgb( $color );

			if ( isset( $admin_colors[ $property ] ) ) {
				$color     = $admin_colors[ $property ];
				$color_rgb = hex2rgb( $admin_colors[ $property ] );
			}

			if ( $color ) {
				$color_string .= $property . ':' . $color . '!important;';
			}

			if ( $color_rgb ) {
				$color_string .= $property . '-rgb:' . $color_rgb . '!important;';
			}
		}

		return '.dark-mode{' . $color_string . '}';
	}
}

/**
 * Load global border radius
 *
 * @since 6.9.2
 * @return string
 */
function load_border_radius() {
	$global_radius = array(
		'reign_global_border_radius_option' => '--reign-global-border-radius',
		'reign_global_button_radius'        => '--reign-global-button-radius',
		'reign_global_form_radius'          => '--reign-global-form-radius',
	);

	// Global Border Radius.
	$reign_global_border_radius_option = get_theme_mod( 'reign_global_border_radius_option', '8px' );
	$reign_global_button_radius        = get_theme_mod( 'reign_global_button_radius', '6px' );
	$reign_global_form_radius          = get_theme_mod( 'reign_global_form_radius', '6px' );

	$admin_radius = array(
		'--reign-global-border-radius' => $reign_global_border_radius_option,
		'--reign-global-button-radius' => $reign_global_button_radius,
		'--reign-global-form-radius'   => $reign_global_form_radius,
	);

	$fallback_border_radius = array(
		'reign_global_border_radius_option' => '8px',
		'reign_global_button_radius'        => '6px',
		'reign_global_form_radius'          => '6px',
	);

	$radius_string = '';
	foreach ( $global_radius as $key => $property ) {
		$fallback_radius = isset( $fallback_border_radius[ $key ] ) ? $fallback_border_radius[ $key ] : '3px';
		$border_radius   = get_option( $key, $fallback_radius );

		if ( isset( $admin_radius[ $property ] ) ) {
			$border_radius = $admin_radius[ $property ];
		}

		if ( $border_radius ) {
			$radius_string .= $property . ':' . $border_radius . ';';
		}
	}

	return ':root{' . $radius_string . '}';
}
