<?php
/**
 * Reign Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Reign
 */

function reign_get_default_page_header_image() {
	// return '';
	return REIGN_THEME_URI . '/lib/images/default-header-image.jpg';
}

function reign_header_topbar_default_info_links() {
	$reign_header_topbar_default_info_links = array(
		array(
			'link_text' => esc_attr__( 'Call Us Today! 1.555.555.555', 'reign' ),
			'link_icon' => '<i class="far fa-phone-alt"></i>',
			'link_url'  => '',
		),
		array(
			'link_text' => esc_attr__( 'support@wbcomdesigns.com', 'reign' ),
			'link_icon' => '<i class="far fa-envelope"></i>',
			'link_url'  => 'mailto:support@wbcomdesigns.com',
		),
	);
	$reign_header_topbar_default_info_links = apply_filters( 'reign_header_topbar_default_info_links', $reign_header_topbar_default_info_links );
	return $reign_header_topbar_default_info_links;
}

function reign_header_topbar_default_social_links() {
	$reign_header_topbar_default_social_links = array(
		array(
			'link_text' => esc_attr__( 'Facebook', 'reign' ),
			'link_icon' => '<i class="fab fa-facebook"></i>',
			'link_url'  => '#',
		),
		array(
			'link_text' => esc_attr__( 'X-twitter', 'reign' ),
			'link_icon' => '<i class="fab fa-x-twitter"></i>',
			'link_url'  => '#',
		),
		array(
			'link_text' => esc_attr__( 'LinkedIn', 'reign' ),
			'link_icon' => '<i class="fab fa-linkedin"></i>',
			'link_url'  => '#',
		),
		array(
			'link_text' => esc_attr__( 'Dribbble', 'reign' ),
			'link_icon' => '<i class="fab fa-dribbble"></i>',
			'link_url'  => '#',
		),
		array(
			'link_text' => esc_attr__( 'Github', 'reign' ),
			'link_icon' => '<i class="fab fa-github"></i>',
			'link_url'  => '#',
		),
	);
	$reign_header_topbar_default_social_links = apply_filters( 'reign_header_topbar_default_social_links', $reign_header_topbar_default_social_links );
	return $reign_header_topbar_default_social_links;
}

function reign_header_default_icons_set() {
	$reign_header_default_icons_set = array(
		'search',
		'cart',
		'message',
		'notification',
		'user-menu',
		'login',
		'register-menu',
	);
	$reign_header_default_icons_set = apply_filters( 'reign_header_default_icons_set', $reign_header_default_icons_set );
	return $reign_header_default_icons_set;
}

function reign_mobile_header_default_icons_set() {
	$reign_mobile_header_default_icons_set = array(
		'search',
		'cart',
		'message',
		'notification',
		'user-menu',
		'login',
		'register-menu',
	);
	$reign_mobile_header_default_icons_set = apply_filters( 'reign_mobile_header_default_icons_set', $reign_mobile_header_default_icons_set );
	return $reign_mobile_header_default_icons_set;
}

/**
 * Returns the correct sidebar ID
 *
 * @since  1.0.4
 */
function reign_get_sidebar_id_to_show( $sidebar_location = 'primary_sidebar' ) {
	$theme_slug = apply_filters( 'wbcom_essential_theme_slug', 'reign' );
	global $wp_query;
	if ( isset( $wp_query ) && (bool) $wp_query->is_posts_page ) {
		$post_id = get_option( 'page_for_posts' );
		$post    = get_post( $post_id );
	} else {
		global $post;
	}
	if ( $post ) {
		$wbcom_metabox_data = get_post_meta( $post->ID, $theme_slug . '_wbcom_metabox_data', true );
		$sidebar_id         = isset( $wbcom_metabox_data['layout'][ $sidebar_location ] ) ? $wbcom_metabox_data['layout'][ $sidebar_location ] : '';
		$site_layout        = isset( $wbcom_metabox_data['layout']['site_layout'] ) ? $wbcom_metabox_data['layout']['site_layout'] : '';
		if ( $site_layout != 'both_sidebar' ) {

		}
		// if( ( $site_layout == 'both_sidebar' ) && ( $sidebar_location == 'secondary_sidebar' ) ) {
		// return false;
		// }
		if ( ! empty( $sidebar_id ) && ( $sidebar_id != '0' ) ) {
			return $sidebar_id;
		}
	}
	return false;
}

/** altering Wbcom Essential setting slug as per theme name */
add_filter(
	'wbcom_essential_theme_slug',
	function () {
		$theme_info = wp_get_theme();
		// Get parent theme name
		$reflection = new ReflectionClass( $theme_info );
		$property   = $reflection->getProperty( 'parent' );
		$property->setAccessible( true );
		$parent = $property->getValue( $theme_info );
		if ( $parent ) {
			$theme_info = $property->getValue( $theme_info );
		} else {
			$reflection = new ReflectionClass( $theme_info );
			$property   = $reflection->getProperty( 'headers' );
			$property->setAccessible( true );
			$theme_info = $property->getValue( $theme_info );
		}
		return strtolower( $theme_info['Name'] );
	},
	10,
	1
);

