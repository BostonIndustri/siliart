<?php

if ( ! function_exists( 'reign_body_classes' ) ) {

	/**
	 * Adds custom classes to the array of body classes.
	 *
	 * @param array $classes Classes for the body element.
	 * @return array
	 */
	function reign_body_classes( $classes ) {
		// Reign theme class.
		$classes[] = 'wb-reign-theme';

		// Adds a class of group-blog to blogs with more than 1 published author.
		if ( is_multi_author() ) {
			$classes[] = 'group-blog';
		}

		// Adds a class of hfeed to non-singular pages.
		if ( ! is_singular() ) {
			$classes[] = 'hfeed';
		}

		$reign_header_topbar_enable = get_theme_mod( 'reign_header_topbar_enable', '1' );
		if ( ! empty( $reign_header_topbar_enable ) ) {
			$classes[] = 'topbar-enable';
		} else {
			$classes[] = 'topbar-disable';
		}

		// More Menu.
		$more_menu_enable = get_theme_mod( 'reign_header_main_menu_more_enable', true );
		if ( ! empty( $more_menu_enable ) ) {
			$classes[] = 'more-menu-enable';
		}

		// Scroll Up.
		$reign_scrollup_position = get_theme_mod( 'reign_scrollup_position', 'right' );
		if ( $reign_scrollup_position === 'left' ) {
			$classes[] = 'scrollup-position-left';
		} else {
			$classes[] = 'scrollup-position-right';
		}

		// Added body class for dark scheme.
		if ( 'reign_dark' == get_theme_mod( 'reign_color_scheme' ) ) {
			$classes[] = 'dark-scheme';
		}

		// Added body class if mediapress plugin active.
		if ( class_exists( 'MediaPress' ) ) {
			$classes[] = 'reign-mediapress';
		}

		// Left Panel Position.
		$reign_left_panel_position = get_theme_mod( 'reign_left_panel_position', 'left' );
		if ( $reign_left_panel_position === 'right' ) {
			$classes[] = 'panel-position-right';
		}

		// Mobile Header Icons Set.
		$reign_mobile_default_icons_set = reign_mobile_header_default_icons_set();
		$reign_mobile_header_icons_set  = get_theme_mod( 'reign_mobile_header_icons_set', $reign_mobile_default_icons_set );
		if ( ! empty( $reign_mobile_header_icons_set ) ) {
			$classes[] = 'reign-mobile-header-icons-enable';
		}

		/**
		 * Manage header sticky or not.
		 */
		$reign_header_sticky_menu_enable = get_theme_mod( 'reign_header_sticky_menu_enable', true );
		if ( $reign_header_sticky_menu_enable ) {
			$classes[] = 'reign-sticky-header';
		}

		/**
		 * Manage sidebar sticky or not.
		 *
		 * @since 2.0.2
		 */
		$reign_sticky_sidebar = get_theme_mod( 'reign_sticky_sidebar', true );
		if ( $reign_sticky_sidebar ) {
			$classes[] = 'reign-sticky-sidebar';
		}

		// Mobile Header Classes.
		$reign_mobile_header_layout = get_theme_mod( 'reign_mobile_header_layout', 'header-v1' );
		if ( 'header-v2' === $reign_mobile_header_layout ) {
			$classes[] = 'header-v2';
		} elseif ( 'header-v3' === $reign_mobile_header_layout ) {
			$classes[] = 'header-v3';
		} else {
			$classes[] = 'header-v1';
		}

		// Body Class for bb platform.
		if ( function_exists( 'buddypress' ) && isset( buddypress()->buddyboss ) ) {
			$classes[] = 'reign-bb';
		}

		// Body Class for WooCommerce product layout.
		if ( class_exists( 'WooCommerce' ) ) {
			$reign_woo_product_layout = get_theme_mod( 'reign_woo_product_layout', 'woo_product_default' );
			if ( 'woo_product_layout1' === $reign_woo_product_layout ) {
				$classes[] = 'woo-product-layout1';
			} elseif ( 'woo_product_layout2' === $reign_woo_product_layout ) {
				$classes[] = 'woo-product-layout2';
			} elseif ( 'woo_product_layout3' === $reign_woo_product_layout ) {
				$classes[] = 'woo-product-layout3';
			} elseif ( 'woo_product_layout4' === $reign_woo_product_layout ) {
				$classes[] = 'woo-product-layout4';
			} else {
				$classes[] = 'woo-product-default';
			}
		}

		// Body Class for WooCommerce single product layout.
		if ( class_exists( 'WooCommerce' ) && is_product() ) {
			$reign_woo_single_product_layout = get_theme_mod( 'reign_woo_single_product_layout', 'woo_single_product_default' );
			if ( 'woo_single_product_layout1' === $reign_woo_single_product_layout ) {
				$classes[] = 'woo-single-product-layout1';
			} elseif ( 'woo_single_product_layout2' === $reign_woo_single_product_layout ) {
				$classes[] = 'woo-single-product-layout2';
			} else {
				$classes[] = 'woo-single-product-default';
			}
		}

		// Body Class for register page.
		$register_split_view = get_theme_mod( 'register_split_view' );
		if ( $register_split_view && function_exists( 'bp_is_register_page' ) && bp_is_register_page() && ! is_singular( 'memberpressproduct' ) ) {
			$classes[] = 'login-split-page rg-login';
		} elseif ( $register_split_view && function_exists( 'bp_is_activation_page' ) && bp_is_activation_page() && ! is_singular( 'memberpressproduct' ) ) {
			$classes[] = 'login-split-page rg-login';
		}

		return $classes;
	}

	add_filter( 'body_class', 'reign_body_classes' );
}

if ( ! function_exists( 'reign_pingback_header' ) ) {

	/**
	 * Add a pingback url auto-discovery header for singularly identifiable articles.
	 */
	function reign_pingback_header() {
		if ( is_singular() && pings_open() ) {
			echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '" />';
		}
	}

	add_action( 'wp_head', 'reign_pingback_header' );
}

if ( ! function_exists( 'reign_viewport_meta' ) ) {

	/**
	 * Add a viewport meta
	 */
	function reign_viewport_meta() {
		echo '<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">';
	}

	add_action( 'wp_head', 'reign_viewport_meta' );
}

/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Reign
 */
