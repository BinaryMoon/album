<?php
/**
 * Post Meta Data
 *
 * @package Terminal
 * @subpackage TemplatePart
 * @author Ben Gillbanks <ben@prothemedesign.com>
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU Public License
 */

?>

	<div class="post-meta-data">

<?php
	terminal_the_main_category();

	terminal_post_time();

	get_template_part( 'parts/edit-post' );
?>

	</div>
