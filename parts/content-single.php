<?php
/**
 * Single Post Content Template Partial
 *
 * This is the default content layout for all single posts (all custom post
 * types). It can be overriden by creating a new template in the parts folder
 * with the name content-single-[CUSTOM-POST-TYPE].php.
 *
 * @package Terminal
 * @subpackage TemplatePart
 * @author Ben Gillbanks <ben@prothemedesign.com>
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU Public License
 */

	$image_data = null;

	// Only display the image if enabled in the customizer.
	if ( get_theme_mod( 'terminal_display_single_featured_image', true ) || is_customize_preview() ) {

		$image_data = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'terminal-header' );
		$image_min_width = terminal_featured_image_min_width();

	}

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

<?php
	// If image is too small then insert it under the post title.
	if ( $image_data && $image_data[1] > $image_min_width ) {
		the_post_thumbnail( 'terminal-header', array( 'class' => 'terminal-featured-image' ) );
	}
?>

	<header class="entry-header">

<?php
	the_title( '<h1 class="entry-title">', '</h1>' );
	get_template_part( 'parts/post-meta' );
?>

	</header>

	<section class="entry entry-single">

<?php

	// Image is too small so insert it under the post title.
	if ( $image_data && $image_data[1] <= $image_min_width ) {
		the_post_thumbnail( 'terminal-header', array( 'class' => 'terminal-featured-image' ) );
	}

	the_content(
		sprintf(
			esc_html__( 'Read more %s', 'terminal' ),
			the_title( '<span class="screen-reader-text">', '</span>', false )
		)
	);

	wp_link_pages(
		array(
			'before'      => '<div class="pagination">',
			'after'       => '</div>',
			'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'terminal' ) . ' </span>%',
		)
	);

	// Only needed on blog posts.
	if ( is_singular( array( 'post' ) ) ) {

		terminal_author_bio();

	}
?>

	</section>

</article>

<?php

	if ( ! is_page() ) {

		the_post_navigation(
			array(
				'next_text' => '<span class="meta-nav" aria-hidden="true">' . esc_html__( 'Next', 'terminal' ) . '</span> ' .
					'<span class="screen-reader-text">' . esc_html__( 'Next', 'terminal' ) . '</span> ' .
					'<span class="post-title">%title</span>',
				'prev_text' => '<span class="meta-nav" aria-hidden="true">' . esc_html__( 'Previous', 'terminal' ) . '</span> ' .
					'<span class="screen-reader-text">' . esc_html__( 'Previous', 'terminal' ) . '</span> ' .
					'<span class="post-title">%title</span>',
			)
		);

	}
