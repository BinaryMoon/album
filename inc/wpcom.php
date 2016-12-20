<?php
/**
 * WordPress.com Specific Functionality
 *
 * @package Album
 * @subpackage WordPressCom
 * @author Ben Gillbanks <ben@prothemedesign.com>
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU Public License
 */

/**
 * Add theme colours for wordpress.com custom functionality.
 *
 * @global string $themecolors
 */
function album_theme_colors() {

	global $themecolors;

	/**
	 * Set a default theme color array for WP.com.
	 *
	 * @global array $themecolors
	 */
	if ( ! isset( $themecolors ) ) {

		$themecolors = array(
			'bg'     => 'ffffff',
			'border' => 'eeeeee',
			'text'   => '000000',
			'link'   => 'xxxxxx',
			'url'    => 'aaaaaa',
		);

	}

}

add_action( 'after_setup_theme', 'album_theme_colors' );


/**
 * Dequeue Google Fonts if wordpress.com Custom Fonts are being used instead.
 *
 * @param array $fonts Array of fonts being used in the theme.
 * @return array
 */
function album_dequeue_fonts( $fonts ) {

	if ( class_exists( 'TypekitData' ) && class_exists( 'CustomDesign' ) && CustomDesign::is_upgrade_active() ) {

	    $custom_fonts = TypekitData::get( 'families' );

		if ( $custom_fonts ) {

			if ( $custom_fonts['headings']['id'] ) {
				unset( $fonts['key'] );
			}

			if ( $custom_fonts['body-text']['id'] ) {
				unset( $fonts['key'] );
			}
		}
	}

	return $fonts;

}

add_action( 'album_fonts', 'album_dequeue_fonts', 11 );


/**
 * Add a class to the body letting wordpress.com know about the usage of widgets in an overlay.
 *
 * @param  array $classes Default list of body classes.
 * @return array          Modified list of body classes.
 */
function album_widgets_overlay_body_class( $classes ) {

	$classes[] = 'widgets-hidden';

	return $classes;

}

add_filter( 'body_class', 'album_widgets_overlay_body_class' );