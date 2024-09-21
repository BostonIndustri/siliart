<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'Reign_Shortcodes' ) ) :

	/**
	 * Includes settings to display PeepSo WooCommerce Integration settings tab
	 *
	 * @class Reign_Shortcodes
	 */
	class Reign_Shortcodes {

		/**
		 * The single instance of the class.
		 *
		 * @var Reign_Shortcodes
		 */
		protected static $_instance = null;

		/**
		 * Main Reign_Shortcodes Instance.
		 *
		 * Ensures only one instance of Reign_Shortcodes is loaded or can be loaded.
		 *
		 * @return Reign_Shortcodes - Main instance.
		 */
		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		/**
		 * Reign_Shortcodes Constructor.
		 */
		public function __construct() {
			$this->init_hooks();
		}

		/**
		 * Hook into actions and filters.
		 */
		private function init_hooks() {
			add_shortcode( 'reign_display_posts', array( $this, 'reign_get_posts' ) );
		}

		/**
		 * Retrieves and displays posts based on the provided attributes.
		 *
		 * @param array $atts Shortcode attributes passed to the function.
		 * @return string HTML content to display posts.
		 */
		public function reign_get_posts( $atts ) {
			global $blog_list_layout;
			$_blog_list_layout  = get_theme_mod( 'reign_blog_list_layout', 'default-view' );
			$reign_blog_per_row = get_theme_mod( 'reign_blog_per_row', '3' );

			// Add 'column_count' to shortcode attributes with a default of 3 columns.
			$atts = shortcode_atts(
				array(
					'category'       => array(),
					'posts_view'     => $_blog_list_layout,
					'posts_per_page' => -1,
					'column_count'   => $reign_blog_per_row, // Default column count.
				),
				$atts,
				'reign_display_posts'
			);

			if ( ! empty( $atts['category'] ) ) {
				$category = explode( ',', $atts['category'] );
			} else {
				$category = $atts['category'];
			}

			$blog_list_layout = $atts['posts_view'];

			// Query setup.
			$global_query = $GLOBALS['wp_query'];
			$paged        = get_query_var( 'paged', 1 );
			wp_reset_postdata();
			$args = array(
				'posts_per_page' => $atts['posts_per_page'],
				'cat'            => $category,
			);
			$args = apply_filters( 'alter_reign_display_posts_args', $args );
			$query = new WP_Query( $args );
			$GLOBALS['wp_query'] = $query;

			ob_start();

			echo '<div class="reign-blog-shortcode">';
			if ( $blog_list_layout == 'masonry-view' ) {
				echo '<div class="masonry wb-post-listing col-' . esc_attr( $atts['column_count'] ) . '">';
				echo '<div class="reign-grid-sizer"></div>';
			} elseif ( $blog_list_layout == 'wb-grid-view' ) {
				echo '<div class="wb-grid-view-wrap wb-post-listing col-' . esc_attr( $atts['column_count'] ) . '">';
			} else {
				echo '<div class="wb-lists-view-wrap wb-post-listing">';
			}

			if ( $query->have_posts() ) {
				while ( $query->have_posts() ) :
					$query->the_post();
					get_template_part( 'template-parts/content', get_post_format() );
				endwhile;
				reign_custom_post_navigation();
				wp_reset_postdata();
				$GLOBALS['wp_query'] = $global_query;
			}

			if ( $blog_list_layout == 'masonry-view' ) {
				echo '</div>';
			} elseif ( $blog_list_layout == 'wb-grid-view' ) {
				echo '</div>';
			} else {
				echo '</div>';
			}

			echo '</div>';

			// Modify comments display if on a singular post type.
			if ( is_singular() && post_type_supports( get_post_type(), 'comments' ) ) {
				add_filter( 'comments_open', '__return_false' );
				add_filter( 'comments_array', '__return_empty_array' );
			}

			// Output and return the buffered content.
			$output = ob_get_clean();
			return $output;
		}

	}

	endif;

/**
 * Main instance of Reign_Shortcodes.
 *
 * @return Reign_Shortcodes
 */
Reign_Shortcodes::instance();
