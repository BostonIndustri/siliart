<?php
/**
 * This file represents an example of the code that themes would use to register
 * the required plugins.
 *
 * @package reign
 */

if ( ! function_exists( 'reign_register_required_plugins' ) ) {

	/**
	 * Register the required plugins for this theme.
	 *
	 * This function is hooked into `tgmpa_register`, which is fired on the WP `init` action on priority 10.
	 */
	function reign_register_required_plugins() {
		/*
		 * Array of plugin arrays. Required keys are name and slug.
		 */
		$plugins = array(
			// This is an example of how to include a plugin from an arbitrary external source in your theme.
			array(
				'name'     => 'Wbcom Essential', // The plugin name.
				'slug'     => 'wbcom-essential', // The plugin slug (typically the folder name).
				'source'   => 'https://demos.wbcomdesigns.com/exporter/plugins/wbcom-essential/3.7.3/wbcom-essential.zip', // The plugin source.
				'required' => false, // If false, the plugin is only 'recommended' instead of required.
			),
			array(
				'name'     => 'Wbcom Demo Installer', // The plugin name.
				'slug'     => 'wbcom-demo-installer', // The plugin slug (typically the folder name).
				'source'   => 'https://demos.wbcomdesigns.com/exporter/plugins/wbcom-demo-installer/2.9.4/wbcom-demo-installer.zip', // The plugin source.
				'version'  => '2.9.4',
				'required' => false,
			),
			array(
				'name'     => 'Classic Widgets',
				'slug'     => 'classic-widgets',
				'required' => false,
			),
			array(
				'name'     => 'Elementor',
				'slug'     => 'elementor',
				'required' => false,
			),
		); 

		if ( class_exists( 'BuddyPress' ) && ! class_exists( 'Youzify' ) ) {
			$plugins = array(
				// This is an example of how to include a plugin from an arbitrary external source in your theme.
				array(
					'name'     => 'Wbcom Essential', // The plugin name.
					'slug'     => 'wbcom-essential', // The plugin slug (typically the folder name).
					'source'   => 'https://demos.wbcomdesigns.com/exporter/plugins/wbcom-essential/3.7.3/wbcom-essential.zip', // The plugin source.
					'required' => false, // If false, the plugin is only 'recommended' instead of required.
				),
				array(
					'name'     => 'Wbcom Demo Installer', // The plugin name.
					'slug'     => 'wbcom-demo-installer', // The plugin slug (typically the folder name).
					'source'   => 'https://demos.wbcomdesigns.com/exporter/plugins/wbcom-demo-installer/2.9.4/wbcom-demo-installer.zip', // The plugin source.
					'version'  => '2.9.4',
					'required' => false,
				),
				array(
					'name'     => 'Classic Widgets',
					'slug'     => 'classic-widgets',
					'required' => false,
				),
				array(
					'name'     => 'Elementor',
					'slug'     => 'elementor',
					'required' => false,
				),
				array(
					'name'     => 'BuddyPress Reactions',
					'slug'     => 'buddypress-reactions',
					'source'   => 'https://demos.wbcomdesigns.com/exporter/plugins/buddypress-reactions/1.4.6/buddypress-reactions.zip', // The plugin source.
					'version'  => '1.4.6',
					'required' => false,
				),
				array(
					'name'     => 'BuddyPress Activity Share Pro',
					'slug'     => 'buddypress-activity-share-pro',
					'source'   => 'https://demos.wbcomdesigns.com/exporter/plugins/buddypress-activity-share-pro/1.2.2/buddypress-activity-share-pro.zip', // The plugin source.
					'version'  => '1.2.2',
					'required' => false,
				),
			);
		}

		// Change this to your theme text domain, used for internationalising strings.
		$theme_text_domain = 'reign';
		/**
		 * Array of configuration settings. Amend each line as needed.
		 * If you want the default strings to be available under your own theme domain,
		 * leave the strings uncommented.
		 * Some of the strings are added into a sprintf, so see the comments at the
		 * end of each line for what each argument will be.
		 */
		$config = array(
			'id'           => 'tgmpa-reign-plugins',
			// 'domain'            => $theme_text_domain,           // Text domain - likely want to be the same as your theme.
			'default_path' => '',
			// Default absolute path to pre-packaged plugins
			// 'parent_menu_slug'  => 'themes.php',         // Default parent menu slug
			// 'parent_url_slug'   => 'themes.php',         // Default parent URL slug
			'parent_slug'  => 'reign-settings', // 'themes.php',
			'menu'         => 'install-required-plugins',
			// Menu slug
			'has_notices'  => true,
			// Show admin notices or not
			'is_automatic' => true,
			// Automatically activate plugins after installation or not
			'message'      => '',
			// Message to output right before the plugins table
			'strings'      => array(
				'page_title'                      => __( 'Install Required Plugins', 'reigntm' ),
				'menu_title'                      => __( 'Install Plugins', 'reigntm' ),
				'installing'                      => __( 'Installing Plugin: %s', 'reigntm' ),
				// %1$s = plugin name
				'oops'                            => __( 'Something went wrong with the plugin API.', 'reigntm' ),
				'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'reigntm' ),
				// %1$s = plugin name(s)
				'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'reigntm' ),
				// %1$s = plugin name(s)
				'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'reigntm' ),
				// %1$s = plugin name(s)
				'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'reigntm' ),
				// %1$s = plugin name(s)
				'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'reigntm' ),
				// %1$s = plugin name(s)
				'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'reigntm' ),
				// %1$s = plugin name(s)
				'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'reigntm' ),
				// %1$s = plugin name(s)
				'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'reigntm' ),
				// %1$s = plugin name(s)
				'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'reigntm' ),
				'activate_link'                   => _n_noop( 'Activate installed plugin', 'Activate installed plugins', 'reigntm' ),
				'return'                          => __( 'Return to Required Plugins Installer', 'reigntm' ),
				'plugin_activated'                => __( 'Plugin activated successfully.', 'reigntm' ),
				'complete'                        => __( 'All plugins installed and activated successfully. %s', 'reigntm' ),
				// %1$s = dashboard link
			),
		);

		tgmpa( $plugins, $config );
	}

	add_action( 'tgmpa_register', 'reign_register_required_plugins' );
}