// Breadcrumbs
function reign_breadcrumbs() {

	$alter_reign_breadcrumbs = apply_filters( 'alter_reign_breadcrumbs', false );
	if ( $alter_reign_breadcrumbs ) {
		do_action( 'reign_breadcrumbs' );
		return;
	}

	$wpseo_titles = get_option( 'wpseo_titles' );
	if ( function_exists( 'yoast_breadcrumb' ) && isset( $wpseo_titles['breadcrumbs-enable'] ) && $wpseo_titles['breadcrumbs-enable'] == 1 ) {

		yoast_breadcrumb( '<p id="breadcrumbs">', '</p>' );

	} else {

		// Settings
		$separator        = '&gt;';
		$breadcrums_id    = 'breadcrumbs';
		$breadcrums_class = 'breadcrumbs';
		$home_title       = esc_html__( 'Homepage', 'reign' );

		/* managed */
		$separator  = '<i class="far fa-angle-double-right"></i>';
		$home_title = esc_html__( 'Home', 'reign' );
		$prefix     = '';
		/* managed */

		// If you have any custom post types with custom taxonomies, put the taxonomy name below (e.g. product_cat)
		$custom_taxonomy = 'product_cat';

		// Get the query & post information
		global $post, $wp_query;

		// Do not display on the homepage
		if ( ! is_front_page() ) {

			// Build the breadcrums
			echo '<ul id="' . $breadcrums_id . '" class="' . $breadcrums_class . '">';

			// Home page
			echo '<li class="item-home"><a class="bread-link bread-home" href="' . get_home_url() . '" title="' . $home_title . '">' . $home_title . '</a></li>';
			echo '<li class="separator separator-home"> ' . $separator . ' </li>';

			if ( is_archive() && ! is_tax() && ! is_category() && ! is_tag() ) {

				echo '<li class="item-current item-archive"><strong class="bread-current bread-archive">' . post_type_archive_title( $prefix, false ) . '</strong></li>';
			} elseif ( is_archive() && is_tax() && ! is_category() && ! is_tag() ) {

				// If post is a custom post type
				$post_type = get_post_type();

				// If it is a custom post type display name and link
				if ( $post_type != 'post' ) {

					$post_type_object  = get_post_type_object( $post_type );
					$post_type_archive = get_post_type_archive_link( $post_type );

					echo '<li class="item-cat item-custom-post-type-' . $post_type . '"><a class="bread-cat bread-custom-post-type-' . $post_type . '" href="' . $post_type_archive . '" title="' . $post_type_object->labels->name . '">' . $post_type_object->labels->name . '</a></li>';
					echo '<li class="separator"> ' . $separator . ' </li>';
				}

				$custom_tax_name = get_queried_object()->name;
				echo '<li class="item-current item-archive"><strong class="bread-current bread-archive">' . $custom_tax_name . '</strong></li>';
			} elseif ( is_single() ) {

				// If post is a custom post type
				$post_type = get_post_type();

				if ( $post_type == 'page' && get_query_var( 'post_type' ) ) {
					$post_type = get_query_var( 'post_type' );
				}

				// If it is a custom post type display name and link
				if ( $post_type != 'post' && ! is_author() ) {

					$post_type_object  = get_post_type_object( $post_type );
					$post_type_archive = get_post_type_archive_link( $post_type );

					echo '<li class="item-cat item-custom-post-type-' . $post_type . '"><a class="bread-cat bread-custom-post-type-' . $post_type . '" href="' . $post_type_archive . '" title="' . $post_type_object->labels->name . '">' . $post_type_object->labels->name . '</a></li>';
					echo '<li class="separator"> ' . $separator . ' </li>';
				}

				// Get post category info
				$category = get_the_category();

				if ( ! empty( $category ) ) {

					// Get last category post is in
					// $last_category = end(array_values($category));
					/* managed */
					$category_values = array_values( $category );
					$category_values = end( $category_values );
					$last_category   = $category_values;
					/* managed */

					// Get parent any categories and create array
					$get_cat_parents = rtrim( get_category_parents( $last_category->term_id, true, ',' ), ',' );
					$cat_parents     = explode( ',', $get_cat_parents );

					// Loop through parent categories and store in variable $cat_display
					$cat_display = '';
					foreach ( $cat_parents as $parents ) {
						$cat_display .= '<li class="item-cat">' . $parents . '</li>';
						$cat_display .= '<li class="separator"> ' . $separator . ' </li>';
					}
				}

				// If it's a custom post type within a custom taxonomy.
				$taxonomy_exists = taxonomy_exists( $custom_taxonomy );
				if ( empty( $last_category ) && ! empty( $custom_taxonomy ) && $taxonomy_exists ) {
					$taxonomy_terms = get_the_terms( $post->ID, $custom_taxonomy );
					if ( is_array( $taxonomy_terms ) ) {
						if ( 'uncategorized' !== $taxonomy_terms[0]->slug ) {
							$cat_id       = $taxonomy_terms[0]->term_id;
							$cat_nicename = $taxonomy_terms[0]->slug;
							$cat_link     = get_term_link( $taxonomy_terms[0]->term_id, $custom_taxonomy );
							$cat_name     = $taxonomy_terms[0]->name;
						} elseif ( isset( $taxonomy_terms[1] ) ) {
							$cat_id       = $taxonomy_terms[1]->term_id;
							$cat_nicename = $taxonomy_terms[1]->slug;
							$cat_link     = get_term_link( $taxonomy_terms[1]->term_id, $custom_taxonomy );
							$cat_name     = $taxonomy_terms[1]->name;
						}
					}
				}

				// Check if the post is in a category.
				if ( ! empty( $last_category ) ) {
					echo $cat_display;
					echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</strong></li>';

					// Else if post is in a custom taxonomy.
				} elseif ( ! empty( $cat_id ) ) {
					// Display parent categories and current category.
					$parents        = array();
					$current_cat_id = $cat_id;
					while ( $current_cat_id ) {
						$category = get_term( $current_cat_id, $custom_taxonomy );
						if ( $category ) {
							$parents[]      = $category;
							$current_cat_id = $category->parent;
						} else {
							$current_cat_id = 0;
						}
					}
					$parents = array_reverse( $parents );
					foreach ( $parents as $parent ) {
						echo '<li class="item-cat item-cat-' . $parent->term_id . ' item-cat-' . $parent->slug . '"><a class="bread-cat bread-cat-' . $parent->term_id . ' bread-cat-' . $parent->slug . '" href="' . get_term_link( $parent->term_id, $custom_taxonomy ) . '" title="' . $parent->name . '">' . $parent->name . '</a></li>';
						echo '<li class="separator"> ' . $separator . ' </li>';
					}
					echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</strong></li>';
				} else {
					$post_title = get_the_title();
					$post_title = strip_tags( $post_title );
					echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '" title="' . $post_title . '">' . $post_title . '</strong></li>';
				}
			} elseif ( is_category() ) {

				// Category page
				echo '<li class="item-current item-cat"><strong class="bread-current bread-cat">' . single_cat_title( '', false ) . '</strong></li>';
			} elseif ( is_page() ) {

				// Standard page
				if ( $post->post_parent ) {

					// If child page, get parents
					$anc = get_post_ancestors( $post->ID );

					// Get parents in the right order
					$anc = array_reverse( $anc );

					// Parent page loop
					if ( ! isset( $parents ) ) {
						$parents = null;
					}
					foreach ( $anc as $ancestor ) {
						$parents .= '<li class="item-parent item-parent-' . $ancestor . '"><a class="bread-parent bread-parent-' . $ancestor . '" href="' . get_permalink( $ancestor ) . '" title="' . get_the_title( $ancestor ) . '">' . get_the_title( $ancestor ) . '</a></li>';
						$parents .= '<li class="separator separator-' . $ancestor . '"> ' . $separator . ' </li>';
					}

					// Display parent pages
					echo $parents;

					// Current page
					echo '<li class="item-current item-' . $post->ID . '"><strong title="' . get_the_title() . '"> ' . get_the_title() . '</strong></li>';
				} else {

					// Just display current page if not parents
					echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '"> ' . get_the_title() . '</strong></li>';
				}
			} elseif ( is_tag() ) {

				// Tag page
				// Get tag information
				$term_id       = get_query_var( 'tag_id' );
				$taxonomy      = 'post_tag';
				$args          = 'include=' . $term_id;
				$terms         = get_terms( $taxonomy, $args );
				$get_term_id   = $terms[0]->term_id;
				$get_term_slug = $terms[0]->slug;
				$get_term_name = $terms[0]->name;

				// Display the tag name
				echo '<li class="item-current item-tag-' . $get_term_id . ' item-tag-' . $get_term_slug . '"><strong class="bread-current bread-tag-' . $get_term_id . ' bread-tag-' . $get_term_slug . '">' . $get_term_name . '</strong></li>';
			} elseif ( is_day() ) {

				// Day archive
				// Year link
				echo '<li class="item-year item-year-' . get_the_time( 'Y' ) . '"><a class="bread-year bread-year-' . get_the_time( 'Y' ) . '" href="' . get_year_link( get_the_time( 'Y' ) ) . '" title="' . get_the_time( 'Y' ) . '">' . get_the_time( 'Y' ) . ' Archives</a></li>';
				echo '<li class="separator separator-' . get_the_time( 'Y' ) . '"> ' . $separator . ' </li>';

				// Month link
				echo '<li class="item-month item-month-' . get_the_time( 'm' ) . '"><a class="bread-month bread-month-' . get_the_time( 'm' ) . '" href="' . get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) ) . '" title="' . get_the_time( 'M' ) . '">' . get_the_time( 'M' ) . ' Archives</a></li>';
				echo '<li class="separator separator-' . get_the_time( 'm' ) . '"> ' . $separator . ' </li>';

				// Day display
				echo '<li class="item-current item-' . get_the_time( 'j' ) . '"><strong class="bread-current bread-' . get_the_time( 'j' ) . '"> ' . get_the_time( 'jS' ) . ' ' . get_the_time( 'M' ) . ' Archives</strong></li>';
			} elseif ( is_month() ) {

				// Month Archive
				// Year link
				echo '<li class="item-year item-year-' . get_the_time( 'Y' ) . '"><a class="bread-year bread-year-' . get_the_time( 'Y' ) . '" href="' . get_year_link( get_the_time( 'Y' ) ) . '" title="' . get_the_time( 'Y' ) . '">' . get_the_time( 'Y' ) . ' Archives</a></li>';
				echo '<li class="separator separator-' . get_the_time( 'Y' ) . '"> ' . $separator . ' </li>';

				// Month display
				echo '<li class="item-month item-month-' . get_the_time( 'm' ) . '"><strong class="bread-month bread-month-' . get_the_time( 'm' ) . '" title="' . get_the_time( 'M' ) . '">' . get_the_time( 'M' ) . ' Archives</strong></li>';
			} elseif ( is_year() ) {

				// Display year archive
				echo '<li class="item-current item-current-' . get_the_time( 'Y' ) . '"><strong class="bread-current bread-current-' . get_the_time( 'Y' ) . '" title="' . get_the_time( 'Y' ) . '">' . get_the_time( 'Y' ) . ' Archives</strong></li>';
			} elseif ( is_author() ) {

				// Auhor archive
				// Get the author information
				global $author;
				$userdata = get_userdata( $author );

				// Display author name
				echo '<li class="item-current item-current-' . $userdata->user_nicename . '"><strong class="bread-current bread-current-' . $userdata->user_nicename . '" title="' . $userdata->display_name . '">' . 'Author: ' . $userdata->display_name . '</strong></li>';
			} elseif ( get_query_var( 'paged' ) ) {

				// Paginated archives
				echo '<li class="item-current item-current-' . get_query_var( 'paged' ) . '"><strong class="bread-current bread-current-' . get_query_var( 'paged' ) . '" title="Page ' . get_query_var( 'paged' ) . '">' . __( 'Page', 'reign' ) . ' ' . get_query_var( 'paged' ) . '</strong></li>';
			} elseif ( is_search() ) {

				// Search results page
				echo '<li class="item-current item-current-' . get_search_query() . '"><strong class="bread-current bread-current-' . get_search_query() . '" title="Search results for: ' . get_search_query() . '">Search results for: ' . get_search_query() . '</strong></li>';
			} elseif ( is_404() ) {

				// 404 page
				echo '<li>' . 'Error 404' . '</li>';
			}

			if ( is_author() ) {

				$author_id = get_query_var( 'author' );
				if ( $author_id ) {
					$author = get_user_by( 'id', $author_id );
					if ( ! empty( get_user_meta( $author_id, 'first_name', true ) ) ) {
						$author_name = get_user_meta( $author_id, 'first_name', true ) . ' ' . get_user_meta( $author_id, 'last_name', true );
					} else {
						$author_info = get_userdata( $author_id );
						$author_name = $author_info->data->user_login;
					}

					// Author page
					echo '<li>' . $author_name . '</li>';
				}
			}

			if ( is_home() && ! is_front_page() ) {
				echo '<li>' . single_post_title( '', false ) . '</li>';
			}

			do_action( 'reign_breadcrumbs_last_element' );

			echo '</ul>';
		}
	}
}