function reign_custom_post_navigation() {

	global $wp_query;

	// Don't print empty markup if there's only one page.
	if ( $wp_query->max_num_pages > 1 ) {
		// Make sure the nav element has an aria-label attribute: fallback to the screen reader text.
		if ( ! empty( $args['screen_reader_text'] ) && empty( $args['aria_label'] ) ) {
			$args['aria_label'] = $args['screen_reader_text'];
		}

		$args = wp_parse_args(
			array(
				'mid_size'           => 1,
				'prev_text'          => esc_html__( 'Previous', 'reign' ),
				'next_text'          => esc_html__( 'Next', 'reign' ),
				'screen_reader_text' => esc_html__( 'Posts navigation', 'reign' ),
				'aria_label'         => esc_html__( 'Posts', 'reign' ),
			)
		);

		// Make sure we get a string back. Plain is the next best thing.
		if ( isset( $args['type'] ) && 'array' == $args['type'] ) {
			$args['type'] = 'plain';
		}

		// Set up paginated links.
		$links            = paginate_links( $args );
		$blog_list_layout = get_theme_mod( 'reign_blog_list_pagination' );

		if ( ( $blog_list_layout != '' && $blog_list_layout == 'reign_blog_infinite_scroll_pagination' ) && ( is_archive() || is_author() || is_home() ) ) {
			?>
			<nav class="reign_load_more">
				<?php
					$next_posts_link = get_next_posts_link( esc_html__( 'Load More', 'reign' ) );
					echo $next_posts_link;
				?>
			</nav>
			<?php if ( $next_posts_link != '' ) : ?>
				<a class='infinite-scroll-request infinite-loader read-more button'><?php esc_html_e( 'Loading...', 'reign' ); ?></a>			
				<div class="page-load-status">
					<p class="infinite-scroll-error"><?php esc_html__( 'No more pages to load', 'reign' ); ?></p>
				</div>			
				<?php
			endif;
		} elseif ( $links ) {

				echo '<nav class="navigation posts-navigation rg-posts-navigation" role="navigation">';
				echo '<h2 class="screen-reader-text">Posts navigation</h2>';
				echo '<div class="nav-links">' . $links . '</div>';
				echo '</nav>';
		}
	}
}

function reign_custom_post_navigation_link( $page = false, $class = '', $label = '' ) {

	if ( ! $page ) {
		return;
	}

	$classes = array( 'page-numbers' );
	if ( ! empty( $class ) ) {
		$classes[] = $class;
	}
	$classes = array_map( 'sanitize_html_class', $classes );

	$label = $label ? $label : $page;
	$link  = esc_url_raw( get_pagenum_link( $page ) );

	return '<a class="' . join( ' ', $classes ) . '" href="' . $link . '">' . $label . '</a>';
}

if ( ! function_exists( 'reign_posted_on' ) ) :

	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 */
	function reign_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf(
			$time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
			esc_html_x( 'Posted on %s', 'post date', 'reign' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		$byline = sprintf(
			esc_html_x( 'by %s', 'post author', 'reign' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<span class="posted-on">' . $posted_on . '</span><span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.
	}

endif;


if ( ! function_exists( 'reign_entry_list_footer' ) ) {
	/**
	 * Prints HTML with meta information.
	 */
	function reign_entry_list_footer() {

		if ( is_home() || ! is_post_type_hierarchical( get_post_type() ) ) {

			$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
			if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
				$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
			}

			$time_string = sprintf(
				$time_string,
				esc_attr( get_the_date( 'c' ) ),
				esc_html( get_the_date() ),
				esc_attr( get_the_modified_date( 'c' ) ),
				esc_html( get_the_modified_date() )
			);

			$posted_on = sprintf(
				esc_html_x( '%s', 'post date', 'reign' ),
				'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
			);
			/** Co-author support added * */
			if ( class_exists( 'CoAuthors_Plus' ) ) {
				$coauthors = get_coauthors();
				foreach ( $coauthors as $coauthor ) :
					$author_name = get_the_author_meta( 'first_name', $coauthor->ID ) . ' ' . get_the_author_meta( 'last_name', $coauthor->ID );
					$byline      = sprintf(
						esc_html_x( '%s', 'post author', 'reign' ),
						'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( $coauthor->ID ) ) . '">' . esc_html( $author_name ) . '</a></span>'
					);

					echo '<span class="byline"><i class="fa fa-user-circle"></i> ' . $byline . '<span class="posted-on">' . $posted_on . '</span></span>'; // WPCS: XSS OK
				endforeach;
			} else {

				$avatar = '<i class="fa fa-user-circle"></i>';
				if ( function_exists( 'get_avatar' ) ) {
					$avatar = sprintf(
						'<a href="%1$s" rel="bookmark">%2$s</a>',
						esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
						get_avatar( get_the_author_meta( 'email' ), 55 )
					);
				}

				$byline = sprintf(
					esc_html_x( '%s', 'post author', 'reign' ),
					'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
				);

				echo '<span class="byline">' . $avatar . $byline . '<span class="posted-on">' . $posted_on . '</span></span>'; // WPCS: XSS OK
			}

			// echo '<span class="posted-on"><!--<i class="rg-calendar"></i>-->'. $posted_on . '</span>';

			/* list of categories assigned to post */
			$output          = '';
			$categories_list = get_the_category_list( __( ' ', 'reign' ) );
			if ( $categories_list ) {
				$categories = sprintf(
					esc_html( '%1$s' ),
					$categories_list
				);
				$output    .= '<span class="cat-links"><!--<i class="rg-category"></i>-->' . $categories . '</span>';
			}
			echo apply_filters( 'reign_post_categories', $output );

			/*
			list of tags assigned to post */
			// $tags_list    = get_the_term_list( get_the_ID(), 'post_tag', $before      = '', $sep      = ', ', $after      = '' );
			// if ( $tags_list ) {
			// $tags_list = '<span class="tag-links"><!-- <i class="rg-tag"></i> -->' . $tags_list . '</span>';
			// }
			// echo apply_filters( 'reign_post_tags', $tags_list );

			do_action( 'reign_render_additional_post_meta' );
		}
	}
}

if ( ! function_exists( 'reign_entry_footer' ) ) :

	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function reign_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'reign' ) );
			if ( $categories_list && reign_categorized_blog() ) {
				printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'reign' ) . '</span>', $categories_list ); // WPCS: XSS OK.
			}

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html__( ', ', 'reign' ) );
			if ( $tags_list ) {
				printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'reign' ) . '</span>', $tags_list ); // WPCS: XSS OK.
			}
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			/* translators: %s: post title */
			comments_popup_link( sprintf( wp_kses( __( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'reign' ), array( 'span' => array( 'class' => array() ) ) ), get_the_title() ) );
			echo '</span>';
		}

		edit_post_link(
			sprintf(
				/* translators: %s: Name of current post */
				esc_html__( 'Edit %s', 'reign' ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			),
			'<span class="edit-link">',
			'</span>'
		);
	}

endif;

