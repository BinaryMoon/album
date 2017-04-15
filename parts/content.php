<?php
/**
 * Generic Content Template Partial
 *
 * Is used for image post formats since the layout would be the same for both
 *
 * @package Terminal
 * @subpackage TemplatePart
 * @author Ben Gillbanks <ben@prothemedesign.com>
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU Public License
 */

	$image = get_the_post_thumbnail( get_the_ID(), 'terminal-archive' );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

<?php
	if ( $image ) {
?>

	<a href="<?php echo esc_url( get_permalink() ); ?>" class="thumbnail">
		<?php echo $image; // WPCS: XSS OK. ?>
	</a>

<?php
	}
?>

	<header>
<?php
		the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		get_template_part( 'parts/post-meta' );
?>
	</header>

	<section class="entry entry-archive">

		<?php the_excerpt(); ?>

		<p><a href="<?php the_permalink(); ?>" class="read-more"><?php terminal_read_more_text(); ?></a></p>

	</section>

</article>
