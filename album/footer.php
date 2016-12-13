<?php
/**
 * Footer Template
 *
 * The template for displaying the site footer. This includes the closing divs
 * that close the content opened in header.php - and all of the content after
 * (credits, widgets etc.)
 *
 * @link https://developer.wordpress.org/themes/template-files-section/partial-and-miscellaneous-template-files/#footer-php
 *
 * @package Album
 * @subpackage TemplatePart
 * @author Ben Gillbanks <ben@prothemedesign.com>
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU Public License
 */

	// Show in footer on all but Singular pages.
	// Sidebar is also displayed on pages but is included in the
	// parts/content-single-page.php partial
	if ( ! is_singular() ) {

		get_sidebar();

	}
?>

	</div>


<?php
	get_sidebar( 'footer' );
?>

	<section class="credits">

		<div class="footer-wrap" role="contentinfo">
			<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'album' ) ); ?>" title="<?php esc_attr_e( 'A Semantic Personal Publishing Platform', 'album' ); ?>" rel="generator"><?php printf( esc_html__( 'Proudly powered by %s', 'album' ), 'WordPress' ); ?></a>
			<span class="sep"> | </span>
			<?php printf( esc_html__( 'Theme: %1$s by %2$s.', 'album' ), 'Album', '<a href="https://prothemedesign.com/" rel="designer">Pro Theme Design</a>' ); ?>
		</div>

		<?php album_social_links(); ?>

	</section>

</div>

<?php
	get_template_part( 'parts/search-overlay' );
	wp_footer();
?>

</body>
</html>
