<?php
/**
 * Child page grid Template
 *
 * Displays children of the current page as a grid below the page content.
 *
 * Template Name: Child Page Grid
 *
 * @package Terminal
 * @subpackage PageTemplate
 * @author Ben Gillbanks <ben@prothemedesign.com>
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU Public License
 */

	get_header();

	get_template_part( 'parts/featured-content' );
?>

	<main role="main" class="full-width">

		<div class="main-content content-single">

<?php
	if ( have_posts() ) {

		while ( have_posts() ) {

			the_post();

			get_template_part( 'parts/content-single', get_post_type() );

		}
	}
?>

		</div>

<?php

	// Get a list of the children for the current page.
	$child_pages = terminal_child_pages();

	// If there are any children then display them below in a grid.
	if ( $child_pages->have_posts() ) {
?>

		<section class="entry-children">

<?php
		while ( $child_pages->have_posts() ) {

			$child_pages->the_post();

			get_template_part( 'parts/content-child-page' );

		}
?>

		</section>

<?php
	}

	wp_reset_postdata();
?>

	</main>

<?php
	get_footer();
