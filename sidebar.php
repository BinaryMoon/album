<?php
/**
 * Sidebar Template
 *
 * Display the sidebar widgets. Will not output anything if there's no widgets
 * assigned to specified sidebar.
 *
 * Also includes the `before_sidebar` hook. This is used by
 * {@link wordpress.com} to display WordAds {@link https://wordads.co}.
 *
 * A body class is added if the theme has widgets to display here
 * {@see album_body_class}. This helps with custom css that adjusts the page
 * when no widgets exist.
 *
 * @link https://developer.wordpress.org/themes/template-files-section/partial-and-miscellaneous-template-files/#sidebar-php
 *
 * @package Album
 * @subpackage TemplatePart
 * @author Ben Gillbanks <ben@prothemedesign.com>
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU Public License
 */

	// Don't display on single posts/ pages.
	if ( is_singular() ) {
		return;
	}

	// Don't display on portfolio/ projects archives.
	if ( is_post_type_archive( 'jetpack-portfolio' ) ) {
		return;
	}

	if ( is_tax( 'jetpack-portfolio-type' ) ) {
		return;
	}

	if ( is_404() ) {
		return;
	}

	// Make sure the sidebar is active.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		return;
	}
?>

<!-- Sidebar Main (1) -->

<aside class="sidebar sidebar-main" role="complementary">

<?php
	do_action( 'before_sidebar' );
	dynamic_sidebar( 'sidebar-1' );
?>

</aside>
