<?php
/*
 |-------------------------------------------------
 | Comments template
 |-------------------------------------------------
 |
 | This is the template that displays the comment
 | area in a post or page, it contains comments
 | and comment form.
 |
 | @package wptailwind
 |
 */

# exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * return if post is password protected
 * and user is not authorized to view post
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" <?php wptw_container_class( 'mt-16' ); ?>>
	<?php if ( have_comments() ) : ?>
        <h2 class="comments-title mb-8">
			<?php
			$wptailwind_comment_count = get_comments_number();
			if ( '1' === $wptailwind_comment_count ) {
				printf(
					esc_html__( 'One Comment on &ldquo;%1$s&rdquo;', 'wptailwind' ),
					get_the_title()
				);
			} else {
				printf(
					esc_html( _nx( '%1$s Comment on &ldquo;%2$s&rdquo;', '%1$s Comments on &ldquo;%2$s&rdquo;', $wptailwind_comment_count, 'comments title', 'wptailwind' ) ),
					number_format_i18n( $wptailwind_comment_count ),
					get_the_title()
				);
			}
			?>
        </h2>
        <div class="comment-list">
			<?php
			wp_list_comments( array(
				'walker' => new WPTW_Comment_Walker(),
				'avatar_size' => 120,
				'style' => 'div',
				'short_ping' => true,
				'reply_text'  => wptw_get_icon('corner-down-right', 16) . __( ' Reply', 'wptailwind' ),
			) );
			?>
        </div>
		
		<?php
        # comments nav
        wptw_comments_nav();
    
        # comments closed notice
		if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
			?>
            <p class="no-comments bg-yellow-200 border-yellow-300 border-2 py-2 px-4">
                <?php esc_html_e( 'Comments are closed.', 'wptailwind' ); ?>
            </p>
		    <?php
		endif;
	
	endif;
	
	# comments form fields are overwritten by filters
	comment_form();
	?>
</div>
