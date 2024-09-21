/**
 * This file adds some LIVE to the Theme Customizer live preview. To leverage
 * this, set your custom settings to 'postMessage' and then add your handling
 * here. Your javascript should grab settings from customizer controls, and 
 * then make any necessary changes to the page using jQuery.
 */
( function( $ ) {

	//Update site link color in real time...
	wp.customize( 'rtm_link_color', function( value ) {
		value.bind( function( newval ) {
			$( 'a' ).css( 'color', newval );
		} );
	} );

	/* Widget Title Color */
	wp.customize( 'rtm_widget_title_color', function( value ) {
		value.bind( function( newval ) {
			$( '.widget-title' ).css( 'color', newval );
		} );
	} );

	/* Page Title Color */
	wp.customize( 'rtm_page_title_color', function( value ) {
		value.bind( function( newval ) {
			$( '.entry-title' ).css( 'color', newval );
		} );
	} );

	wp.customize( 'rtm_page_title_text_transform', function( value ) {
		value.bind( function( newval ) {
			$( '.entry-title' ).css( 'text-transform', newval );
		} );
	} );

	wp.customize( 'rtm_page_title_font_family', function( value ) {
		value.bind( function( newval ) {
			$( '.entry-title' ).css( 'font-family', newval );
		} );
	} );


	wp.customize( 'rtm_page_title_font_weight', function( value ) {
		value.bind( function( newval ) {
			$( '.entry-title' ).css( 'font-weight', newval );
		} );
	} );

	wp.customize( 'rtm_page_title_font_size', function( value ) {
		value.bind( function( newval ) {
			$( '.entry-title' ).css( 'font-size', newval+'px' );
		} );
	} );

	wp.customize( 'rtm_page_title_line_height', function( value ) {
		value.bind( function( newval ) {
			$( '.entry-title' ).css( 'line-height', newval );
		} );
	} );
	
} )( jQuery );