add_action( 'init', 'reign_setup_global_settings_variable', 0 );

function reign_setup_global_settings_variable() {
	global $wbtm_reign_settings;
	$wbtm_reign_settings = get_option( 'reign_options', array() );
}

/**
 * show avatars of user who liked a particular activity on activity directory
 * feature like facebook
 *
 * @since 1.0.7
 */
add_action( 'bp_activity_entry_content', 'reign_show_activity_like_avatars' );


function reign_show_activity_like_avatars() {
	if ( ! is_plugin_active( 'buddypress-status/buddypress-status.php' ) ) {
		$activity_id = bp_get_activity_id();
		global $wpdb;
		$query = 'SELECT user_id FROM ' . $wpdb->base_prefix . "usermeta WHERE meta_key = 'bp_favorite_activities' AND (meta_value LIKE '%:$activity_id;%' OR meta_value LIKE '%:\"$activity_id\";%') ";
		$users = $wpdb->get_results( $query, ARRAY_A );
		if ( ! empty( $users ) && is_array( $users ) ) {
				$num_of_avatar_count  = apply_filters( 'reign_show_activity_like_avatars_count', 3 );
				$num_of_listing_count = apply_filters( 'reign_show_activity_like_listing_count', 5 );
				echo '<div class="wbtm_fav_avatar_listing">';

				// for ($i=0; $i < 20; $i++) {
				// $users[$i]['user_id'] = 1;
				// }
			foreach ( $users as $counter => $user ) {
					$user_id = $user['user_id'];
					$avatar  = bp_core_fetch_avatar(
						array(
							'item_id' => $user_id,
							'object'  => 'user',
							'type'    => 'thumb',
						)
					);
				if ( ( $counter + 1 ) <= $num_of_avatar_count ) {
					?>
								<div class="rtm-tooltip">
							<?php echo $avatar; ?>
										<span class="rtm-tooltiptext">
									<?php echo $user_link = bp_core_get_userlink( $user_id ); ?>
										</span>
								</div>
							<?php
				} elseif ( ( $counter + 1 ) <= ( $num_of_avatar_count + $num_of_listing_count ) ) {
					if ( $counter == $num_of_avatar_count ) {
						?>
										<div class="rtm-tooltip">
												<span class="round-fav-counter">
														+<?php echo ( count( $users ) - $num_of_avatar_count ); ?>
												</span>
												<span class="rtm-tooltiptext">
														<ul class="wbtm-rest-member-list">
														<?php
					}
												$user_link = bp_core_get_userlink( $user_id );
												echo '<li>' . $user_link . '</li>';
					if ( ( ( $counter + 1 ) == ( $num_of_avatar_count + $num_of_listing_count ) ) ) {
									echo '<li>+' . ( count( $users ) - ( $counter + 1 ) ) . __( 'others', 'reign' ) . '</li>';
						?>
														</ul>
												</span>
										</div>
									<?php
					}
				}
				?>
					<?php
			}
				echo '<span class="wbtm-likes-this">' . __( 'likes this', 'reign' ) . '</span>';
				echo '</div>';
		}
	}
}

if ( ! function_exists( 'reign_profile_achievements' ) ) {

	/**
	 * Output badges on profile
	 */
	function reign_profile_achievements() {
		if ( class_exists( 'BadgeOS' ) ) {
			global $blog_id, $post;
			$type       = 'all';
			$limit      = apply_filters( 'reign_user_badges_limit', 10 );
			$offset     = 0;
			$count      = 0;
			$filter     = 'completed';
			$search     = false;
			$orderby    = 'menu_order';
			$order      = 'ASC';
			$wpms       = false;
			$include    = array();
			$exclude    = array();
			$meta_key   = '';
			$meta_value = '';
			$old_post   = $post;
			$user_id    = bp_displayed_user_id();
			// Convert $type to properly support multiple achievement types
			if ( 'all' == $type ) {
				$type = badgeos_get_achievement_types_slugs();
				// Drop steps from our list of "all" achievements
				$step_key = array_search( 'step', $type );
				if ( $step_key ) {
					unset( $type[ $step_key ] );
				}
			} else {
				$type = explode( ',', $type );
			}
			// Build $include array
			if ( ! is_array( $include ) ) {
				$include = explode( ',', $include );
			}
			// Build $exclude array
			if ( ! is_array( $exclude ) ) {
				$exclude = explode( ',', $exclude );
			}
			// Initialize our output and counters
			$achievements      = '';
			$achievement_count = 0;
			$query_count       = 0;
			// Grab our hidden badges (used to filter the query)
			$hidden = badgeos_get_hidden_achievement_ids( $type );
			// If we're polling all sites, grab an array of site IDs
			if ( $wpms && $wpms != 'false' ) {
				$sites = badgeos_get_network_site_ids();
			} else {
				// Otherwise, use only the current site
				$sites = array( $blog_id );
			}
			// Loop through each site (default is current site only)
			foreach ( $sites as $site_blog_id ) {
				// If we're not polling the current site, switch to the site we're polling
				if ( $blog_id != $site_blog_id ) {
					switch_to_blog( $site_blog_id );
				}
				// Grab our earned badges (used to filter the query)
				$earned_ids = badgeos_get_user_earned_achievement_ids( $user_id, $type );
				// Query Achievements
				$args = array(
					'post_type'      => $type,
					'orderby'        => $orderby,
					'order'          => $order,
					'posts_per_page' => $limit,
					'offset'         => $offset,
					'post_status'    => 'publish',
					'post__not_in'   => array_diff( $hidden, $earned_ids ),
				);
				// Filter - query completed or non completed achievements
				if ( $filter == 'completed' ) {
					$args['post__in'] = array_merge( array( 0 ), $earned_ids );
				} elseif ( $filter == 'not-completed' ) {
					$args['post__not_in'] = array_merge( $hidden, $earned_ids );
				}
				if ( '' !== $meta_key && '' !== $meta_value ) {
					$args['meta_key']   = $meta_key;
					$args['meta_value'] = $meta_value;
				}
				// Include certain achievements
				if ( ! empty( $include ) ) {
					$args['post__not_in'] = array_diff( $args['post__not_in'], $include );
					$args['post__in']     = array_merge( array( 0 ), array_diff( $include, $args['post__in'] ) );
				}
				// Exclude certain achievements
				if ( ! empty( $exclude ) ) {
					$args['post__not_in'] = array_merge( $args['post__not_in'], $exclude );
				}
				// Search
				if ( $search ) {
					$args['s'] = $search;
				}
				// Loop Achievements
				$achievement_posts = new WP_Query( $args );
				$query_count      += $achievement_posts->found_posts;
				while ( $achievement_posts->have_posts() ) :
					$achievement_posts->the_post();
					// If we were given an ID, get the post
					if ( is_numeric( get_the_ID() ) ) {
						$achievement = get_post( get_the_ID() );
					}
					$achievements .= '<div class="ps-badgeos__item ps-badgeos__item--focus" >';
					$achievements .= '<a href="' . get_permalink( $achievement->ID ) . '">' . badgeos_get_achievement_post_thumbnail( $achievement->ID ) . '</a>';
					$achievements .= '</div>';
					++$achievement_count;
				endwhile;
				wp_reset_query();
				$post = $old_post;
			}
			echo '<div class="ps-badgeos__list-wrapper">';
			echo '<div class="ps-badgeos__list-title">' . _n( 'Recently earned badge', 'Recently earned badges', $achievement_count, 'reign' ) . '</div>';
			echo '<div class="ps-badgeos__list">' . $achievements . '</div>';
			echo '</div>';
		}
	}
}

