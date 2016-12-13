<?php
/**
 * Archive Template
 *
 * This is the fallback archive template which works for all archive types if
 * there are no specific archive templates. If there are other templates, for
 * example category.php or tag.php then these will be used instead.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Album
 * @subpackage Template
 * @author Ben Gillbanks <ben@prothemedesign.com>
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU Public License
 */

	get_header();
?>

	<main role="main">

<?php
	if ( have_posts() ) {
?>

		<header class="entry-archive-header">

<?php
		the_archive_title( '<h1 class="entry-title entry-archive-title">', '</h1>' );
		the_archive_description( '<div class="category-description">', '</div>' );
?>

		</header>

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
