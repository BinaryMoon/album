<?php
/**
 * No Content Template Partial
 *
 * Display an empty template that lets the user know what is happening. The
 * content is contextual and varies depending upon the page it is displayed on,
 * and the person who is viewing the content.
 *
 * @link https://developer.wordpress.org/themes/template-files-section/partial-and-miscellaneous-template-files/#content-slug-php
 *
 * @package Album
 * @subpackage TemplatePart
 * @author Ben Gillbanks <ben@prothemedesign.com>
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU Public License
 */

?>
<article class="page-404 main-content post-singular no-results not-found">

	<section class="entry">

<?php
	if ( is_home() && current_user_can( 'publish_posts' ) ) {
?>

		<h1 class="entry-title"><?php esc_html_e( 'Nothing Found', 'album' ); ?></h1>

		<p><?php printf( wp_kses( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'album' ), array( 'a' => array( 'href' => array() ) ) ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>

<?php
	} if ( is_search() ) {
?>

		<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'album' ); ?></p>

		<div class="search-wrapper">
			<?php get_search_form(); ?>
		</div>

<?php
	} else {
?>

		<h1 class="entry-title"><?php esc_html_e( 'Nothing Found', 'album' ); ?></h1>

		<p><?php esc_html_e( 'It seems we can\'t find what you\'re looking for. Perhaps searching can help.', 'album' ); ?></p>

		<div class="search-wrapper">
			<?php get_search_form(); ?>
		</div>

<?php
	}
?>

	</section>

</article>