/**
 * Show Author Info
 *
 * @since 5.5.1
 */
if ( ! function_exists( 'reign_post_content_after' ) ) {
	function reign_post_content_after() {
		if ( is_singular( 'post' ) ) {
			$reign_author_info = get_theme_mod( 'reign_author_info', 'on' );
			if ( ! empty( $reign_author_info ) ) {
				$reign_author_info_link = get_theme_mod( 'reign_author_info_link', 'on' );
				if ( class_exists( 'BuddyPress' ) && $reign_author_info_link ) {
					if ( function_exists( 'buddypress' ) && version_compare( buddypress()->version, '12.0', '>=' ) ) {
						$user_link = bp_members_get_user_url( get_the_author_meta( 'ID' ) );
					} else {
						$user_link = bp_core_get_user_domain( get_the_author_meta( 'ID' ) );
					}
				} else {
					$user_link = get_author_posts_url( get_the_author_meta( 'ID' ) );
				}
				?>
				<div class="entry-author reign-author-info" itemprop="author" itemscope itemtype="http://schema.org/Person">
					<div class="author-avatar" itemprop="image">
						<a href="<?php echo esc_url( $user_link ); ?>">
							<?php echo get_avatar( get_the_author_meta( 'user_email' ), 150, '', esc_html( get_the_author_meta( 'display_name' ) ) ); ?>
						</a>
					</div>
					<div class="author-info">
						<h4 class="author-title"><a class="author-name" href="<?php echo esc_url( $user_link ); ?>" itemprop="name"><?php the_author(); ?></a></h4>
						<div class="author-description" itemprop="description"><?php the_author_meta( 'description' ); ?></div>
					</div>
					<div class="clear"></div>
				</div><!-- /entry-author -->
				<?php
			}
			?>

			<!-- Load content share file -->
			<?php get_template_part( 'template-parts/content', 'share' ); ?>

			<?php
			$reign_show_related_post  = get_theme_mod( 'reign_show_related_post', false );
			$reign_related_post_title = get_theme_mod( 'reign_related_post_title', 'Related Posts' );
			if ( ! empty( $reign_show_related_post ) ) {
				$related_query = new WP_Query(
					array(
						'post_type'      => 'post',
						'category__in'   => wp_get_post_categories( get_the_ID() ),
						'post__not_in'   => array( get_the_ID() ),
						'posts_per_page' => 3,
						'orderby'        => 'date',
					)
				);

				if ( $related_query->have_posts() ) {
					?>
					<div class="reign-related-posts">
						<?php echo '<h3 class="related-title">' . esc_html( $reign_related_post_title ) . '</h3>'; ?>
						<div class="wb-grid">
							<?php while ( $related_query->have_posts() ) { ?>
								<?php $related_query->the_post(); ?>
								<div class="reign-related-post wb-grid-cell md-wb-grid-1-3">
									<div class="reign-related-post-wrap">
										<div class="entry-thumbnail-wrapper">
											<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'medium' ); ?></a>
										</div><!-- .entry-thumbnail-wrapper -->
										<div class="entry-content">
											<div class="entry-date">
												<?php
												$post_id        = get_the_ID(); // Get the current post ID.
												$post           = get_post( $post_id ); // Retrieve the post object.
												$post_date      = $post->post_date; // Get the post date.
												$formatted_date = gmdate( 'F j, Y', strtotime( $post_date ) ); // Format the post date.
												echo esc_html( $formatted_date );
												?>
											</div>
											<div class="entry-title">
												<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
											</div>
											<div class="entry-categories">
												<?php
												$post_id    = get_the_ID(); // Get the current post ID.
												$categories = get_the_category( $post_id ); // Get the categories associated with the post.
												if ( ! empty( $categories ) ) {
													echo '<div class="category-holder">';
													foreach ( $categories as $category ) {
														echo '<a class="tag" href="' . esc_url( get_category_link( $category->term_id ) ) . '">' . esc_html( $category->name ) . '</a>';
													}
													echo '</div>';
												}
												?>
											</div>
										</div>
									</div>
								</div>
							<?php } ?>
						</div>
					</div>
					<?php
					wp_reset_postdata();
				}
			}
		}
	}

	add_action( 'reign_post_content_after', 'reign_post_content_after' );
}

/**
 *
 * CSS Compress
 *
 * @since 5.6.0
 * @version 5.6.0
 */
if ( ! function_exists( 'reign_css_compress' ) ) {
	function reign_css_compress( $css ) {
		if ( $css !== null ) {
			$css = preg_replace( '!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css );
			$css = str_replace( ': ', ':', $css );
			$css = str_replace( array( "\r\n", "\r", "\n", "\t", '  ', '    ', '    ' ), '', $css );
		} else {
			$css = '';
		}
		return $css;
	}
}


/**
 *
 * Replace dark mode logo when user set dark mode from fronted.
 *
 * @since 5.6.1
 */
add_filter( 'get_custom_logo', 'reign_theme_get_custom_logo', 99, 2 );
function reign_theme_get_custom_logo( $html, $blog_id ) {

	if ( isset( $_COOKIE['reign_dark_mode'] ) && $_COOKIE['reign_dark_mode'] == 'true' ) {
		$custom_logo = wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ), 'full' );
		$light_logo  = ( ! empty( $custom_logo ) ) ? $custom_logo[0] : '';
		$dark_logo   = get_theme_mod( 'reign_dark_mode_logo' );

		if ( $dark_logo != '' ) {
			$light_logo_url = $light_logo;
			$dark_logo_url  = $dark_logo;

			$html = str_replace( $light_logo_url, $dark_logo_url, $html );
		}
	}

	return $html;
}

add_filter( 'alter_reign_admin_tabs', 'reign_admin_dark_mode_tabs', 11, 1 );
function reign_admin_dark_mode_tabs( $tabs ) {
	$tabs['wbcom-dark-mode-settings'] = __( 'Dark Mode Image Settings', 'reign' );
	return $tabs;
}

