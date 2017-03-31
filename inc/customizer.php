<?php
/**
 * Theme Customizer
 *
 * @link https://developer.wordpress.org/themes/advanced-topics/customizer-api/
 *
 * @package Terminal
 * @subpackage ThemeCustomizerSettings
 * @author Ben Gillbanks <ben@prothemedesign.com>
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU Public License
 */

/**
 * Exit if we're not in the Customizer.
 */
if ( ! class_exists( 'WP_Customize_Control' ) ) {

	return null;

}


/**
 * Theme Customizer properties
 *
 * @param WP_Customize_Manager $wp_customize WP Customize object. Passed by WordPress.
 */
function terminal_customizer_settings( WP_Customize_Manager $wp_customize ) {

	/**
	 * Terminal theme options section.
	 */
	$wp_customize->add_section(
		'terminal_options',
		array(
			'title' => esc_html__( 'Theme Options', 'terminal' ),
		)
	);

	/**
	 * Setting to control whether the slider autoplays or not.
	 */
	$wp_customize->add_setting(
		'terminal_autoplay_slider',
		array(
			'default' => false,
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'terminal_sanitize_checkboxes',
		)
	);

	$wp_customize->add_control(
		'terminal_autoplay_slider',
		array(
			'label' => esc_html__( 'Autoplay the Featured Content Slider', 'terminal' ),
			'section' => 'terminal_options',
			'type' => 'checkbox',
		)
	);

	/**
	 * Setting to control whether the featured image is displayed on single
	 * posts or not.
	 */
	$wp_customize->add_setting(
		'terminal_display_single_featured_image',
		array(
			'default' => true,
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'terminal_sanitize_checkboxes',
			'transport' => 'postMessage',
		)
	);

	$wp_customize->add_control(
		'terminal_display_single_featured_image',
		array(
			'label' => esc_html__( 'Display the Featured Image on Single posts and pages', 'terminal' ),
			'section' => 'terminal_options',
			'type' => 'checkbox',
		)
	);

	/**
	 * Setting to control whether the excerpt is displayed on single posts.
	 */
	$wp_customize->add_setting(
		'terminal_display_single_excerpt',
		array(
			'default' => true,
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'terminal_sanitize_checkboxes',
			'transport' => 'postMessage',
		)
	);

	$wp_customize->add_control(
		'terminal_display_single_excerpt',
		array(
			'label' => esc_html__( 'Prominently display the Excerpt on blog posts.', 'terminal' ),
			'section' => 'terminal_options',
			'type' => 'checkbox',
		)
	);

}

add_action( 'customize_register', 'terminal_customizer_settings' );


/**
 * Update Theme Elements without refreshing content.
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function terminal_register_customize_refresh( WP_Customize_Manager $wp_customize ) {

	// Ensure selective refresh is enabled.
	if ( ! isset( $wp_customize->selective_refresh ) ) {

		return false;

	}

	// Update site title.
	$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';

	$wp_customize->selective_refresh->add_partial(
		'blogname',
		array(
			'selector' => '.site-title',
			'type' => 'text',
			'render_callback' => function() {
				bloginfo( 'name' );
			},
		)
	);

	// Update site description.
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

	$wp_customize->selective_refresh->add_partial(
		'blogdescription',
		array(
			'selector' => '.site-description',
			'render_callback' => function() {
				bloginfo( 'description' );
			},
		)
	);

	// Show and hide header text.
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

}

add_action( 'customize_register', 'terminal_register_customize_refresh' );


/**
 * Binds JS handlers to make the Customizer preview reload changes asynchronously.
 */
function terminal_customize_preview_js() {

	wp_enqueue_script( 'terminal-customize-preview', get_template_directory_uri() . '/assets/scripts/customizer-preview.js', array( 'customize-preview' ), '1.0', true );

}

add_action( 'customize_preview_init', 'terminal_customize_preview_js' );


/**
 * Sanitize checkbox input
 *
 * @param boolean $setting Value to check and sanitize.
 * @return boolean
 */
function terminal_sanitize_checkboxes( $setting ) {

	return (bool) $setting;

}