if ( ! function_exists( 'reign_categorized_blog' ) ) {

	/**
	 * Returns true if a blog has more than 1 category.
	 *
	 * @return bool
	 */
	function reign_categorized_blog() {
		if ( false === ( $all_the_cool_cats = get_transient( 'reign_categories' ) ) ) {
			// Create an array of all the categories that are attached to posts.
			$all_the_cool_cats = get_categories(
				array(
					'fields'     => 'ids',
					'hide_empty' => 1,
					// We only need to know if there is more than one category.
					'number'     => 2,
				)
			);

			// Count the number of categories that are attached to the posts.
			$all_the_cool_cats = count( $all_the_cool_cats );

			set_transient( 'reign_categories', $all_the_cool_cats );
		}

		if ( $all_the_cool_cats > 1 ) {
			// This blog has more than 1 category so reign_categorized_blog should return true.
			return true;
		} else {
			// This blog has only 1 category so reign_categorized_blog should return false.
			return false;
		}
	}
}

if ( ! function_exists( 'reign_category_transient_flusher' ) ) {

	/**
	 * Flush out the transients used in reign_categorized_blog.
	 */
	function reign_category_transient_flusher() {
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		// Like, beat it. Dig?
		delete_transient( 'reign_categories' );
	}

	add_action( 'edit_category', 'reign_category_transient_flusher' );
	add_action( 'save_post', 'reign_category_transient_flusher' );
}


if ( ! function_exists( 'rg_page_loader' ) ) {

	/**
	 * Page Loader
	 */
	function rg_page_loader() {
		// global $wbtm_reign_settings;
		// $active_loader_layout     = isset( $wbtm_reign_settings[ 'reign_pages' ][ 'active_loader_layout' ] ) ? $wbtm_reign_settings[ 'reign_pages' ][ 'active_loader_layout' ] : 'no';
		$active_loader_layout      = get_theme_mod( 'reign_enable_preloading', false );
		$reign_preloading_icon     = get_theme_mod( 'reign_preloading_icon', '' );
		$reign_preloading_bg_color = get_theme_mod( 'reign_preloading_bg_color', '' );
		if ( $active_loader_layout ) {
			echo '<div class="rg-page-loader"></div>';
		}
	}

	add_action( 'reign_before_page', 'rg_page_loader', 9 );
}


if ( ! function_exists( 'rg_content_wrapper_start' ) ) {

	function rg_content_wrapper_start() {
		/*       * * Add PeepSo support ** */
		global $wbtm_reign_settings;
		$wrapper = '<div class="container"><div class="' . apply_filters( 'reign_site_content_grid_class', 'wb-grid site-content-grid' ) . '">';
		if ( class_exists( 'PeepSo' ) ) {
			$peepso_url_segments = PeepSoUrlSegments::get_instance();
			if ( 'peepso_profile' === $peepso_url_segments->_shortcode ) {
				$profile_layout = isset( $wbtm_reign_settings['reign_peepsoextender']['profile_layout'] ) ? $wbtm_reign_settings['reign_peepsoextender']['profile_layout'] : 'full-width';
				$profile_layout = apply_filters( 'wbtm_rth_manage_profile_layout', $profile_layout );
				if ( 'full-width' === $profile_layout ) {
					echo '<div class="reign-peepso-profile layout-full-width">';
					get_template_part( 'template-parts/peepso/navbar' );
					get_template_part( 'template-parts/peepso/focus' );
					echo '</div>';

				} elseif ( 'wide' === $profile_layout ) {
					echo '<div class="container">';
					echo '<div class="reign-peepso-profile layout-wide">';
					get_template_part( 'template-parts/peepso/navbar' );
					get_template_part( 'template-parts/peepso/focus' );
					echo '</div>';
					echo '</div>';

				}
			} elseif ( ( ( 'peepso_groups' === $peepso_url_segments->_shortcode ) && ( sizeof( $peepso_url_segments->_segments ) > 1 ) ) ) {
				$group_layout = isset( $wbtm_reign_settings['reign_peepsoextender']['group_layout'] ) ? $wbtm_reign_settings['reign_peepsoextender']['group_layout'] : 'full-width';
				$group_layout = apply_filters( 'wbtm_rth_manage_group_layout', $group_layout );
				if ( 'full-width' === $group_layout ) {
					echo '<div class="reign-peepso-group layout-full-width">';
					get_template_part( 'template-parts/peepso/group-header' );
					echo '</div>';
				} elseif ( 'wide' === $group_layout ) {
					echo '<div class="container">';
					echo '<div class="reign-peepso-group layout-wide">';
					get_template_part( 'template-parts/peepso/group-header' );
					echo '</div>';
					echo '</div>';
				}
			}

			$wrapper = '<div class="container"><div class="reign-peepso-page"><div class="' . apply_filters( 'reign_site_content_grid_class', 'wb-grid site-content-grid' ) . '">';
		}
		echo $wrapper;
	}

	add_action( 'reign_content_top', 'rg_content_wrapper_start' );
}


if ( ! function_exists( 'rg_content_wrapper_end' ) ) {

	function rg_content_wrapper_end() {

		if ( class_exists( 'PeepSo' ) ) {
			echo '</div>';
		}

		echo '</div></div>';
	}

	add_action( 'reign_content_bottom', 'rg_content_wrapper_end' );
}

if ( ! function_exists( 'rg_woocommerce_theme_wrapper_start' ) ) {

	/**
	 * WooCommerce start wrapper
	 */
	function rg_woocommerce_theme_wrapper_start() {
		echo '<div class="content-wrapper">';
	}

	remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
	add_action( 'woocommerce_before_main_content', 'rg_woocommerce_theme_wrapper_start', 10 );
}

if ( ! function_exists( 'rg_woocommerce_theme_wrapper_end' ) ) {

	/**
	 * WooCommerce end wrapper
	 */
	function rg_woocommerce_theme_wrapper_end() {
		echo '</div>';
	}

	remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
	add_action( 'woocommerce_after_main_content', 'rg_woocommerce_theme_wrapper_end', 10 );
}


/**
* Dark Mode Toggle
*/
add_action( 'reign_before_content', 'dark_mode_toggle' );
$reign_dark_mode_style = get_theme_mod( 'reign_dark_mode_style', 'style2' );
if ( 'style3' === $reign_dark_mode_style ) {
	remove_action( 'reign_before_content', 'dark_mode_toggle' );
	add_action( 'reign_after_header_icons', 'dark_mode_toggle' );
}

