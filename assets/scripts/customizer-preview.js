/**
 * Live-update changed settings in real time in the Customizer preview.
 *
 * Filename: customizer-preview.js v1
 *
 * Created by Ben Gillbanks <https://prothemedesign.com/>
 * Available under GPL2 license
 *
 * @link https://developer.wordpress.org/themes/advanced-topics/customizer-api/#javascript-driven-widget-support
 *
 * @package Terminal
 */
/* global jQuery, document, wp */

;( function( $, document ) {

	$( document ).ready( function() {

		// Site title.
		wp.customize( 'blogname', function( value ) {
			value.bind( function( to ) {
				$( '.site-title' ).text( to );
			} );
		} );

		// Site description.
		wp.customize( 'blogdescription', function( value ) {
			value.bind( function( to ) {
				$( '.site-description' ).text( to );
			} );
		} );

		// Header text color.
		wp.customize( 'header_textcolor', function( value ) {
			value.bind( function( to ) {
				if ( 'blank' === to ) {
					$( '.masthead .site-name' ).css( {
						'clip': 'rect(1px, 1px, 1px, 1px)',
						'position': 'absolute'
					} );
				} else {
					$( '.masthead .site-name' ).css( {
						'clip': 'auto',
						'position': 'relative'
					} );
					$( '.masthead .site-title, .masthead .site-title a, .masthead .site-title a:hover, .masthead p.site-description' ).css( {
						'color': to
					} );
				}
			} );
		} );

		// Header text color.
		wp.customize( 'terminal_display_single_excerpt', function( value ) {
			value.bind( function( to ) {

				if ( to ) {
					$( '.intro-excerpt' ).show();
				} else {
					$( '.intro-excerpt' ).hide();
				}

			} );
		} );



		// Header text color.
		wp.customize( 'terminal_display_single_featured_image', function( value ) {
			value.bind( function( to ) {

				if ( to ) {
					$( 'img.terminal-featured-image' ).show();
					$( 'article' ).addClass( 'post-has-thumbnail' );
					$( 'article' ).removeClass( 'post-no-thumbnail' );
				} else {
					$( 'img.terminal-featured-image' ).hide();
					$( 'article' ).removeClass( 'post-has-thumbnail' );
					$( 'article' ).addClass( 'post-no-thumbnail' );
				}

			} );
		} );

	} );

} )( jQuery, document );
