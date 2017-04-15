<?php
/**
 * Header Template
 *
 * Display the site header content (logo, site title, description). Also houses
 * the site head.
 *
 * The head is kept as small as is reasonably possible. Any head content
 * should be hooked into the wp_head filter.
 *
 * Styles and scripts and enqueued through the {@se terminal_enqueue} function found
 * in inc/wordpress.php
 *
 * @link https://developer.wordpress.org/themes/template-files-section/partial-and-miscellaneous-template-files/#header-php
 *
 * @package Terminal
 * @subpackage TemplatePart
 * @author Ben Gillbanks <ben@prothemedesign.com>
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU Public License
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<div class="webpage">

	<a href="#site-content" class="screen-reader-shortcut"><?php esc_html_e( 'Skip to content', 'terminal' ); ?></a>

	<header class="masthead" id="header" role="banner">

		<div class="branding">
<?php
	the_custom_logo();

	if ( is_front_page() && ! is_paged() ) {
?>
			<h1 class="site-title">
				<?php bloginfo( 'name' ); ?>
			</h1>
<?php
	} else {
?>
			<p class="site-title">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
			</p>
<?php
	}

	// Get site description.
	$description = get_bloginfo( 'description', 'display' );

	if ( $description || is_customize_preview() ) {
?>
			<p class="site-description">
				<?php echo $description; /* WPCS: xss ok. */ ?>
			</p>
<?php
	}
?>

		</div>

		<nav class="menu menu-primary" role="navigation" aria-label="<?php esc_attr_e( 'Primary Menu', 'terminal' ); ?>">

			<button class="menu-toggle" type="button" aria-controls="primary-menu" aria-expanded="false">
<?php
	esc_html_e( 'Menu', 'terminal' );
	terminal_svg( 'menu-rows' );
?>
			</button>

<?php
	wp_nav_menu(
		array(
			'theme_location' => 'menu-1',
			'menu_id' => 'nav',
			'menu_class' => 'menu-wrap',
			'container' => false,
			'item_spacing' => 'discard',
		)
	);
?>

			<button type="button" class="search-toggle">
<?php
	esc_html_e( 'Search', 'terminal' );
	terminal_svg( 'search' );
?>
			 </button>

		</nav>

	</header>

<?php

	the_header_image_tag(
		array(
			'class' => 'terminal-header-image',
		)
	);

	do_action( 'before' );

?>

	<div class="container" id="site-content">
<?php

	get_template_part( 'parts/jetpack-featured-content' );
