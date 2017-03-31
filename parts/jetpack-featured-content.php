<?php
/**
 * Jetpack Featured Content
 *
 * @link https://jetpack.me/support/featured-content/
 *
 * @package Terminal
 * @subpackage TemplatePart
 * @author Ben Gillbanks <ben@prothemedesign.com>
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU Public License
 */

	if ( terminal_has_featured_posts() ) {

		$featured_posts = terminal_get_featured_posts( 4 );
?>

	<section class="showcase">

<?php
		foreach ( $featured_posts as $post ) {

			setup_postdata( $post );
?>

		<article <?php post_class(); ?>>
			<?php get_template_part( 'parts/post-cover' ); ?>
		</article>

<?php
		}
?>

	</section>

<?php
		wp_reset_postdata();
	} // End if().