if ( 'style4' === $reign_dark_mode_style ) {
	remove_action( 'reign_before_content', 'dark_mode_toggle' );
	add_action( 'reign_before_user_menu_item', 'dark_mode_toggle' );

	// Hook to add extra content inside the ul with class "header-notifications-dropdown-menu".
	add_filter( 'wp_nav_menu_objects', 'add_extra_menu_item', 10, 2 );

	/**
	 * Function to add extra menu item.
	 *
	 * @param array  $items The array of menu items.
	 * @param object $args An object containing wp_nav_menu() arguments.
	 * @return array Modified array of menu items.
	 */
	function add_extra_menu_item( $items, $args ) {
		// Check if it's the correct menu location.
		if ( 'menu-2' === $args->theme_location ) {
			// Generate HTML content using the action hook.
			ob_start();
			do_action( 'reign_before_user_menu_item' );
			$action_output = ob_get_clean();

			// Construct your custom menu item.
			$extra_item                   = new stdClass();
			$extra_item->ID               = 'custom-menu-item dark-mode-toggle-layout-four'; // Unique ID for the item.
			$extra_item->db_id            = 0; // Set db_id to 0 to prevent undefined property warning.
			$extra_item->title            = $action_output; // Assign the HTML content.
			$extra_item->url              = 'javascript:void(0)'; // URL for the item.
			$extra_item->menu_order       = -1; // Ensure it appears at the beginning.
			$extra_item->menu_item_parent = 0; // No parent.
			$extra_item->xfn              = ''; // Optional: Define xfn.
			$extra_item->target           = ''; // Optional: Define target.
			$extra_item->current          = false; // Optional: Define current.
			$extra_item->object           = ''; // Optional: Define object.
			$extra_item->object_id        = ''; // Optional: Define object ID.
			$extra_item->classes          = array(); // Optional: Define classes.

			// Add your custom item to the beginning of the menu.
			array_unshift( $items, $extra_item );
		}
		return $items;
	}
}

if ( ! function_exists( 'dark_mode_toggle' ) ) {
	function dark_mode_toggle() {
		$reign_color_scheme     = get_theme_mod( 'reign_color_scheme' );
		$reign_dark_mode_option = get_theme_mod( 'reign_dark_mode_option' );
		$reign_dark_mode_style  = get_theme_mod( 'reign_dark_mode_style', 'style2' );
		if ( 'reign_dark' !== $reign_color_scheme ) {
			if ( 'style4' === $reign_dark_mode_style ) {
				echo '<li class="custom-menu-item dark-mode-toggle-layout-four">';
				echo '<a href="javascript:void(0)">';
			}
			if ( $reign_dark_mode_option === true ) {
				?>
				<span role="button" class="rg-dark__scheme-toggle <?php echo esc_attr( $reign_dark_mode_style ); ?>">
					<span class="rg-dark__scheme-toggle-icons">
						<i class="rg__scheme-toggle-icon rg-dark__scheme-toggle-icon far fa-sun-bright"></i>
						<i class="rg__scheme-toggle-icon rg-light__scheme-toggle-icon far fa-moon-stars"></i>
					</span>
					<span class="toggle-label rg-dark__scheme-toggle-label-dark"><?php esc_html_e( 'Dark', 'reign' ); ?></span>
					<span class="toggle-label rg-dark__scheme-toggle-label-light"><?php esc_html_e( 'Light', 'reign' ); ?></span> 
				</span>
				<?php
			}
			if ( 'style4' === $reign_dark_mode_style ) {
				echo '</a>';
				echo '</li>';
			}
		}
	}
}

add_filter( 'prepend_attachment', 'reign_prepend_attachment' );
/**
 * Callback for WordPress 'prepend_attachment' filter.
 *
 * Change the attachment page image size to 'large'
 *
 * @package WordPress
 * @category Attachment
 * @see wp-includes/post-template.php
 *
 * @param string $attachment_content the attachment html
 * @return string $attachment_content the attachment html
 */
if ( ! function_exists( 'reign_prepend_attachment' ) ) {
	function reign_prepend_attachment( $attachment_content ) {
			// set the attachment image size to 'large'
			$attachment_content = sprintf( '<p>%s</p>', wp_get_attachment_link( 0, 'large', false ) );
			// return the attachment content
			return $attachment_content;
	}
}


function reign_login_reigister_popup() {

	$form_type_login        = get_theme_mod( 'reign_sign_form_popup', 'default' );
	$popup_custom_shortcode = get_theme_mod( 'reign_sign_form_shortcode' );

	if ( true == get_theme_mod( 'reign_sign_form_shortcode' ) ) {
		$reign_login_shortcode = 'reign-custom-shortcode';
	} else {
		$reign_login_shortcode = '';
	}
	?>
		<div class="reign-module reign-window-popup reign-close-popup" id="registration-login-form-popup" tabindex="-1" role="dialog"  data-id="registration-login-form-popup">
			<div class="modal-dialog window-popup registration-login-form-popup" role="document" >
				<div class="modal-content">
					<div class="close icon-close reign-close-popup" id="reign-close-popup" data-id='registration-login-form-popup'>
						<i class="far fa-times" id="reign-close-popup" data-id='registration-login-form-popup'></i>
					</div>
					<div class="modal-body no-padding <?php echo esc_attr( $reign_login_shortcode ); ?>">
							<?php
							if ( $form_type_login != 'custom' ) {
								echo reign_get_login_reg_form_html();
							} else {
								echo do_shortcode( $popup_custom_shortcode );
							}

							?>
					</div>
				</div>
			</div>
		</div>
	<?php
}

$reign_signin_popup = get_theme_mod( 'reign_signin_popup', false );

if ( true === $reign_signin_popup ) {
	add_action( 'wp_footer', 'reign_login_reigister_popup', 10 );
}

function reign_get_login_reg_form_html( $redirect_to_custom = '', $option_data = array() ) {
	global $wp;

	$forms             = get_theme_mod( 'reign_sign_form_display', 'login' );
	$redirect          = get_theme_mod( 'reign_login_redirect', 'current' );
	$redirect_to       = get_theme_mod( 'reign_login_redirect_url' );
	$login_description = get_theme_mod( 'reign_login_description' );

	$register_redirect    = get_theme_mod( 'reign_register_redirect', 'current' );
	$register_redirect_to = get_theme_mod( 'reign_register_redirect_url' );
	$register_fields_type = 'simple';

	$redirect_to_custom = filter_var( $redirect_to_custom, FILTER_VALIDATE_URL );

	$redirect_to = ( $redirect_to && $redirect === 'custom' ) ? $redirect_to : home_url( $wp->request );
	if ( $redirect_to_custom ) {
		$redirect_to = $redirect_to_custom;
	}

	$register_redirect_to = ( $register_redirect_to && $register_redirect === 'custom' ) ? $register_redirect_to : home_url( $wp->request );
	if ( $redirect_to_custom ) {
		$register_redirect_to = $redirect_to_custom;
	}

	$attr = array();

	if ( ! empty( $option_data ) ) {
		foreach ( $option_data as $option_data_key => $option_data_value ) {
			$attr[ $option_data_key ] = $option_data_value;
		}
	} else {
		$attr = array(
			'register_redirect_to' => $register_redirect_to,
			'redirect_to'          => $redirect_to,
			'login_description'    => $login_description,
			'forms'                => $forms,
			'login_title'          => '',
			'redirect'             => $redirect,
			'register_redirect'    => $register_redirect,
			'register_fields_type' => $register_fields_type,
		);
	}
	get_template_part( 'template-parts/form', '', $attr );
}

