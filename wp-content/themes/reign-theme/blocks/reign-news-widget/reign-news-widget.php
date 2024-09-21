<?php
/**
 * Register the reign news block.
 *
 * @package Reign
 */

/**
 * Enqueue scripts for the Reign News Widget.
 *
 * This function enqueues the necessary scripts for the Reign News Widget
 * depending on whether it is being viewed in the admin area or on the frontend.
 */
function reign_news_widget_enqueue_scripts() {
	if ( is_admin() ) {
		// Enqueue editor script.
		wp_enqueue_script(
			'reign-news-widget-editor',
			get_template_directory_uri() . '/blocks/reign-news-widget/build/index.js',
			array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor' ), // WordPress editor dependencies.
			'1.0.0',
			true
		);
	} else {
		// Enqueue frontend script.
		wp_enqueue_script(
			'reign-news-widget-frontend',
			get_template_directory_uri() . '/blocks/reign-news-widget/build/frontend.js',
			array(), // No WordPress editor dependencies.
			'1.0.0',
			true
		);
	}
}
add_action( 'wp_enqueue_scripts', 'reign_news_widget_enqueue_scripts' );


/**
 * Add this function to initialize the "reign-news-widget" block.
 */
function reign_news_widget_block_init() {
	// Register the block type using metadata from the current directory.
	register_block_type_from_metadata( __DIR__ );
}

// Hook the block initialization function to the appropriate action.
add_action( 'init', 'reign_news_widget_block_init' );
