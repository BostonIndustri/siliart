jQuery( document ).ready( function( $ ) {
	'use strict';

	// Add the loaded class to the woocommerce products loading overlay.
	if ( $( '.rg-woocommerce-loading-overlay' ).length ) {
		setTimeout( function() {
			$( '.rg-woocommerce-loading-overlay' ).addClass( 'loaded' );
		}, 400 );
	}
} );