function reign_signin_form() {
	check_ajax_referer( 'reign-sign-form', '_ajax_nonce' );

	$errors = array();

	$log         = filter_input( INPUT_POST, 'log' );
	$pwd         = filter_input( INPUT_POST, 'pwd' );
	$rememberme  = filter_input( INPUT_POST, 'rememberme' );
	$redirect    = filter_input( INPUT_POST, 'redirect' );
	$redirect_to = filter_input( INPUT_POST, 'redirect_to', FILTER_VALIDATE_URL );

	if ( ! $log ) {
		$errors['log'] = esc_html__( 'Login is required', 'reign' );
	}

	if ( ! $pwd ) {
		$errors['pwd'] = esc_html__( 'Password is required', 'reign' );
	}

	if ( ! empty( $errors ) ) {
		wp_send_json_error(
			array(
				'errors' => $errors,
			)
		);
	}

	$user = wp_signon(
		array(
			'user_login'    => $log,
			'user_password' => $pwd,
			'remember'      => $rememberme,
		)
	);

	if ( is_wp_error( $user ) ) {
		wp_send_json_error(
			array(
				'message' => $user->get_error_message(),
			)
		);
	}

	if ( reign_BuddyPress() ) {
		if ( function_exists( 'buddypress' ) && version_compare( buddypress()->version, '12.0', '>=' ) ) {
			if ( $redirect === 'profile' && function_exists( 'bp_members_get_user_url' ) ) {
				$redirect_to = bp_members_get_user_url( $user->ID );
			}

			if ( $redirect === 'activity' ) {
				$redirect_to = bp_get_root_url() . '/' . bp_get_activity_slug();
			}
		} else {
			if ( $redirect === 'profile' && function_exists( 'bp_core_get_user_domain' ) ) {
				$redirect_to = bp_core_get_user_domain( $user->ID );
			}

			if ( $redirect === 'activity' ) {
				$redirect_to = bp_get_root_domain() . '/' . bp_get_activity_slug();
			}
		}
	}

	if ( class_exists( 'PeepSo' ) ) {
		if ( $redirect === 'profile' && class_exists( 'PeepSo' ) ) {
			$redirect_to = site_url( '/' ) . 'profile/?user/';
			$user        = PeepSoUser::get_instance( $user->ID );
			$redirect_to = $user->get_profileurl();
		}

		if ( $redirect === 'activity' && class_exists( 'PeepSo' ) ) {
			$redirect_to = site_url( '/' ) . PeepSo::get_option( 'page_activity' );
		}
	}

	wp_send_json_success(
		array(
			'redirect_to' => $redirect_to ? $redirect_to : '',
		)
	);
}
add_action( 'wp_ajax_nopriv_reign-signin-form', 'reign_signin_form' );

/**
 * check buddypress component active or not
 *
 * @package Reign
 */
function reign_BuddyPress() {
	if ( function_exists( 'buddypress' ) && version_compare( buddypress()->version, '12.0', '>=' ) ) {
		if ( function_exists( 'bp_members_get_user_url' ) && function_exists( 'bp_activity_get_user_mentionname' ) && function_exists( 'bp_attachments_get_attachment' ) && function_exists( 'bp_loggedin_user_domain' ) && function_exists( 'bp_is_active' ) && function_exists( 'bp_get_activity_slug' ) && function_exists( 'bp_is_active' ) && function_exists( 'bp_get_notifications_unread_permalink' ) && function_exists( 'bp_loggedin_user_domain' ) && function_exists( 'bp_get_settings_slug' ) ) {
			return true;
		}
	} elseif ( function_exists( 'bp_core_get_user_domain' ) && function_exists( 'bp_activity_get_user_mentionname' ) && function_exists( 'bp_attachments_get_attachment' ) && function_exists( 'bp_loggedin_user_domain' ) && function_exists( 'bp_is_active' ) && function_exists( 'bp_get_activity_slug' ) && function_exists( 'bp_is_active' ) && function_exists( 'bp_get_notifications_unread_permalink' ) && function_exists( 'bp_loggedin_user_domain' ) && function_exists( 'bp_get_settings_slug' ) ) {
			return true;
	}

	return false;
}

