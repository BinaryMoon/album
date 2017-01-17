<?php
/**
 * Single Post Content Template Partial
 *
 * This is the default content layout for all single posts (all custom post
 * types). It can be overriden by creating a new template in the parts folder
 * with the name content-single-[CUSTOM-POST-TYPE].php.
 *
 * @package Album
 * @subpackage TemplatePart
 * @author Ben Gillbanks <ben@prothemedesign.com>
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU Public License
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php the_post_thumbnail( 'album-header' ); ?>

	<header class="entry-header">

<?php
	the_title( '<h1 class="entry-title">', '</h1>' );
	get_template_part( 'parts/post-meta' );
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

	// Only needed on blog posts.
	if ( is_singular( array( 'post' ) ) ) {

		album_contributor();

	}
?>

	</section>

</article>

<?php

	if ( ! is_page() ) {

		the_post_navigation(
			array(
				'next_text' => '<span class="meta-nav" aria-hidden="true">' . esc_html__( 'Next', 'album' ) . '</span> ' .
					'<span class="screen-reader-text">' . esc_html__( 'Next', 'album' ) . '</span> ' .
					'<span class="post-title">%title</span>',
				'prev_text' => '<span class="meta-nav" aria-hidden="true">' . esc_html__( 'Previous', 'album' ) . '</span> ' .
					'<span class="screen-reader-text">' . esc_html__( 'Previous', 'album' ) . '</span> ' .
					'<span class="post-title">%title</span>',
			)
		);

	}
