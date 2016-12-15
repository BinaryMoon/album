<?php
/**
 * Search box overlay
 *
 * @package Album
 * @subpackage TemplatePart
 * @author Ben Gillbanks <ben@prothemedesign.com>
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU Public License
 */

?>
<div class="modal search-modal">
	<button type="button" class="close"><?php album_svg( 'close' ); ?><span class="screen-reader-text"><?php esc_html_e( 'Close Search Overlay', 'album' ); ?></span></button>
	<?php get_search_form(); ?>
</div>