add_action( 'render_theme_options_page_for_wbcom-dark-mode-settings', 'render_theme_options_wbcom_dark_mode_settings' );
function render_theme_options_wbcom_dark_mode_settings() {
	$vertical_tabs = array(
		'dark_image_settings' => __( 'Image Settings', 'reign' ),
	);
	$vertical_tabs = apply_filters( 'wbtm_wbcom-dark-mode-settings_vertical_tabs', $vertical_tabs );
	include 'reign-settings/vertical-tabs-skeleton.php';
}


add_action( 'render_theme_options_for_dark_image_settings', 'render_theme_options_for_dark_image_settings' );
function render_theme_options_for_dark_image_settings() {
	$reign_dark_mode_image_settings = get_option( 'reign_dark_mode_image_settings' );

	?>
	<table class="form-table">
		<tr>
			<td colspan="2">
				<?php esc_html_e( 'Light Mode Image', 'reign' ); ?>
			</td>
			<td colspan="2">
					<?php esc_html_e( 'Dark Mode Image', 'reign' ); ?>
			</td>
			<td colspan="2">
			</td>
		</tr>
		
		<?php
		if ( ! empty( $reign_dark_mode_image_settings ) ) :
			$image_count = count( $reign_dark_mode_image_settings['light_images'] );

			for ( $i = 0; $i < $image_count; $i++ ) :
				?>
			<tr>
				<td colspan="2">
					<img src="<?php echo $reign_dark_mode_image_settings['light_images'][ $i ]; ?>">
					<input type="url" value="<?php echo $reign_dark_mode_image_settings['light_images'][ $i ]; ?>"
						name="reign_dark_mode_image_settings[light_images][]">
					<button type="button" class="button button-primary reign_dark_mode_select_img"><i
							class="dashicons dashicons-plus-alt"></i>
					</button>
					<button type="button"
						class="button button-link-delete reign_dark_mode_delete_img <?php echo ! empty( $reign_dark_mode_image_settings['light_images'][ $i ] ) ? '' : 'hidden'; ?>">
						<i class="dashicons dashicons-trash"></i>
					</button>
				</td>
				<td colspan="2">
					<img src="<?php echo $reign_dark_mode_image_settings['dark_images'][ $i ]; ?>">
					<input type="url" value="<?php echo $reign_dark_mode_image_settings['dark_images'][ $i ]; ?>"
						name="reign_dark_mode_image_settings[dark_images][]">
					<button type="button" class="button button-primary reign_dark_mode_select_img"><i
							class="dashicons dashicons-plus-alt"></i>
					</button>
					<button type="button"
						class="button button-link-delete reign_dark_mode_delete_img <?php echo ! empty( $reign_dark_mode_image_settings['light_images'][ $i ] ) ? '' : 'hidden'; ?>">
						<i class="dashicons dashicons-trash"></i>
					</button>
				</td>
				<td colspan="2">
					<a href="#" class="reign_add_row_image button"><?php esc_html_e( 'Add', 'reign' ); ?></a>
					<a href="#"
						class="reign_remove_row_image button button-link-delete"><?php esc_html_e( 'Remove', 'reign' ); ?></a>
				</td>
			</tr>
				<?php
			endfor;
		else :
			?>
		<tr>
			<td colspan="2">
				<img src="">
				<input type="url" value="" name="reign_dark_mode_image_settings[light_images][]">
				<button type="button" class="button button reign_dark_mode_select_img"><i
						class="dashicons dashicons-plus-alt"></i>
				</button>
				<button type="button" class="button button-link-delete reign_dark_mode_delete_img hidden">
					<i class="dashicons dashicons-trash"></i>
				</button>
			</td>
			<td colspan="2">
				<img src="">
				<input type="url" value="" name="reign_dark_mode_image_settings[dark_images][]">
				<button type="button" class="button button reign_dark_mode_select_img"><i
						class="dashicons dashicons-plus-alt"></i>
				</button>
				<button type="button" class="button button-link-delete reign_dark_mode_delete_img hidden">
					<i class="dashicons dashicons-trash"></i>
				</button>
			</td>
			<td colspan="2">
				<a href="#" class="reign_add_row_image button"><?php esc_html_e( 'Add', 'reign' ); ?></a>
				<a href="#"
					class="reign_remove_row_image button button-link-delete"><?php esc_html_e( 'Remove', 'reign' ); ?></a>
			</td>
		</tr>
		<?php endif; ?>
	</table>
	<?php
}

add_action( 'wp_loaded', 'save_reign_theme_dark_mode_image_settings' );
/**
 * Save dark mode image settings.
 */
function save_reign_theme_dark_mode_image_settings() {
	if ( isset( $_POST['reign-settings-submit'] ) && $_POST['reign-settings-submit'] == 'Y' ) {
		check_admin_referer( 'reign-options' );
		if ( isset( $_POST['reign_dark_mode_image_settings'] ) ) {
			update_option( 'reign_dark_mode_image_settings', $_POST['reign_dark_mode_image_settings'] );
		}
	}
}

/**
 *
 * Display three button, reaction, comment and reshare
 *
 * @since 6.5.0
 * @version 6.5.0
 */

