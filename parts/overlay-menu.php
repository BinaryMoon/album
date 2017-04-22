<?php
/**
 * Menu Overlay
 *
 * @package Terminal
 */

?>

<section class="overlay-menu">

	<?php get_search_form(); ?>

	<nav class="menu menu-primary" role="navigation" aria-label="<?php esc_attr_e( 'Primary Menu', 'terminal' ); ?>">

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

	</nav>
</section>
