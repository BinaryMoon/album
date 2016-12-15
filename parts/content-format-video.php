<?php
/**
 * Video Content Template Partial
 *
 * Used to display video post format on archive pages.
 *
 * Uses `parts/content.php` as a fallback if no videos are found.
 *
 * @package Album
 * @subpackage TemplatePart
 * @author Ben Gillbanks <ben@prothemedesign.com>
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU Public License
 */

	$content = apply_filters( 'the_content', get_the_content() );
	$video = get_media_embedded_in_content( $content, array( 'video', 'object', 'embed', 'iframe' ) );

	if ( ! $video ) {

		get_template_part( 'parts/content' );
		return;

	}

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

<?php

	echo album_video_wrapper( $video[0] );

	get_template_part( 'parts/post-meta' );

?>

	<section class="entry entry-archive">

<?php

	the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );

	the_excerpt();

?>

		<p><a href="<?php the_permalink(); ?>" class="read-more"><?php album_read_more_text(); ?></a></p>

	</section>

</article>