function reign_signup_form() {
	check_ajax_referer( 'reign-sign-form', '_ajax_nonce' );

	$errors = array();

	$user_login  = filter_input( INPUT_POST, 'user_login' );
	$user_email  = filter_input( INPUT_POST, 'user_email', FILTER_VALIDATE_EMAIL );
	$first_name  = filter_input( INPUT_POST, 'first_name' );
	$last_name   = filter_input( INPUT_POST, 'last_name' );
	$redirect_to = filter_input( INPUT_POST, 'redirect_to', FILTER_VALIDATE_URL );
	$redirect    = filter_input( INPUT_POST, 'redirect' );
	$gdpr        = '';
	if ( isset( $_POST['gdpr'] ) ) {
		$gdpr = filter_input( INPUT_POST, 'gdpr' );
	}

	if ( isset( $_POST['signup-privacy-policy-accept'] ) ) {
		$gdpr = filter_input( INPUT_POST, 'signup-privacy-policy-accept' );
	}

	if ( isset( $_POST['legal_agreement'] ) ) {
		$gdpr = filter_input( INPUT_POST, 'legal_agreement' );
	}

	$privacy_policy_page_link = get_privacy_policy_url();

	$user_password         = filter_input( INPUT_POST, 'user_password' );
	$user_password_confirm = filter_input( INPUT_POST, 'user_password_confirm' );

	if ( isset( $user_password ) ) {
		$user_password = trim( $user_password );
	}
	$register_fields_type = 'simple';
	$bp_fields            = reign_get_buddypress_fields();
	if ( $register_fields_type != 'simple' ) {
		if ( ! empty( $bp_fields ) ) {
			foreach ( $bp_fields as $bp_field_key => $bp_field_value ) {
				$post_val = ( isset( $_POST[ $bp_field_key ] ) ) ? $_POST[ $bp_field_key ] : '';
				if ( empty( $post_val ) ) {
					$errors[ $bp_field_key ] = esc_html__( $bp_field_value['label'] . ' is required', 'reign' );
				}
			}
		}
	}

	if ( $register_fields_type == 'simple' ) {
		if ( ! trim( $first_name ) && isset( $first_name ) ) {
			$errors['first_name'] = esc_html__( 'First name is required', 'reign' );
		}
		if ( ! trim( $last_name ) && isset( $last_name ) ) {
			$errors['last_name'] = esc_html__( 'Last name is required', 'reign' );
		}
	}

	if ( ! trim( $user_login ) ) {
		$errors['user_login'] = esc_html__( 'Username is required', 'reign' );
	}
	if ( ! trim( $user_email ) ) {
		$errors['user_email'] = esc_html__( 'Email is required', 'reign' );
	}

	if ( strlen( $user_password ) < 6 && isset( $user_password ) ) {
		$errors['user_password'] = esc_html__( 'Minimum password length is 6 characters', 'reign' );
	} elseif ( $user_password !== $user_password_confirm && isset( $user_password_confirm ) && isset( $user_password ) ) {
		$errors['user_password_confirm'] = esc_html__( 'Password and confirm password does not match', 'reign' );
	}

	if ( ! $gdpr && $privacy_policy_page_link && function_exists( 'bp_nouveau_signup_terms_privacy' ) && ! bp_nouveau_signup_terms_privacy() ) {
		$errors['gdpr'] = esc_html__( 'Please, accept privacy policy', 'reign' );
	}

	if ( ! empty( $errors ) ) {
		wp_send_json_error(
			array(
				'errors' => $errors,
			)
		);
	}

	$send_validation_email = 'yes';
	$bp_pages_option       = get_option( 'bp-pages' );
	$register_page_id      = $bp_pages_option['register'];
	$register_page_status  = get_post_status( $register_page_id );
	$register_page_url     = get_permalink( $register_page_id );

	if ( $register_page_status != 'publish' || $register_fields_type != 'extensional' ) {
		if ( ! reign_BuddyPress() ) {
			$user_id = reign_register_new_user( $user_login, $user_email, $user_password );
			// Authorize user
			wp_set_auth_cookie( $user_id, true );
			if ( is_wp_error( $user_id ) ) {
				wp_send_json_error(
					array(
						'message' => $user_id->get_error_message(),
					)
				);
			}

			wp_send_json_success(
				array(
					'redirect_to' => $redirect_to ? $redirect_to : '',
				)
			);

			update_user_meta( $user_id, 'first_name', $first_name );
			update_user_meta( $user_id, 'last_name', $last_name );
		} else {
			$user_meta_arr = array(
				'last_name'  => $last_name,
				'first_name' => $first_name,
				'gdpr'       => $gdpr,
			);
			if ( ! empty( $bp_fields ) ) {
				$date_val = array();
				foreach ( $bp_fields as $bp_field_key => $bp_field_value ) {
					$post_val = ( isset( $_POST[ $bp_field_key ] ) ) ? $_POST[ $bp_field_key ] : '';
					if ( $bp_field_value['type'] != 'datebox' ) {
						$user_meta_arr[ 'reign_sign_form_' . $bp_field_key ] = $post_val;
						$user_meta_arr[ $bp_field_key ]                      = $post_val;
					} else {
						if ( ! isset( $date_text ) ) {
							$date_text = '';
						}
						$date_text .= $post_val . '-';
						array_push( $date_val, 1 );
						if ( count( $date_val ) == 3 ) {
							$date_text = substr( $date_text, 0, -1 );
							$user_meta_arr[ 'reign_sign_form_' . $bp_field_value['id'] ] = $date_text;
							$user_meta_arr[ $bp_field_value['id'] ]                      = $date_text;
							$date_text = '';
							$date_val  = array();
						}
					}
				}
			}
			if ( $send_validation_email == '' ) {
				add_action( 'bp_core_signup_user', 'reign_bp_core_signup_user_disable_validation' );
			}
			$user_id = bp_core_signup_user( $user_login, $user_password, $user_email, $user_meta_arr );
			if ( is_wp_error( $user_id ) ) {
				wp_send_json_error(
					array(
						'message' => $user_id->get_error_message(),
					)
				);
			}

			update_user_meta( $user_id, 'first_name', $first_name );
			update_user_meta( $user_id, 'last_name', $last_name );

			if ( $send_validation_email == '' ) {
				if ( function_exists( 'buddypress' ) && version_compare( buddypress()->version, '12.0', '>=' ) ) {
					if ( $redirect === 'profile' && function_exists( 'bp_members_get_user_url' ) ) {
						$redirect_to = bp_members_get_user_url( $user_id );
					}
				} elseif ( $redirect === 'profile' && function_exists( 'bp_core_get_user_domain' ) ) {
						$redirect_to = bp_core_get_user_domain( $user_id );
				}

				if ( $redirect === 'profile' && class_exists( 'PeepSo' ) ) {
					$redirect_to = site_url() . 'profile/?user/';
					$user        = PeepSoUser::get_instance( $user_id );
					$redirect_to = $user->get_profileurl();
				}

				$user_data = get_userdata( $user_id );

				if ( function_exists( 'buddypress' ) && version_compare( buddypress()->version, '12.0', '>=' ) ) {
					if ( $redirect === 'activity' ) {
						$redirect_to = bp_get_root_url() . '/' . bp_get_activity_slug();
					}
				} elseif ( $redirect === 'activity' ) {
						$redirect_to = bp_get_root_domain() . '/' . bp_get_activity_slug();
				}

				if ( $redirect === 'activity' && class_exists( 'PeepSo' ) ) {
					$redirect_to = site_url( '/' ) . PeepSo::get_option( 'page_activity' );
				}

				wp_send_json_success(
					array(
						'redirect_to' => $redirect_to ? $redirect_to : '',
					)
				);
			} else {
				wp_send_json_success(
					array(
						'email_sent' => 1,
					)
				);
			}
		}
	} elseif ( $register_page_status == 'publish' && $register_fields_type == 'extensional' ) {
		$register_page_url = wp_registration_url();
		$add_params        = '?reign_sign_form_prefill=1&user_login=' . $user_login . '&user_email=' . $user_email . '&first_name=' . $first_name . '&last_name=' . $last_name;

		if ( ! empty( $bp_fields ) ) {
			foreach ( $bp_fields as $bp_field_key => $bp_field_value ) {
				$post_val_el = '';
				$post_val    = ( isset( $_POST[ $bp_field_key ] ) ) ? $_POST[ $bp_field_key ] : '';
				if ( is_array( $post_val ) ) {
					foreach ( $post_val as $post_val_v ) {
						$post_val_el .= wp_unslash( $post_val_v ) . '|';
					}
					$post_val_el = substr( $post_val_el, 0, -1 );
				} else {
					$post_val_el = wp_unslash( $post_val );
				}

				$add_params .= '&' . $bp_field_key . '=' . $post_val_el;
			}
		}

		$register_page_url .= $add_params;
		wp_send_json_success(
			array(
				'redirect_to' => $register_page_url,
			)
		);
	}
}

add_action( 'wp_ajax_nopriv_reign-signup-form', 'reign_signup_form' );


