<?php
/**
 * Search Results Template
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Terminal
 * @subpackage Template
 * @author Ben Gillbanks <ben@prothemedesign.com>
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU Public License
 */

	get_header();
?>

	<header class="entry-archive-header">

		<h1 class="entry-title entry-archive-title">
			<?php printf( wp_kses( __( '<span>Search results for:</span> %s', 'terminal' ), array( 'span' => array() ) ), esc_html( get_search_query() ) ); ?>
		</h1>

	</header>

	<main role="main">

<?php
	if ( have_posts() ) {
?>

		<div class="search-wrapper">
			<?php get_search_form(); ?>
		</div>

		<div id="main-content" class="main-content content-posts">

<?php
		while ( have_posts() ) {

			the_post();
			get_template_part( 'parts/content', 'format-' . get_post_format() );

		}
?>

		</div>

<?php
		the_posts_pagination(
			array(
				'mid_size' => 2,
				'prev_text' => esc_html__( 'Older', 'terminal' ),
				'next_text' => esc_html__( 'Newer', 'terminal' ),
			)
		);

	} else {
?>

		<div class="main-content">

			<?php get_template_part( 'parts/content-empty' ); ?>

		</div>

<?php
	} // End if().
?>

	</main>

<?php
	get_footer();
