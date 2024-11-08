<?php
/**
 * The widgets factory class for Reign SDK
 *
 * @package     ReignSDK
 * @subpackage  Widgets
 * @copyright   Copyright (c) 2017, Marius Cristea
 * @license     http://opensource.org/licenses/gpl-3.0.php GNU Public License
 * @since Menu Icons      1.0.0
 */
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( ! class_exists( 'Reign_SDK_Widgets_Factory' ) ) :
	/**
	 * Widgets factory model for Reign SDK.
	 */
	class Reign_SDK_Widgets_Factory {

		/**
		 * Reign_SDK_Widgets_Factory constructor.
		 *
		 * @param Reign_SDK_Product $product_object Product Object.
		 * @param array                 $widgets the widgets.
		 */
		public function __construct( $product_object, $widgets ) {
			if ( $product_object instanceof Reign_SDK_Product && $widgets && is_array( $widgets ) ) {
				foreach ( $widgets as $widget ) {
					$class    = 'Reign_SDK_Widget_' . str_replace( ' ', '_', ucwords( str_replace( '_', ' ', $widget ) ) );
					$instance = new $class( $product_object );
					$instance->setup_hooks();
				}
			}
		}
	}
endif;