add_action( 'reign_post_comment_before', 'reign_post_comment_box' );
function reign_post_comment_box() {

	global $post, $wpdb;
	if ( get_post_type() != 'post' ) {
		return;
	}

	if ( ! class_exists( 'Buddypress_Reactions_Public' ) && ! class_exists( 'Buddypress_Share_Public' ) ) {
		return true;
	}

	$user_id   = get_current_user_id();
	$post_type = get_post_type();
	$post_id   = get_the_ID();
	if ( class_exists( 'Buddypress_Reactions_Public' ) ) {

		$query                = $wpdb->prepare( 'SELECT * FROM ' . $wpdb->prefix . 'bp_reactions_shortcodes WHERE post_type = %s and front_render=%s limit 1', $post_type, 1 );
		$reactions_shortcodes = $wpdb->get_results( $query );
		$bp_reactions         = $reactions_shortcodes[0];
		$bp_shortcode_id      = $bp_reactions->id;
		$bp_reactions         = json_decode( $bp_reactions->options, true );
		$emojis               = $bp_reactions['emojis'];
		$animation            = $bp_reactions['animation'];
		$reacted_animation    = ( isset( $bp_reactions['react_icon_animation'] ) ) ? $bp_reactions['react_icon_animation'] : 'true';

		$query            = $wpdb->prepare( 'SELECT emoji_id FROM ' . $wpdb->prefix . 'bp_reactions_reacted_emoji WHERE user_id = %s and post_id = %s and  post_type = %s and bprs_id=%s', $user_id, $post_id, $post_type, $bp_shortcode_id );
		$reacted_emoji_id = $wpdb->get_var( $query );

		$bp_reations_classes       = 'bp-reactions-animation-' . $animation;
		$reacted_animation_classes = 'bp-reactions-animation-' . $reacted_animation;

		$activity_react_label = ( isset( $bp_reactions['activity_react_label'] ) && ! empty( $bp_reactions['activity_react_label'] ) ) ? $bp_reactions['activity_react_label'] : __( 'React', 'reign' );

		// Update the react label to the emoji name if a reaction is found.
		if ( $reacted_emoji_id && $reacted_emoji_id !== 0 ) {
			$activity_react_label = get_buddypress_reaction_emoji_name( $reacted_emoji_id );
		}
	}

	$bp_reshare_settings = get_site_option( 'bp_reshare_settings' );

	$share_count   = get_post_meta( $post_id, 'share_count', true );
	$share_count   = ( $share_count ) ? $share_count : 0;
	$comment_count = wp_count_comments( $post_id )->total_comments;

	?>
	
	<div class="reign-post-footer">
		<div class="reign-content-actions">
			<?php if ( function_exists( 'bpr_bp_post_type_reactions_meta' ) ) : ?>
				<div class="reign-content-action">
					<div id="bp-reactions-post-<?php echo esc_attr( $post_id ); ?>" class="reacted-count content-actions">
						<?php bpr_bp_post_type_reactions_meta( $post_id, $post_type, $bp_shortcode_id ); ?>
					</div>
				</div>
			<?php endif; ?>
			<div class="reign-content-action">
				<div class="reign-meta-line">
					<p class="reign-meta-line-text">						
						<?php
						echo esc_html(
							sprintf(
								_nx(
									'%s Comment',
									'%s Comments',
									$comment_count,
									'Comment Count',
									'reign'
								),
								number_format_i18n( $comment_count )
							)
						);
						?>
					</p>
				</div>
				<div class="reign-meta-line">
					<p class="reign-meta-line-text">
						<span id="bp-activity-reshare-count-<?php echo esc_attr( get_the_ID() ); ?>" class="reshare-count bp-post-reshare-count"><?php echo esc_html( $share_count ); ?></span>
					<?php echo __( 'Shares', 'reign' ); ?></p>
				</div>				
			</div>
		</div>
		
		<?php if ( is_user_logged_in() ) : ?>
			<div class="reign-post-options">
				<?php if ( class_exists( 'Buddypress_Reactions_Public' ) ) : ?>
					<div class="reign-post-option-wrap">
						<div class="bp-activity-react-button-wrapper" id="post-reactions-<?php echo esc_attr( $post_id ); ?>">
							<div class="bp-activity-react-btn">
								<a class="button item-button bp-secondary-action bp-activity-react-button" rel="nofollow" data-post-id="<?php echo esc_attr( $post_id ); ?>" data-type="<?php echo esc_attr( $post_type ); ?>"  data-bprs-id="<?php echo esc_attr( $bp_shortcode_id ); ?>">
									<div class="bp-post-react-icon bp-activity-react-icon <?php echo esc_attr( $reacted_animation_classes ); ?>">
										<?php if ( $reacted_emoji_id != '' && $reacted_emoji_id != 0 ) : ?>
											<?php if ( $reacted_animation == 'false' ) : ?>
												<img class="post-option-image" src="<?php echo get_buddypress_reaction_emoji( $reacted_emoji_id, 'svg' ); ?>" alt="">
											<?php else : ?>
												<div class="emoji-pick" data-emoji-id="<?php echo $reacted_emoji_id; ?>" title="<?php echo $reacted_emoji_id; ?>">
													<div class="emoji-lottie-holder" style="display: none"></div>
													<figure itemprop="gif" class="emoji-svg-holder" style="background-image: url('<?php echo get_buddypress_reaction_emoji( $reacted_emoji_id, 'svg' ); ?>'"></figure>
												</div>
											<?php endif; ?>
										<?php else : ?>
											<div class="icon-thumbs-up">
												<i class="br-icon br-icon-smile"></i>
											</div>
										<?php endif; ?>
									</div>
									<span class="bp-react-button-text"><?php echo esc_html( $activity_react_label ); ?></span>
								</a>
							</div>
							<div class="bp-activity-reactions reaction-options emoji-picker <?php echo esc_attr( $bp_reations_classes ); ?>">
								<?php if ( ! empty( $emojis ) ) : ?>
									<?php foreach ( $emojis as $emoji ) : ?>
										<div class="emoji-pick" data-post-id="<?php echo esc_attr( $post_id ); ?>" data-type="<?php echo esc_attr( $post_type ); ?>" data-emoji-id="<?php echo $emoji; ?>" title="<?php echo $emoji; ?>" data-bprs-id="<?php echo esc_attr( $bp_shortcode_id ); ?>" >
											<div class="emoji-lottie-holder" style="display: none"></div>
											<figure itemprop="gif" class="emoji-svg-holder" style="background-image: url('<?php echo get_buddypress_reaction_emoji( $emoji, 'svg' ); ?>'"></figure>
										</div>
									<?php endforeach; ?>
								<?php endif; ?>
							</div>
						</div>
					</div>
				<?php endif; ?>
				
				<div class="reign-post-option-wrap active">
					<i class="far fa-comment-dots"></i><p class="post-option-text"><?php esc_html_e( 'Comment', 'reign' ); ?></p>
				</div>
				
				<?php
				if ( class_exists( 'Buddypress_Share_Public' ) ) :
					$bp_reshare_settings = get_site_option( 'bp_reshare_settings' );
					if ( isset( $bp_reshare_settings['disable_post_reshare_activity'] ) && $bp_reshare_settings['disable_post_reshare_activity'] == 1 ) {
						?>
						<div class="reign-post-option-wrap" style="display: none;">
						<?php
					} else {
						?>
						<div class="reign-post-option-wrap">
						<?php
					}
					?>
						
						<div class="bp-activity-post-share-btn">
							<a class="button item-button bp-secondary-action bp-activity-share-button" data-bs-toggle="modal" data-bs-target="#activity-share-modal" data-post-id="<?php echo esc_attr( $post_id ); ?>" rel="nofollow">
							<span class="bp-activity-reshare-icon">
								<i class="as-icon as-icon-share-square"></i>
							</span>
								<span class="bp-share-text"><?php esc_html_e( 'Share', 'reign' ); ?></span>							
							</a>
						</div>			
					</div>
				<?php endif; ?>
			</div>
		<?php endif; ?>
	</div>
	<?php
}


add_action( 'reign_before_comment_replay', 'reign_post_comment_bp_reactions', 10, 2 );
function reign_post_comment_bp_reactions( $comment_id, $comment ) {
	global $post, $wpdb;

	if ( ! class_exists( 'Buddypress_Reactions_Public' ) ) {
		return true;
	}

	if ( class_exists( 'Buddypress_Reactions_Public' ) ) {

		$user_id   = get_current_user_id();
		$post_type = get_post_type();
		$post_id   = get_the_ID();

		$query                = $wpdb->prepare( 'SELECT * FROM ' . $wpdb->prefix . 'bp_reactions_shortcodes WHERE post_type = %s and front_render=%s limit 1', $post_type, 1 );
		$reactions_shortcodes = $wpdb->get_results( $query );
		$bp_reactions         = $reactions_shortcodes[0];
		$bp_shortcode_id      = $bp_reactions->id;
		$bp_reactions         = json_decode( $bp_reactions->options, true );
		$emojis               = $bp_reactions['emojis'];
		$animation            = $bp_reactions['animation'];

		$query            = $wpdb->prepare( 'SELECT emoji_id FROM ' . $wpdb->prefix . 'bp_reactions_reacted_emoji WHERE user_id = %s and post_id = %s and  post_type = %s and bprs_id=%s', $user_id, $comment_id, 'post-comment', $bp_shortcode_id );
		$reacted_emoji_id = $wpdb->get_var( $query );

		$bp_reations_classes = 'bp-reactions-animation-' . $animation;

		$activity_react_label = ( isset( $bp_reactions['activity_react_label'] ) && ! empty( $bp_reactions['activity_react_label'] ) ) ? $bp_reactions['activity_react_label'] : __( 'React', 'reign' );
	}

	$bp_reshare_settings = get_site_option( 'bp_reshare_settings' );

	?>
	<div class="bp-react-post-comment">
		<?php bpr_bp_post_type_reactions_meta( $comment_id, 'post-comment', $bp_shortcode_id ); ?>
		<div id="bp-activity-comment-react-<?php echo esc_attr( $comment_id ); ?>" class="bp-activity-comment-react-button bp-activity-react-button-wrapper">
			<div class="bp-activity-react-btn">
				<a class="button item-button bp-secondary-action bp-activity-react-button" rel="nofollow" data-post-id="<?php echo esc_attr( $comment_id ); ?>" data-type="post-comment" data-bprs-id="<?php echo esc_attr( $bp_shortcode_id ); ?>">
					<?php echo esc_html( $activity_react_label ); ?>
				</a>
			</div>
			<div class="bp-activity-reactions reaction-options emoji-picker <?php echo esc_attr( $bp_reations_classes ); ?>">
				<?php if ( ! empty( $emojis ) ) : ?>
					<?php foreach ( $emojis as $emoji ) : ?>
						<div class="emoji-pick" data-post-id="<?php echo esc_attr( $comment_id ); ?>" data-type="post-comment" data-emoji-id="<?php echo $emoji; ?>" title="<?php echo $emoji; ?>" data-bprs-id="<?php echo esc_attr( $bp_shortcode_id ); ?>" >
							<div class="emoji-lottie-holder" style="display: none"></div>
							<figure itemprop="gif" class="emoji-svg-holder" style="background-image: url('<?php echo get_buddypress_reaction_emoji( $emoji, 'svg' ); ?>'"></figure>
						</div>
					<?php endforeach; ?>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<?php
}

