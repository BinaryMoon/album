<?php
/**
 * Blog post title
 *
 * Assigns a background image that fades as the user scrolls
 *
 * @package Album
 * @subpackage TemplatePart
 * @author Ben Gillbanks <ben@prothemedesign.com>
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU Public License
 */

	$styles = array();
	$image = album_archive_image_url( get_the_ID(), 'album-post-cover' );
	$title_tag = 'h2';

	if ( is_singular() || is_front_page() ) {
		$title_tag = 'h1';
	}

	if ( $image ) {

		$styles = array(
			'background-image: url(' . esc_url( $image ) . ');'
		);

	}

?>
<div class="post-cover">

	<div style="<?php echo esc_attr( implode( ' ', $styles ) ); ?>" class="post-image"></div>

	<div class="entry">

		<?php if ( is_page() ) { album_breadcrumbs(); } ?>

		<a href="<?php the_permalink(); ?>" rel="bookmark">
			<?php the_title( '<' . $title_tag . ' class="entry-title">', '</' . $title_tag . '>' ); ?>
		</a>

	</div>

	<?php get_template_part( 'parts/edit-post' ); ?>

</div>
