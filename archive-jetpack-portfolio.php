<?php
/**
 * Portfolio Archive Template
 *
 * This is the template used to display Jetpack Projects post type.
 *
 * @link https://jetpack.com/support/custom-content-types/
 *
 * @package Album
 * @subpackage Template
 * @author Ben Gillbanks <ben@prothemedesign.com>
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU Public License
 */

	get_header();
?>

	<header class="entry-archive-header">

<?php
	the_archive_title( '<h1 class="entry-title entry-archive-title">', '</h1>' );
	the_archive_description( '<div class="category-description">', '</div>' );
	album_project_terms();
?>

	</header>

	<main role="main" class="jetpack-projects-archive">

<?php
	if ( have_posts() ) {
?>

		<div id="main-content" class="main-content content-posts content-projects">

<?php
		while ( have_posts() ) {
			the_post();
			get_template_part( 'parts/content', 'project' );
		}
?>

		</div>

<?php
		the_posts_pagination(
			array(
				'mid_size' => 2,
				'prev_text' => esc_html__( 'Older', 'album' ),
				'next_text' => esc_html__( 'Newer', 'album' ),
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
