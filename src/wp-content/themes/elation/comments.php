<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @package Elation
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>
<div id="comments" class="comments-area <?php echo sanitize_html_class( get_theme_mod( 'elation-comments-pos', customizer_library_get_default( 'elation-comments-pos' ) ) ); ?>">

    <?php
    if ( 'elation-comments-top' == get_theme_mod( 'elation-comments-pos', customizer_library_get_default( 'elation-comments-pos' ) ) ) :
        comment_form();
    endif;

	// You can start editing here -- including this comment!
	if ( have_comments() ) :
		?>
		<h2 class="comments-title">
			<?php
			$elation_comment_count = get_comments_number();
			if ( '1' === $elation_comment_count ) {
				printf(
					/* translators: 1: title. */
					esc_html__( 'One thought on &ldquo;%1$s&rdquo;', 'elation' ),
					'<span>' . esc_html( get_the_title() ) . '</span>'
				);
			} else {
				printf( // WPCS: XSS OK.
					/* translators: 1: comment count number, 2: title. */
					esc_html( _nx( '%1$s thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', $elation_comment_count, 'comments title', 'elation' ) ),
					esc_html( number_format_i18n( $elation_comment_count ) ),
					'<span>' . esc_html( get_the_title() ) . '</span>'
				);
			}
			?>
		</h2><!-- .comments-title -->

		<?php the_comments_navigation(); ?>

		<ol class="comment-list">
			<?php
			wp_list_comments( array(
				'style'      => 'ol',
				'short_ping' => true,
			) );
			?>
		</ol><!-- .comment-list -->

		<?php
		the_comments_navigation();

		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() ) :
			?>
			<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'elation' ); ?></p>
			<?php
		endif;

	endif; // Check for have_comments().

    if ( 'elation-comments-bottom' == get_theme_mod( 'elation-comments-pos', customizer_library_get_default( 'elation-comments-pos' ) ) ) :
        comment_form();
    endif;
	?>

</div><!-- #comments -->