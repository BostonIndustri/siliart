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
		// siliart_delete_users();
		siliart_delete_ds_store_files();
	}
}

add_action( 'init', 'siliart_init_callback' );

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

/**
 * If the function, `siliart_peepso_register_form_fields_callback` isn't defined.
 */
if ( ! function_exists( 'siliart_peepso_register_form_fields_callback' ) ) {
	/**
	 * Manage the peepso registration form fields.
	 *
	 * @param array $fields Registration form fields.
	 *
	 * @return array
	 *
	 * @since 1.0.0
	 */
	function siliart_peepso_register_form_fields_callback( $fields = array() ) {
		$input      = new PeepSoInput();
		$new_fields = array();

		// Add first name to the form if it doesn't exist already.
		if ( ! array_key_exists( 'firstname', $fields ) ) {
			$new_fields['firstname'] = array(
				'label'             => __( 'First Name', 'siliart' ),
				'descript'          => __( 'Enter your first name', 'siliart' ),
				'value'             => $input->value( 'firstname', '', FALSE ), // SQL Safe
				'required'          => 1,
				'row_wrapper_class' => 'ps-form__row--half',
				'validation'        => array(
					'name-utf8',
					'minlen:' . PeepSoUser::FIRSTNAME_MINLEN,
					'maxlen:' . PeepSoUser::FIRSTNAME_MAXLEN,
				),
				'type'              => 'text',
			);
		}

		// Add last name to the form if it doesn't exist already.
		if ( ! array_key_exists( 'lastname', $fields ) ) {
			$new_fields['lastname'] = array(
				'label'             => __( 'Last Name', 'siliart' ),
				'descript'          => __( 'Enter your last name', 'siliart' ),
				'value'             => $input->value( 'lastname', '', FALSE ), // SQL Safe
				'required'          => 1,
				'row_wrapper_class' => 'ps-form__row--half',
				'validation'        => array(
					'name-utf8',
					'minlen:' . PeepSoUser::LASTNAME_MINLEN,
					'maxlen:' . PeepSoUser::LASTNAME_MAXLEN,
				),
				'type'              => 'text',
			);
		}

		return array_merge( $new_fields, $fields );
	}
}

add_filter( 'peepso_register_form_fields', 'siliart_peepso_register_form_fields_callback' );

/**
 * If the function, `siliart_peepso_register_new_user_callback` isn't defined.
 */
if ( ! function_exists( 'siliart_peepso_register_new_user_callback' ) ) {
	/**
	 * Update the new user's first name and last name into the database.
	 *
	 * @param object $$user_id Newly registered user ID.
	 *
	 * @since 1.0.0
	 */
	function siliart_peepso_register_new_user_callback( $user_id ) {
		$first_name = filter_input( INPUT_POST, 'firstname', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
		$last_name  = filter_input( INPUT_POST, 'lastname', FILTER_SANITIZE_FULL_SPECIAL_CHARS );

		update_user_meta( $user_id, 'first_name', $first_name );
		update_user_meta( $user_id, 'last_name', $last_name );
	}
}

add_action( 'peepso_register_new_user', 'siliart_peepso_register_new_user_callback' );

/**
 * If the function, `siliart_delete_users` isn't defined.
 */
if ( ! function_exists( 'siliart_delete_users' ) ) {
	/**
	 * Delete spam user registrations.
	 *
	 * @since 1.0.0
	 */
	function siliart_delete_users() {
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

/**
 * If the function, `siliart_delete_ds_store_files` isn't defined.
 */
if ( ! function_exists( 'siliart_delete_ds_store_files' ) ) {
	/**
	 * Delete .DS_Store files.
	 *
	 * @since 1.0.0
	 */
	function siliart_delete_ds_store_files() {
		// Return, if it's admin.
		if ( is_admin() ) {
			return;
		}

		$delete_ds_store_files = filter_input( INPUT_GET, 'delete_ds_store_files', FILTER_SANITIZE_NUMBER_INT );

		var_dump( $delete_ds_store_files ); die;

		// Return, if it's not Adarsh's IP address.
		if ( '183.82.162.178' !== $_SERVER['REMOTE_ADDR'] ) {
			return;
		}

		// Scan the wp directory.
		$wp_dir = siliart_scan_directory_recursive( untrailingslashit( ABSPATH ) );
		foreach ( $wp_dir as $file ) {
			$is_ds_store_file = stripos( $file, '.DS_Store' );

			if ( false === $is_ds_store_file ) continue;

			unlink( $file ); // Delete the file.
		}
		
		die("all ds store files deleted");
	}
}
/**
 * If the function, `siliart_scan_directory_recursive` isn't defined.
 */
if ( ! function_exists( 'siliart_scan_directory_recursive' ) ) {
	/**
	 * Recursively scan the directory.
	 *
	 * @param string $path Directory path.
	 *
	 * @return array
	 *
	 * @since 1.0.0
	 */
	function siliart_scan_directory_recursive( $path ) {
		$results = array();
		$entries = scandir( $path );
	
		// Loop through the entries.
		foreach ( $entries as $entry ) {
			if ( '.' === $entry || '..' === $entry ) {
				continue;
			}

			$full_path = $path . DIRECTORY_SEPARATOR . $entry;
	
			if (is_dir( $full_path ) ) {
				$results = array_merge( $results, siliart_scan_directory_recursive( $full_path ) ); // Recursive call.
			} else {
				$results[] = $full_path;
			}
		}

		return $results;
	}
}
