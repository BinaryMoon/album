<?php
/**
 * Theme Functions Engine.
 *
 * This file is simply used as a wrapper to load other files that do all the
 * work.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 *
 * @package Terminal
 * @subpackage Template
 * @author Ben Gillbanks <ben@prothemedesign.com>
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU Public License
 */

/**
 * TO BUILD
 *
 * Add sidebar to single post pages
 * Add full width template
 * Change next and previous post links on single posts
 * Add &rarr to 'read more' link on blog post listing
 * standardize post title design using post-cover layout
 * fix projects header layout
 * standardize projects menu font styles
 * 
 */

/**
 * TODO BEFORE SUBMISSION
 * ---
 * test theme with and without jetpack
 * test theme with and without infinite scroll
 * delete unused scripts
 * delete unused customizer controls
 * delete unused svgs
 * theme tags
 * theme description
 * screenshot.png (880 x 660)
 * check custom header size
 * check sticky styles
 * test custom header, with and without
 * responsive styles
 * set content_width (in granule_content_width and granule_after_setup_theme)
 * theme_colors
 * check custom page template styles
 * check custom logo properties are appropriate
 * rtl.css - "gulp rtl --theme granule"
 * change google font slugs so they match the font names (in granule_fonts() inc/wordpress.php and inc/wpcom.php)
 * theme scan
 * test site logo
 * readme.txt
 * test hiding header and description through customizer works
 * test logo is still visible when you hide the header text
 * test custom header
 * test custom backgrounds
 * remove granule_widgets_overlay_body_class function there are no widgets in an overlay
 * check all registered menus are being used
 * check sidebar names and that sidebar display conditions match the sidebars they display
 * test print styles
 * go through required accessibility items - https://make.wordpress.org/themes/handbook/review/accessibility/required/
 */


// WordPress specific functionality (actions and filters).
include( 'inc/wordpress.php' );

// Custom header.
include( 'inc/custom-header.php' );

// Reusable Template Functions.
include( 'inc/template-tags.php' );

// Jetpack specific functionality.
include( 'inc/jetpack.php' );

// Wordpress.com specific functionality.
include( 'inc/wpcom.php' );

// Customizer controls for setting theme properties.
include( 'inc/customizer.php' );
