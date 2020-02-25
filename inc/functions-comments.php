<?php
/*
 |-------------------------------------------------
 | Comments Functions
 |-------------------------------------------------
 |
 | Filter comments form fields, textarea and other
 | comments related functions.
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

add_filter( 'comment_form_default_fields', 'wptw_comment_form_fields' );
function wptw_comment_form_fields( $fields ) {
	$commenter = wp_get_current_commenter();
	$req       = get_option( 'require_name_email' );
	$html_req  = ( $req ? " required='required'" : '' );
	$is_html5  = current_theme_supports( 'html5', 'comment-form' ) ? 1 : 0;
	
	$fields = array(
		'author' => sprintf(
			'<div class="flex -mx-4 mb-4"><div class="field-group comment-form-author sm:w-1/3 md:w-1/3 lg:w-1/3 xl:w-1/3 px-4">%s %s</div>',
			sprintf(
				'<label for="author">%s%s</label>',
				__( 'Name' ),
				( $req ? ' <span class="required">*</span>' : '' )
			),
			sprintf(
				'<input class="wptw-input w-full" id="author" name="author" type="text" value="%s" size="30" maxlength="245"%s />',
				esc_attr( $commenter[ 'comment_author' ] ),
				$html_req
			)
		),
		'email'  => sprintf(
			'<div class="field-group comment-form-email sm:w-1/3 md:w-1/3 lg:w-1/3 xl:w-1/3 px-4">%s %s</div>',
			sprintf(
				'<label for="email">%s%s</label>',
				__( 'Email' ),
				( $req ? ' <span class="required">*</span>' : '' )
			),
			sprintf(
				'<input class="wptw-input w-full" id="email" name="email" %s value="%s" size="30" maxlength="100" aria-describedby="email-notes"%s />',
				( $is_html5 ? 'type="email"' : 'type="text"' ),
				esc_attr( $commenter[ 'comment_author_email' ] ),
				$html_req
			)
		),
		'url'    => sprintf(
			'<div class="field-group comment-form-url sm:w-1/3 md:w-1/3 lg:w-1/3 xl:w-1/3 px-4">%s %s</div></div>',
			sprintf(
				'<label for="url">%s</label>',
				__( 'Website' )
			),
			sprintf(
				'<input class="wptw-input w-full" id="url" name="url" %s value="%s" size="30" maxlength="200" />',
				( $is_html5 ? 'type="url"' : 'type="text"' ),
				esc_attr( $commenter[ 'comment_author_url' ] )
			)
		),
	);
	
	return $fields;
}

add_filter( 'comment_form_defaults', 'wptw_comment_form' );
function wptw_comment_form( $args ) {
	$req           = get_option( 'require_name_email' );
	$required_text = sprintf(
		' ' . __( 'Required fields are marked %s' ),
		'<span class="required">*</span>'
	);
	
	$args[ 'comment_notes_before' ] = sprintf(
		'<p class="comment-notes mb-4">%s%s</p>',
		sprintf(
			'<span id="email-notes">%s</span>',
			__( 'Your email address will not be published.' )
		),
		( $req ? $required_text : '' )
	);
	$args[ 'comment_field' ]        = sprintf(
		'<div class="field-wrap comment-form-comment mb-4">%s %s</div>',
		sprintf(
			'<label class="block" for="comment">%s</label>',
			_x( 'Comment', 'wptailwind' )
		),
		'<textarea id="comment" class="wptw-input w-full" name="comment" cols="45" rows="6" maxlength="65525" required="required"></textarea>'
	);
	$args[ 'title_reply_before' ]   = '<h3 id="reply-title" class="comment-reply-title mb-4">';
	$args[ 'title_reply_after' ]    = '</h3>';
	$args[ 'class_submit' ]         = 'wptw-btn';
	
	return $args;
}

/*
 |-------------------------------------------------
 | Comments meta edit_link
 |-------------------------------------------------
 |
 | Display Comment Edit Link
 |
 */
if ( ! function_exists( 'wptw_comment_edit_link' ) ) :
	function wptw_comment_edit_link() {
		if ( ! get_edit_comment_link() ) {
			return;
		}
		
		printf(
			'<span class="comment-edit-link wptw-svg-icon ml-2">%1$s<a class="comment-edit-link font-serif ml-1" href="%2$s">%3$s</a></span>',
			wptailwind_meta_icon( 'edit' ),
			esc_url( get_edit_comment_link() ),
			__( 'Edit', 'wptailwind' )
		);
	}
endif;

/*
 |-------------------------------------------------
 | Comments meta posted_on
 |-------------------------------------------------
 |
 | Display comment meta posted on information e.g date
 |
 */
if ( ! function_exists( 'wptw_comment_posted_on' ) ) :
	function wptw_comment_posted_on( $comment, $args ) {
		
		$comment_timestamp  = sprintf(
			__( '%1$s at %2$s', 'wptailwind' ),
			get_comment_date( '', $comment ),
			get_comment_time()
		);
		
		$time_string = sprintf(
			'<time datetime="%1$s" title="%2$s">%2$s</time>',
			esc_attr( get_comment_time( 'c' ) ),
			esc_html( $comment_timestamp )
		);
		
		printf(
			'<span class="comment-posted-on wptw-svg-icon">%1$s<a class="font-serif ml-1" href="%2$s" rel="bookmark">%3$s</a></span>',
			wptailwind_meta_icon( 'clock' ),
			esc_url( get_comment_link( $comment, $args ) ),
			$time_string
		);
	}
endif;

function wptw_is_commenter_post_author( $comment = null ) {
	if ( is_object( $comment ) && $comment->user_id > 0 ) {
		$user = get_userdata( $comment->user_id );
		$post = get_post( $comment->comment_post_ID );
		if ( ! empty( $user ) && ! empty( $post ) ) {
			return $comment->user_id === $post->post_author;
		}
	}
	
	return false;
}
