<?php
/**
 * Edit Post Link
 *
 * @package Album
 * @subpackage TemplatePart
 * @author Ben Gillbanks <ben@prothemedesign.com>
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU Public License
 */

	edit_post_link(
		sprintf(
			/* translators: %s: Name of current post */
			wp_kses( __( 'Edit<span class="screen-reader-text"> %s</span>', 'album' ), array( 'span' => array( 'class' => array() ) ) ),
			get_the_title()
		),
		'&nbsp;&nbsp;<span class="edit-link meta">',
		'</span>'
	);
