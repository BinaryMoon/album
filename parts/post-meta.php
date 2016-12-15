<?php
/**
 * Post Meta Data
 *
 * @package Album
 * @subpackage TemplatePart
 * @author Ben Gillbanks <ben@prothemedesign.com>
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU Public License
 */

?>

	<div class="post-meta-data">

<?php
	album_the_main_category();

	album_post_time();

	get_template_part( 'parts/edit-post' );
?>

	</div>
