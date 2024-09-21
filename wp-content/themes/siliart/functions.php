<?php
if ( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Check if the function, `debug` doesn't exist.
 */
if ( ! function_exists( 'debug' ) ) {
	/**
	 * Print_r any variable.
	 * This should be removed from the production environment and should only be added when troubleshooting.
	 *
	 * @param string $params Variable to display the content of.
	 *
	 * @since 1.0.0
	 */
	function debug( $params ) {
		echo '<pre>';
		print_r( $params );
		echo '</pre>';
	}
}

/**
 * If the function, `siliart_locale_stylesheet_uri_callback` doesn't exist.
 */
if ( ! function_exists( 'siliart_locale_stylesheet_uri_callback' ) ) {
	/**
	 * Update the locale URI.
	 *
	 * @param string $uri Locale URI.
	 *
	 * @return string
	 *
	 * @since 1.0.0
	 */
	function siliart_locale_stylesheet_uri_callback( $uri ) {

		if ( empty( $uri ) && is_rtl() && file_exists( get_template_directory() . '/rtl.css' ) ) {
			$uri = get_template_directory_uri() . '/rtl.css';
		}

		return $uri;
	}
}

add_filter( 'locale_stylesheet_uri', 'siliart_locale_stylesheet_uri_callback' );

/**
 * If the function, `siliart_wp_enqueue_scripts_callback` doesn't exist.
 */
if ( ! function_exists( 'siliart_wp_enqueue_scripts_callback' ) ) {
	/**
	 * Enqueue custom assets on the website public end.
	 *
	 * @since 1.0.0
	 */
	function siliart_wp_enqueue_scripts_callback() {
		wp_enqueue_style(
			'siliart-parent-theme-style',
			trailingslashit( get_template_directory_uri() ) . 'style.css',
			array( 'elusive', 'foundation-icons', 'genericons', 'reign_peepso_style', 'reign_main_style', 'reign_woocommerce_style', 'font-awesome', 'theme-font' )
		);
		wp_enqueue_style(
			'siliart-child-theme-style',
			trailingslashit( get_stylesheet_directory_uri() ) . '/assets/css/public.css',
			array(),
			filemtime( get_stylesheet_directory() . '/assets/css/public.css' )
		);
		wp_enqueue_style(
			'siliart-child-theme-media-style',
			trailingslashit( get_stylesheet_directory_uri() ) . '/assets/css/public-media.css',
			array(),
			filemtime( get_stylesheet_directory() . '/assets/css/public-media.css' )
		);
		wp_enqueue_script(
			'siliart-child-theme-public-js',
			trailingslashit( get_stylesheet_directory_uri() ) . '/assets/js/public.js',
			array( 'jquery' ),
			filemtime( get_stylesheet_directory() . '/assets/js/public.js' ),
			true
		);
	}
}

add_action( 'wp_enqueue_scripts', 'siliart_wp_enqueue_scripts_callback' );

/**
 * If the function, `siliart_init_callback` doesn't exist.
 */
if ( ! function_exists( 'siliart_init_callback' ) ) {
	/**
	 * Delete the fake users.
	 *
	 * @since 1.0.0
	 */
	function siliart_init_callback() {
		global $wpdb;

		// Return, if it's admin.
		if ( is_admin() ) {
			return;
		}

		// Return, if it's not Adarsh's IP address.
		if ( '183.82.161.148' !== $_SERVER['REMOTE_ADDR'] ) {
			return;
		}

		$users    = new WP_User_Query(
			array(
				'fields' => array( 'ID', 'user_login' ),
				'number' => 5000,
			)
		);
		$user_ids = $users->get_results();

		// Return, if there are no users.
		if ( empty( $user_ids ) || ! is_array( $user_ids ) ) {
			return;
		}

		// Loop through the users.
		foreach ( $user_ids as $user_id ) {
			// Skip, if the user login name doesn't have 'telegram' in it.
			if ( ! empty( $user_id->user_login ) && false === stripos( $user_id->user_login, 'telegram' ) ) {
				continue;
			}

			debug( $user_id );

			$userid = (int) $user_id->ID;

			// Delete User metadata
			$wpdb->delete(
				$wpdb->usermeta,
				array(
					'user_id' => $userid,
				),
				array( '%d' )
			);

			// Delete User
			$wpdb->delete(
				$wpdb->users,
				array(
					'ID' => $userid,
				),
				array( '%d' )
			);
		}

		die("all users deleted");
	}
}

// add_action( 'init', 'siliart_init_callback' );

/**
 * If the function, `siliart_manage_users_columns_callback` isn't defined.
 */
if ( ! function_exists( 'siliart_manage_users_columns_callback' ) ) {
	/**
	 * Add custom columns to the users list in the administrator dashboard.
	 *
	 * @param array $cols Columns array.
	 *
	 * @return array
	 *
	 * @since 1.0.0
	 */
	function siliart_manage_users_columns_callback( $cols = array() ) {
		// If the user registration date column doesn't exist.
		if ( ! array_key_exists( 'registration_date', $cols ) ) {
			$cols['registration_date'] = __( 'Registered on', 'siliart' );
		}

		return $cols;
	}
}

add_filter( 'manage_users_columns', 'siliart_manage_users_columns_callback', 99 );

/**
 * If the function, `siliart_manage_users_custom_column_callback` isn't defined.
 */
if ( ! function_exists( 'siliart_manage_users_custom_column_callback' ) ) {
	/**
	 * Add content to the custom columns in the users table.
	 *
	 * @param string $column_content Custom column content.
	 * @param string $column_name    Custom column name.
	 * @param int    $user_id        User ID.
	 *
	 * @return string
	 *
	 * @since 1.0.0
	 */
	function siliart_manage_users_custom_column_callback( $column_content, $column_name, $user_id ) {
		if ( 'registration_date' === $column_name ) {
			$userdata        = get_userdata( $user_id );
			$registered_date = gmdate( 'F j, Y, h:iA', strtotime( $userdata->data->user_registered ) );

			return $registered_date;
		}

		return $column_content;
	}
}

add_filter( 'manage_users_custom_column', 'siliart_manage_users_custom_column_callback', 99, 3 );

/**
 * If the function, `siliart_manage_users_sortable_columns_callback` isn't defined.
 */
if ( ! function_exists( 'siliart_manage_users_sortable_columns_callback' ) ) {
	/**
	 * Add custom columns to the users list in the administrator dashboard.
	 *
	 * @param array $cols Columns array.
	 *
	 * @return array
	 *
	 * @since 1.0.0
	 */
	function siliart_manage_users_sortable_columns_callback( $cols = array() ) {

		return wp_parse_args( array( 'registration_date' => 'registered' ), $cols );
	}
}

add_filter( 'manage_users_sortable_columns', 'siliart_manage_users_sortable_columns_callback' );
