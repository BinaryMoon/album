<?php
/**
 * WordPress.com Specific Functionality
 *
 * @package Terminal
 * @subpackage WordPressCom
 * @author Ben Gillbanks <ben@prothemedesign.com>
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU Public License
 */

/**
 * Add theme colours for wordpress.com custom functionality.
 *
 * @global string $themecolors
 */
function terminal_theme_colors() {

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

add_action( 'after_setup_theme', 'terminal_theme_colors' );