/**
 * Uses the $comment_type to determine which comment template should be used. Once the
 * template is located, it is loaded for use. Child themes can create custom templates based off
 * the $comment_type. The comment template hierarchy is comment-$comment_type.php,
 * comment.php.
 *
 * The templates are saved in $supreme->comment_template[$comment_type], so each comment template
 * is only located once if it is needed. Following comments will use the saved template.
 *
 * @param array   $comment              array of comment.
 * @param array   $args                 arguments of comments.
 * @param integer $depth                number of replies.
 */
function reign_comments_callback( $comment, $args, $depth ) {

	$GLOBALS['comment']       = $comment;
	$GLOBALS['comment_depth'] = $depth;
	/* Get the comment type of the current comment. */
	$comment_type     = get_comment_type( $comment->comment_ID );
	$comment_template = array();

	/* Check if a template has been provided for the specific comment type.  If not, get the template. */
	if ( ! isset( $comment_template[ $comment_type ] ) ) {
		/* Create an array of template files to look for. */
		$templates = array( "comment-{$comment_type}.php" );
		/* If the comment type is a 'pingback' or 'trackback', allow the use of 'comment-ping.php'. */
		if ( 'pingback' == $comment_type || 'trackback' == $comment_type ) {
			$templates[] = 'comment-ping.php';
		}
		/* Add the fallback 'comment.php' template. */
		$templates[] = 'comment.php';
		/* Locate the comment template. */
		$template = locate_template( $templates );
		/* Set the template in the comment template array. */
		$comment_template[ $comment_type ] = $template;
	}
	/* If a template was found, load the template. */
	if ( ! empty( $comment_template[ $comment_type ] ) ) {
		require $comment_template[ $comment_type ];
	}
}

/**
 * Set default reign menu icons.
 */

add_filter( 'menu_icons_settings', 'regin_menu_icons_settings' );
function regin_menu_icons_settings( $settings ) {
	if ( empty( $settings['global']['icon_types'] ) ) {
		$settings['global']['icon_types'][] = 'reign';
	}
	return $settings;
}


// Header User Menu.
add_action( 'reign_user_profile_menu', 'reign_user_profile_menu' );

/**
 * User profile menu
 *
 * @since 7.0.2
 */
function reign_user_profile_menu() {
	if ( class_exists( 'BuddyPress' ) ) {
		// Get User ID.
		$current_user = wp_get_current_user();
		$user_id      = $current_user->ID;

		// New Array.
		$links              = array();
		$is_xprofile_active = bp_is_active( 'xprofile' );
		$is_settings_active = bp_is_active( 'settings' );

		// Account Settings.
		if ( $is_settings_active ) {
			if ( function_exists( 'buddypress' ) && version_compare( buddypress()->version, '12.0', '>=' ) ) {
				$links['account'] = array(
					'icon'  => 'fa fa-cog',
					'href'  => bp_members_get_user_url( $user_id ) . bp_get_settings_slug(),
					'title' => esc_html__( 'Account Settings', 'reign' ),
				);
			} else {
				$links['account'] = array(
					'icon'  => 'fa fa-cog',
					'href'  => bp_core_get_user_domain( $user_id ) . bp_get_settings_slug(),
					'title' => esc_html__( 'Account Settings', 'reign' ),
				);
			}
		}

		// Profile Settings.
		if ( $is_xprofile_active ) {
			if ( function_exists( 'buddypress' ) && version_compare( buddypress()->version, '12.0', '>=' ) ) {
				$links['profile'] = array(
					'icon'  => 'fa fa-user-cog',
					'href'  => bp_members_get_user_url( $user_id ) . 'profile/edit/group/1',
					'title' => esc_html__( 'Profile Settings', 'reign' ),
				);
			} else {
				$links['profile'] = array(
					'icon'  => 'fa fa-user-cog',
					'href'  => bp_core_get_user_domain( $user_id ) . 'profile/edit/group/1',
					'title' => esc_html__( 'Profile Settings', 'reign' ),
				);
			}
		}

		if ( $is_xprofile_active ) {
			// Change Photo Link.
			if ( function_exists( 'buddypress' ) && version_compare( buddypress()->version, '12.0', '>=' ) ) {
				$links['change-photo'] = array(
					'icon'  => 'fa fa-image',
					'href'  => bp_members_get_user_url( $user_id ) . 'profile/change-avatar',
					'title' => esc_html__( 'Change Avatar', 'reign' ),
				);
			} else {
				$links['change-photo'] = array(
					'icon'  => 'fa fa-image',
					'href'  => bp_core_get_user_domain( $user_id ) . 'profile/change-avatar',
					'title' => esc_html__( 'Change Avatar', 'reign' ),
				);
			}
		}

		if ( $is_settings_active ) {
			global $current_user;
			if ( bp_loggedin_user_id() && isset( $current_user->roles ) && ! in_array( 'demo-user', $current_user->roles ) ) {
				// Change Password Link.
				if ( function_exists( 'buddypress' ) && version_compare( buddypress()->version, '12.0', '>=' ) ) {
					$links['change-password'] = array(
						'icon'  => 'fa fa-lock',
						'href'  => bp_members_get_user_url( $user_id ) . bp_get_settings_slug() . '/general',
						'title' => esc_html__( 'Change Password', 'reign' ),
					);
				} else {
					$links['change-password'] = array(
						'icon'  => 'fa fa-lock',
						'href'  => bp_core_get_user_domain( $user_id ) . bp_get_settings_slug() . '/general',
						'title' => esc_html__( 'Change Password', 'reign' ),
					);
				}
			}
		}

		?>

		<ul id="user-profile-menu" class="user-profile-menu header-notifications-dropdown-menu">
			<?php do_action( 'reign_before_user_menu_item' ); ?>

			<li class="menu-item">
				<?php if ( function_exists( 'buddypress' ) && version_compare( buddypress()->version, '12.0', '>=' ) ) : ?>
					<a href="<?php echo esc_url( bp_members_get_user_url( get_current_user_id() ) ); ?>">
				<?php else : ?>
					<a href="<?php echo esc_url( bp_core_get_user_domain( get_current_user_id() ) ); ?>">
				<?php endif; ?>
					<i class="fa fa-user"></i>
					<span class="menu-title"><?php echo esc_html__( 'Profile Info', 'reign' ); ?></span>
				</a>
			</li>
			<?php foreach ( $links as $link ) : ?>
				<li class="menu-item">
					<a href="<?php echo esc_url( $link['href'] ); ?>">
						<i class="<?php echo esc_attr( $link['icon'] ); ?>"></i>
						<span class="menu-title"><?php echo esc_html( $link['title'] ); ?></span>
					</a>
				</li>
			<?php endforeach; ?>
			<li class="menu-item bp-menu bp-logout-nav">
				<a href="<?php echo esc_url( wp_logout_url() ); ?>" class="reign-logout"><i class="fa fa-sign-out"></i><span class="menu-title"><?php esc_html_e( 'Log Out', 'reign' ); ?></span></a>
			</li>

			<?php do_action( 'reign_after_user_menu_item' ); ?>
		</ul>

		<?php
	} else {
		?>
		<ul id="user-profile-menu" class="user-profile-menu header-notifications-dropdown-menu">
			<li class="menu-item">
				<a href="<?php echo esc_url( wp_logout_url() ); ?>" class="reign-logout"><i class="fa fa-sign-out"></i><span class="menu-title"><?php esc_html_e( 'Log Out', 'reign' ); ?></span></a>
			</li>
		</ul>
		<?php
	}
}


