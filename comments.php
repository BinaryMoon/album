<?php
/**
 * Comments Template
 *
 * Displays the comments, and the comment submission form.
 *
 * @link https://developer.wordpress.org/themes/template-files-section/partial-and-miscellaneous-template-files/#comments-php
 *
 * @package Album
 * @subpackage TemplatePart
 * @author Ben Gillbanks <ben@prothemedesign.com>
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU Public License
 */

	if ( post_password_required() ) {
		return;
	}
?>

	<section class="content-comments">

<?php
	if ( have_comments() ) {
?>

		<h2 id="comments" class="comments-title">

<?php
		$comment_count = get_comments_number();
		if ( 1 === $comment_count ) {
			printf(
				esc_html_e( 'One thought on &ldquo;%1$s&rdquo;', 'album' ),
				'<span>' . get_the_title() . '</span>'
			);
		} else {
			printf( // WPCS: XSS OK.
				esc_html( _nx( '%1$s thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', $comment_count, 'comments title', 'album' ) ),
				number_format_i18n( $comment_count ),
				'<span>' . get_the_title() . '</span>'
			);
		}
?>

			<a href="#respond" class="scroll-to">
				<span class="screen-reader-text"><?php esc_html_e( 'Leave a comment', 'album' ); ?></span>
				<?php esc_html_e( '&rsaquo;', 'album' ); ?>
			</a>

		</h2>

		<ol class="comment-list" id="singlecomments">

<?php
		wp_list_comments(
			array(
				'avatar_size' => 80,
				'short_ping' => true,
				'reply_text' => album_svg( 'reply', false ) . '<span class="screen-reader-text">' . esc_html__( 'Reply', 'album' ) . '</span>',
			)
		);
?>

		</ol>

<?php
		the_comments_navigation();

	} // End if().

	if ( 'open' === $post->comment_status ) {

		comment_form(
			array(
				'title_reply_before' => '<h2 class="comment-reply-title">',
				'title_reply_after'  => '</h2>',
				'cancel_reply_before' => '',
				'cancel_reply_after' => '',
				'cancel_reply_link' => album_svg( 'close', false ) . '<span class="screen-reader-text">' . esc_html__( 'Cancel Reply', 'album' ) . '</span>',
			)
		);

	}
?>

		<div class="user-icon-container">
			<?php album_svg( 'user' ); ?>
		</div>

	</section>