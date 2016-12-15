<?php
/**
 * Custom Header
 *
 * @link https://developer.wordpress.org/themes/functionality/custom-headers/
 *
 * @package Album
 * @subpackage CustomHeader
 * @author Ben Gillbanks <ben@prothemedesign.com>
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU Public License
 */

/**
 * Add theme support for Custom Header image.
 *
 * Sets the default properties and the custom header callback {@see album_colour_styles}.
 */
function album_custom_header_support() {

	add_theme_support(
		'custom-header',
		apply_filters(
			'album_custom_header',
			array(
				// 'default-image' => '%s/images/x.jpg',
				'default-text-color' => '000000',
				'random-default' => false,
				'width' => 1500,
				'height' => 500,
				'flex-height' => true,
				'header-text' => true,
				'uploads' => true,
				'wp-head-callback' => 'album_colour_styles',
			)
		)
	);

}

add_action( 'after_setup_theme', 'album_custom_header_support' );


/**
 * Print custom header styles.
 *
 * May also change other CSS properties related to the header colours.
 */
function album_colour_styles() {

?>
<style>
<?php
	if ( ! display_header_text() ) {
?>
	.masthead .site-name {
		clip: rect( 1px, 1px, 1px, 1px );
		position: absolute;
	}
<?php
	} else {
?>
	.masthead .site-title,
	.masthead .site-title a,
	.masthead .site-title a:hover,
	.masthead p.site-description {
		color: #<?php echo esc_attr( get_header_textcolor() ); ?>;
	}
<?php
	}
?>
</style>
<?php

}