/**
 * Reign ajax add remove friend.
 *
 * @since 7.0.3
 */
function reign_ajax_addremove_friend() {
	if ( function_exists( 'BuddyPress' ) ) {
		$response = array(
			'feedback' => sprintf(
				'<div class="bp-feedback error bp-ajax-message"><p>%s</p></div>',
				esc_html__( 'Something went wrong. Please try again.', 'reign' )
			),
		);
		// Bail if not a POST action.
		if ( ! bp_is_post_request() ) {
			wp_send_json_error( $response );
		}

		if ( empty( $_POST['friendship_id'] ) || ! bp_is_active( 'friends' ) ) {
			wp_send_json_error( $response );
		}

		// Cast fid as an integer.
		$friend_id = (int) $_POST['friendship_id'];

		// Check if the user exists only when the Friend ID is not a Frienship ID.
		if ( isset( $_POST['data_action'] ) && $_POST['data_action'] !== 'friends_accept_friendship' && $_POST['data_action'] !== 'friends_reject_friendship' ) {
			$user = get_user_by( 'id', $friend_id );
			if ( ! $user ) {
				wp_send_json_error(
					array(
						'feedback' => sprintf(
							'<div class="bp-feedback error">%s</div>',
							esc_html__( 'No member found by that ID.', 'reign' )
						),
					)
				);
			}
		}

		// In the 2 first cases the $friend_id is a friendship id.
		if ( ! empty( $_POST['data_action'] ) && 'friends_accept_friendship' === $_POST['data_action'] ) {
			if ( ! friends_accept_friendship( $friend_id ) ) {
				wp_send_json_error(
					array(
						'feedback' => sprintf(
							'<div class="bp-feedback error">%s</div>',
							esc_html__( 'There was a problem accepting that request. Please try again.', 'reign' )
						),
					)
				);
			} else {
				wp_send_json_success(
					array(
						'feedback' => sprintf(
							'<div class="bp-feedback success">%s</div>',
							esc_html__( 'Friendship accepted.', 'reign' )
						),
						'type'     => 'success',
						'is_user'  => true,
					)
				);
			}

				// Rejecting a friendship.
		} elseif ( ! empty( $_POST['data_action'] ) && 'friends_reject_friendship' === $_POST['data_action'] ) {
			if ( ! friends_reject_friendship( $friend_id ) ) {
				wp_send_json_error(
					array(
						'feedback' => sprintf(
							'<div class="bp-feedback error">%s</div>',
							esc_html__( 'There was a problem rejecting that request. Please try again.', 'reign' )
						),
					)
				);
			} else {
				wp_send_json_success(
					array(
						'feedback' => sprintf(
							'<div class="bp-feedback success">%s</div>',
							esc_html__( 'Friendship rejected.', 'reign' )
						),
						'type'     => 'success',
						'is_user'  => true,
					)
				);
			}
		}
	}
}

// custom ajax friend request accept/reject.
add_action( 'wp_ajax_reign_ajax_addremove_friend', 'reign_ajax_addremove_friend' );
add_action( 'wp_ajax_nopriv_reign_ajax_addremove_friend', 'reign_ajax_addremove_friend' );



if ( ! function_exists( 'reign_post_navigation' ) ) :
	/**
	 * Post Navigation with thumbnail.
	 *
	 * @since 7.3.2
	 */
	function reign_post_navigation() {
		$next_post = get_next_post();
		$prev_post = get_previous_post();

		if ( $next_post || $prev_post ) :
			?>
			<div class="reign-posts-nav">
				<div class="reign-posts-nav-inner prev">
					<?php if ( ! empty( $prev_post ) ) : ?>
					<a class="nav-link" href="<?php echo esc_url( get_permalink( $prev_post ) ); ?>">
						<div class="reign-posts-nav-thumbnail">
							<div class="prev">
								<?php echo get_the_post_thumbnail( $prev_post, array( 80, 80 ) ); ?>
							</div>
						</div>
						<div class="reign-posts-nav-wrap">
							<div class="nav-prev">
								<?php esc_html_e( 'Previous', 'reign' ); ?>
							</div>
							<h4 class="nav-title"><?php echo esc_html( get_the_title( $prev_post ) ); ?></h4>
						</div>
					</a>
					<?php endif; ?>
				</div>
				<div class="reign-posts-nav-inner next">
					<?php if ( ! empty( $next_post ) ) : ?>
					<a class="nav-link" href="<?php echo esc_url( get_permalink( $next_post ) ); ?>">
						<div class="reign-posts-nav-wrap">
							<div class="nav-next">
								<?php esc_html_e( 'Next', 'reign' ); ?>
							</div>
							<h4 class="nav-title"><?php echo esc_html( get_the_title( $next_post ) ); ?></h4>
						</div>
						<div class="reign-posts-nav-thumbnail">
							<div class="next">
								<?php echo get_the_post_thumbnail( $next_post, array( 80, 80 ) ); ?>
							</div>
						</div>
					</a>
					<?php endif; ?>
				</div>
			</div> <!-- .reign-posts-nav -->
			<?php
		endif;
	}
endif;


/**
 * Add a fallback for the primary menu if the logout menu does not exist.
 */
function fallback_primary_desktop_menu() {
	wp_nav_menu(
		array(
			'theme_location' => 'menu-1',
			'menu_id'        => 'primary-menu',
			'container'      => false,
			'menu_class'     => 'primary-menu',
		)
	);
}

/**
 * Add a fallback for the left panel menu if the logout mode panel menu does not exist.
 */
function fallback_panel_menu() {
	wp_nav_menu(
		array(
			'theme_location' => 'panel-menu',
			'menu_id'        => 'reign-panel',
			'fallback_cb'    => '',
			'container'      => false,
			'walker'         => new Reign_Left_Panel_Menu_Walker(),
			'menu_class'     => 'navbar-nav navbar-reign-panel',
		)
	);
}

/**
 * Add a fallback for the primary menu if the mobile menu does not exist.
 */
function fallback_primary_mobile_menu() {
	wp_nav_menu(
		array(
			'theme_location' => 'menu-1',
			'menu_id'        => 'primary-menu',
			'container'      => false,
			'walker'         => new Reign_Left_Panel_Menu_Walker(),
			'menu_class'     => 'primary-menu navbar-nav',
		)
	);
}

/**
 * Check if current page template is Elementor Full Width template.
 *
 * @since 7.4.6
 */
if ( ! function_exists( 'reign_is_elementor_header_footer_template' ) ) {

	function reign_is_elementor_header_footer_template() {
		global $post, $wp_query;

		$id = 0;

		if ( isset( $post ) && is_object( $post ) && isset( $post->ID ) ) {
			$id = $post->ID;
		} elseif ( isset( $wp_query ) && is_object( $wp_query ) && isset( $wp_query->post ) && ! empty( $wp_query->post ) ) {
			$id = $wp_query->post->ID;
		}

		if ( 'elementor_header_footer' === get_post_meta( $id, '_wp_page_template', true ) ) {
			return true;
		}
	}
}

/**
 * Update site content grid class
 *
 * @since 7.4.6
 */
if ( ! function_exists( 'reign_add_elementor_content_class' ) ) {

	function reign_add_elementor_content_class() {

		if ( reign_is_elementor_header_footer_template() ) {
			add_filter(
				'reign_site_content_grid_class',
				function () {
					return 'reign-elementor-content';
				}
			);
		}
	}

	add_action( 'reign_before_masthead', 'reign_add_elementor_content_class' );
}
