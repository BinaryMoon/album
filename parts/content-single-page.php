<?php
/**
 * Page Content Template Partial
 *
 * Display page content.
 *
 * @package Album
 * @subpackage TemplatePart
 * @author Ben Gillbanks <ben@prothemedesign.com>
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU Public License
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header">

<?php
	get_template_part( 'parts/post-cover' );
?>

	</header>

	<section class="entry entry-single">

<?php
	the_content(
		sprintf(
			esc_html__( 'Read more %s', 'album' ),
			the_title( '<span class="screen-reader-text">', '</span>', false )
		)
	);

	wp_link_pages(
		array(
			'before'      => '<div class="pagination">',
			'after'       => '</div>',
			'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'album' ) . ' </span>%',
		)
	);

	get_sidebar();
?>

	</section>

</article>
