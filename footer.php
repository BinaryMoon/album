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
 * @package Terminal
 * @subpackage TemplatePart
 * @author Ben Gillbanks <ben@prothemedesign.com>
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU Public License
 */

	get_sidebar();
?>

	</div>


<?php
	get_sidebar( 'footer' );
?>

	<section class="credits">

		<?php terminal_social_links(); ?>

		<div class="footer-wrap" role="contentinfo">
			<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'terminal' ) ); ?>" title="<?php esc_attr_e( 'A Semantic Personal Publishing Platform', 'terminal' ); ?>" rel="generator"><?php printf( esc_html__( 'Proudly powered by %s', 'terminal' ), 'WordPress' ); ?></a>
			<span class="sep"> | </span>
			<?php printf( esc_html__( 'Theme: %1$s by %2$s.', 'terminal' ), 'Terminal', '<a href="https://prothemedesign.com/" rel="designer">Pro Theme Design</a>' ); ?>
		</div>

	</section>

</div>

<?php
	get_template_part( 'parts/overlay-menu' );
	wp_footer();
?>

</body>
</html>
