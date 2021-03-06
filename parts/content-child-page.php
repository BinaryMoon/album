<?php
/**
 * Child Pages Listing
 *
 * @package Terminal
 * @subpackage TemplatePart
 * @author Ben Gillbanks <ben@prothemedesign.com>
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU Public License
 */

	$image = get_the_post_thumbnail( get_the_ID(), 'terminal-archive' );
?>

<div class="child-page">

<?php
	if ( $image ) {
?>

	<a href="<?php the_permalink(); ?>"><?php echo $image; ?></a>

<?php
	}

	the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );

	the_excerpt();

?>
</div>
