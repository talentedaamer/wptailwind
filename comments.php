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

/**
 * exit if accessed directly
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * return of post is password protected
 * and user is not authorized to view post
 */
if ( post_password_required() ) {
	return;
}
?>

<?php
if ( have_comments() ) :
	?>
    <h2 class="comments-title">
		<?php
		// TODO: manage zero comments also
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
	<?php
	
	the_comments_navigation();
	
	wp_list_comments( array(
		'short_ping' => TRUE,
	) );
	
	the_comments_navigation();
	
	if ( ! comments_open() ) :
		esc_html_e( 'Comments closed.', 'wptailwind' );
	endif;

endif;

comment_form();
?>