function reign_get_buddypress_fields() {
	$fields_arr = array();
	if ( reign_BuddyPress() ) {
		if ( bp_is_active( 'xprofile' ) && ! function_exists( 'bp_nouveau_has_signup_xprofile_fields' ) ) :
			if ( bp_has_profile(
				array(
					'profile_group_id' => 1,
					'fetch_field_data' => false,
				)
			) ) :
				while ( bp_profile_groups() ) :
					bp_the_profile_group();
					while ( bp_profile_fields() ) :
						bp_the_profile_field();
						if ( bp_get_the_profile_field_is_required() ) {
							if ( bp_get_the_profile_field_type() != 'datebox' ) {
								$fields_arr[ 'field_' . bp_get_the_profile_field_id() ] = array(
									'label' => bp_get_the_profile_field_name(),
									'type'  => bp_get_the_profile_field_type(),
									'id'    => bp_get_the_profile_field_id(),
								);
							} else {
								$fields_arr[ 'field_' . bp_get_the_profile_field_id() . '_day' ]   = array(
									'label' => bp_get_the_profile_field_name(),
									'type'  => bp_get_the_profile_field_type(),
									'id'    => bp_get_the_profile_field_id(),
								);
								$fields_arr[ 'field_' . bp_get_the_profile_field_id() . '_month' ] = array(
									'label' => bp_get_the_profile_field_name(),
									'type'  => bp_get_the_profile_field_type(),
									'id'    => bp_get_the_profile_field_id(),
								);
								$fields_arr[ 'field_' . bp_get_the_profile_field_id() . '_year' ]  = array(
									'label' => bp_get_the_profile_field_name(),
									'type'  => bp_get_the_profile_field_type(),
									'id'    => bp_get_the_profile_field_id(),
								);
							}
						}
				endwhile;
				endwhile;
		endif;
		elseif ( bp_is_active( 'xprofile' ) && bp_nouveau_has_signup_xprofile_fields( true ) ) :
			while ( bp_profile_groups() ) :
				bp_the_profile_group();
				while ( bp_profile_fields() ) :
					bp_the_profile_field();
					if ( bp_get_the_profile_field_is_required() ) {
						if ( bp_get_the_profile_field_type() != 'datebox' ) {
							$fields_arr[ 'field_' . bp_get_the_profile_field_id() ] = array(
								'label' => bp_get_the_profile_field_name(),
								'type'  => bp_get_the_profile_field_type(),
								'id'    => bp_get_the_profile_field_id(),
							);
						} else {
							$fields_arr[ 'field_' . bp_get_the_profile_field_id() . '_day' ]   = array(
								'label' => bp_get_the_profile_field_name(),
								'type'  => bp_get_the_profile_field_type(),
								'id'    => bp_get_the_profile_field_id(),
							);
							$fields_arr[ 'field_' . bp_get_the_profile_field_id() . '_month' ] = array(
								'label' => bp_get_the_profile_field_name(),
								'type'  => bp_get_the_profile_field_type(),
								'id'    => bp_get_the_profile_field_id(),
							);
							$fields_arr[ 'field_' . bp_get_the_profile_field_id() . '_year' ]  = array(
								'label' => bp_get_the_profile_field_name(),
								'type'  => bp_get_the_profile_field_type(),
								'id'    => bp_get_the_profile_field_id(),
							);
						}
					}
			endwhile;
			endwhile;
		endif;
	}

	return $fields_arr;
}


function reign_register_new_user( $user_login, $user_email, $user_pass ) {

	$errors = new WP_Error();

	$sanitized_user_login = sanitize_user( $user_login );
	/**
	 * Filters the email address of a user being registered.
	 *
	 * @since 2.1.0
	 *
	 * @param string $user_email The email address of the new user.
	 */
	$user_email = apply_filters( 'user_registration_email', $user_email );

	// Check the username
	if ( $sanitized_user_login === '' ) {
		$errors->add( 'empty_username', __( '<strong>ERROR</strong>: Please enter a username.', 'reign' ) );
	} elseif ( ! validate_username( $user_login ) ) {
		$errors->add( 'invalid_username', __( '<strong>ERROR</strong>: This username is invalid because it uses illegal characters. Please enter a valid username.', 'reign' ) );
		$sanitized_user_login = '';
	} elseif ( username_exists( $sanitized_user_login ) ) {
		$errors->add( 'username_exists', __( '<strong>ERROR</strong>: This username is already registered. Please choose another one.', 'reign' ) );
	} else {
		/** This filter is documented in wp-includes/user.php */
		$illegal_user_logins = array_map( 'strtolower', (array) apply_filters( 'illegal_user_logins', array() ) );
		if ( in_array( strtolower( $sanitized_user_login ), $illegal_user_logins ) ) {
			$errors->add( 'invalid_username', __( '<strong>ERROR</strong>: Sorry, that username is not allowed.', 'reign' ) );
		}
	}

	// Check the email address
	if ( $user_email === '' ) {
		$errors->add( 'empty_email', __( '<strong>ERROR</strong>: Please type your email address.', 'reign' ) );
	} elseif ( ! is_email( $user_email ) ) {
		$errors->add( 'invalid_email', __( '<strong>ERROR</strong>: The email address isn&#8217;t correct.', 'reign' ) );
		$user_email = '';
	} elseif ( email_exists( $user_email ) ) {
		$errors->add( 'email_exists', __( '<strong>ERROR</strong>: This email is already registered, please choose another one.', 'reign' ) );
	}

	// Check the password
	if ( $user_pass === '' ) {
		$errors->add( 'empty_pass', __( '<strong>ERROR</strong>: Please type your password.', 'reign' ) );
	} elseif ( strlen( $user_pass ) < 6 ) {
		$errors->add( 'invalid_pass', __( '<strong>ERROR</strong>: The minimum password length is 6 characters.', 'reign' ) );
	}

	/**
	 * Fires when submitting registration form data, before the user is created.
	 *
	 * @since 2.1.0
	 *
	 * @param string   $sanitized_user_login The submitted username after being sanitized.
	 * @param string   $user_email           The submitted email.
	 * @param WP_Error $errors               Contains any errors with submitted username and email,
	 *                                       e.g., an empty field, an invalid username or email,
	 *                                       or an existing username or email.
	 */
	do_action( 'register_post', $sanitized_user_login, $user_email, $errors );

	/**
	 * Filters the errors encountered when a new user is being registered.
	 *
	 * The filtered WP_Error object may, for example, contain errors for an invalid
	 * or existing username or email address. A WP_Error object should always returned,
	 * but may or may not contain errors.
	 *
	 * If any errors are present in $errors, this will abort the user's registration.
	 *
	 * @since 2.1.0
	 *
	 * @param WP_Error $errors               A WP_Error object containing any errors encountered
	 *                                       during registration.
	 * @param string   $sanitized_user_login User's username after it has been sanitized.
	 * @param string   $user_email           User's email.
	 */
	$errors = apply_filters( 'registration_errors', $errors, $sanitized_user_login, $user_email );

	if ( $errors->has_errors() ) {
		return $errors;
	}

	$user_id = wp_create_user( $sanitized_user_login, $user_pass, $user_email );
	if ( ! $user_id || is_wp_error( $user_id ) ) {
		$errors->add( 'registerfail', sprintf( __( '<strong>ERROR</strong>: Couldn&#8217;t register you&hellip; please contact the <a href="mailto:%s">webmaster</a> !', 'reign' ), get_option( 'admin_email' ) ) );
		return $errors;
	}

	update_user_option( $user_id, 'default_password_nag', true, true ); // Set up the Password change nag.

	/**
	 * Fires after a new user registration has been recorded.
	 *
	 * @since 4.4.0
	 *
	 * @param int $user_id ID of the newly registered user.
	 */
	do_action( 'register_new_user', $user_id );

	return $user_id;
}

