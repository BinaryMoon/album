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
	 * Set a default theme color array for WordPress.com.
	 *
	 * @global array $themecolors
	 */
	if ( ! isset( $themecolors ) ) {

		$themecolors = array(
			'bg'     => 'F1F2F6',
			'border' => 'E8E9EE',
			'text'   => '000000',
			'link'   => '58c6ff',
			'url'    => 'BfC1CC',
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

			if ( $custom_fonts['headings']['id'] && $custom_fonts['body-text']['id'] ) {
				unset( $fonts );
			}
		}
	}

	return $fonts;

}

add_action( 'album_fonts', 'album_dequeue_fonts', 11 );
