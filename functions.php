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