function reign_bp_core_signup_user_disable_validation( $user_id ) {
	global $wpdb;

	// Hook if you want to do something before the activation
	do_action( 'bp_disable_activation_before_activation' );

	$activation_key = get_user_meta( $user_id, 'activation_key', true );
	$activate       = apply_filters( 'bp_core_activate_account', bp_core_activate_signup( $activation_key ) );
	BP_Signup::validate( $activation_key );
	$wpdb->query( $wpdb->prepare( "UPDATE $wpdb->users SET user_status = 0 WHERE ID = %d", $user_id ) );

	// Add note on Activity Stream
	if ( function_exists( 'bp_activity_add' ) ) {
		$userlink = bp_core_get_userlink( $user_id );

		bp_activity_add(
			array(
				'user_id'   => $user_id,
				'action'    => apply_filters( 'bp_core_activity_registered_member', sprintf( __( '%s became a registered member', 'reign' ), $userlink ), $user_id ),
				'component' => 'profile',
				'type'      => 'new_member',
			)
		);

	}
	// Send email to admin
	wp_new_user_notification( $user_id );
	// Remove the activation key meta
	delete_user_meta( $user_id, 'activation_key' );
	// Delete the total member cache
	wp_cache_delete( 'bp_total_member_count', 'bp' );

	// Hook if you want to do something before the login
	do_action( 'bp_disable_activation_before_login' );

	/*
		//Automatically log the user in .
		//Thanks to Justin Klein's  wp-fb-autoconnect plugin for the basic code to login automatically
		$user_info = get_userdata($user_id);
		wp_set_auth_cookie($user_id);

		do_action('wp_signon', $user_info->user_login);
	*/

	// Hook if you want to do something after the login
	do_action( 'bp_disable_activation_after_login' );
}


add_action( 'bp_after_register_page', 'reign_action_reign_sign_form_prefill_register_form' );
function reign_action_reign_sign_form_prefill_register_form() {
	if ( class_exists( 'Youzify' ) ) {
		return;
	}

	$bp_fields = array();
	$bp_fields = reign_get_buddypress_fields();

	if ( isset( $_GET['reign_sign_form_prefill'] ) ) {
		$user_login = ( isset( $_GET['user_login'] ) ) ? $_GET['user_login'] : '';
		$user_email = ( isset( $_GET['user_email'] ) ) ? $_GET['user_email'] : '';
		?>
		<script>
			jQuery( document ).ready( function($) {
				$('#signup_username').val('<?php echo $user_login; ?>');
				$('#signup_email').val('<?php echo $user_email; ?>');
				<?php
				if ( ! empty( $bp_fields ) ) {
					foreach ( $bp_fields as $bp_field_key => $bp_field_value ) {
						$get_field_val = ( isset( $_GET[ $bp_field_key ] ) ) ? $_GET[ $bp_field_key ] : '';
						$input_types   = array( 'textbox', 'textarea', 'number', 'telephone', 'url', 'datebox', 'selectbox' );
						if ( in_array( $bp_field_value['type'], $input_types ) ) {
							?>
						$('*[name="<?php echo $bp_field_key; ?>"]').val('<?php echo $get_field_val; ?>');
							<?php
						} elseif ( $bp_field_value['type'] == 'radio' ) {
							?>
						$('#<?php echo $bp_field_key; ?>').find('input[value="<?php echo $get_field_val; ?>"]').prop('checked', true);
							<?php
						} elseif ( $bp_field_value['type'] == 'checkbox' ) {
							$values_arr = explode( '|', $get_field_val );
							if ( ! empty( $values_arr ) ) {
								foreach ( $values_arr as $values_arr_v ) {
									?>
								$('#<?php echo $bp_field_key; ?>').find('input[value="<?php echo $values_arr_v; ?>"]').prop('checked', true);
									<?php
								}
							}
						} elseif ( $bp_field_value['type'] == 'multiselectbox' ) {
							$values_arr = explode( '|', $get_field_val );
							if ( ! empty( $values_arr ) ) {
								foreach ( $values_arr as $values_arr_v ) {
									?>
								$('select[name="<?php echo $bp_field_key; ?>[]"]').find('option[value="<?php echo $values_arr_v; ?>"]').attr("selected", "selected");
									<?php
								}
							}
						}
					}
				}
				?>
			});
		</script>
		<?php
	}
}

/**
 * Function Footer Custom Text
 */
if ( ! function_exists( 'reign_footer_custom_copyright_text' ) ) {
	/**
	 * Function Footer Custom Text
	 *
	 * @param string $option Custom text option name.
	 * @return mixed         Markup of custom text option.
	 */
	function reign_footer_custom_copyright_text() {

		$copyright = get_theme_mod( 'reign_footer_copyright_text' );
		if ( ! empty( $copyright ) ) {
			$copyright    = str_replace( '[current_year]', date_i18n( 'Y' ), $copyright );
			$copyright    = str_replace( '[site_title]', '<span class="reign-footer-site-title"><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html( get_bloginfo( 'name' ) ) . '</a></span>', $copyright );
			$theme_author = apply_filters(
				'reign_theme_author',
				array(
					'theme_name'       => esc_html__( 'Wbcom Designs', 'reign' ),
					'theme_author_url' => esc_url( 'https://wbcomdesigns.com/' ),
				)
			);
			$copyright    = str_replace( '[theme_author]', '<a href="' . esc_url( $theme_author['theme_author_url'] ) . '">' . esc_html( $theme_author['theme_name'] ) . '</a>', $copyright );
			return apply_filters( 'reign_footer_copyright_text', $copyright );
		} else {
			$output       = '© [current_year] - [site_title] | Theme by [theme_author]';
			$output       = str_replace( '[current_year]', date_i18n( 'Y' ), $output );
			$output       = str_replace( '[site_title]', '<span class="reign-footer-site-title"><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html( get_bloginfo( 'name' ) ) . '</a></span>', $output );
			$theme_author = apply_filters(
				'reign_theme_author',
				array(
					'theme_name'       => esc_html__( 'Wbcom Designs', 'reign' ),
					'theme_author_url' => esc_url( 'https://wbcomdesigns.com/' ),
				)
			);
			$output       = str_replace( '[theme_author]', '<a href="' . esc_url( $theme_author['theme_author_url'] ) . '">' . esc_html( $theme_author['theme_name'] ) . '</a>', $output );
			return apply_filters( 'reign_footer_copyright_text', $output );
		}
	}
}
