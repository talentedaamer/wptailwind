<?php

// Comments form.
// TODO: update all fields with sprintf function
add_filter( 'comment_form_default_fields', 'wptw_comment_form_fields' );
function wptw_comment_form_fields( $fields ) {
	// $current_commenter  = wp_get_current_commenter();
	// $is_email_req       = get_option( 'require_name_email' );
	// $is_html5_supported = current_theme_supports( 'html5', 'comment-form' ) ? 1 : 0;
	// $req_attribute      = ( $is_html5_supported ? " required" : " aria-required='true'" );
	// $req_label          = $is_email_req ? ' <span>*</span>' : '';
	// $req_field          = $is_email_req ? $req_attribute : '';
	// $consent            = empty( $current_commenter[ 'comment_author_email' ] ) ? '' : ' checked="checked"';
	// $fields             = array(
	// 	'author'  => '<div class="field-wrap comment-form-author mb-4"><label class="block" for="author">' . __( 'Name', 'wptailwind' ) . $req_label . '</label> ' .
	// 	             '<input class="wptw-input" id="author" name="author" type="text" value="' . esc_attr( $current_commenter[ 'comment_author' ] ) . '" size="30"' . $req_field . '></div>',
	// 	'email'   => '<div class="field-wrap comment-form-email mb-4"><label class="block" for="email">' . __( 'Email', 'wptailwind' ) . $req_label . '</label> ' .
	// 	             '<input class="wptw-input" id="email" name="email" ' . ( $is_html5_supported ? 'type="email"' : 'type="text"' ) . ' value="' . esc_attr( $current_commenter[ 'comment_author_email' ] ) . '" size="30"' . $req_field . '></div>',
	// 	'url'     => '<div class="field-wrap comment-form-url mb-4"><label class="block" for="url">' . __( 'Website', 'wptailwind' ) . '</label> ' .
	// 	             '<input class="wptw-input" id="url" name="url" ' . ( $is_html5_supported ? 'type="url"' : 'type="text"' ) . ' value="' . esc_attr( $current_commenter[ 'comment_author_url' ] ) . '" size="30"></div>',
	// 	'cookies' => '<div class="field-wrap form-check comment-form-cookies-consent mb-4"><input class="mr-2 leading-tight" id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="yes"' . $consent . ' /> ' .
	// 	             '<label class="form-check-label" for="wp-comment-cookies-consent">' . __( 'Save my name, email, and website in this browser for the next time I comment', 'wptailwind' ) . '</label></div>',
	// );
	
	$commenter = wp_get_current_commenter();
	$req = get_option( 'require_name_email' );
	$html_req = ( $req ? " required='required'" : '' );
	$is_html5 = current_theme_supports( 'html5', 'comment-form' ) ? 1 : 0;
	
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
				esc_attr( $commenter['comment_author'] ),
				$html_req
			)
		),
		'email' => sprintf(
			'<div class="field-group comment-form-email sm:w-1/3 md:w-1/3 lg:w-1/3 xl:w-1/3 px-4">%s %s</div>',
			sprintf(
				'<label for="email">%s%s</label>',
				__( 'Email' ),
				( $req ? ' <span class="required">*</span>' : '' )
			),
			sprintf(
				'<input class="wptw-input w-full" id="email" name="email" %s value="%s" size="30" maxlength="100" aria-describedby="email-notes"%s />',
				( $is_html5 ? 'type="email"' : 'type="text"' ),
				esc_attr( $commenter['comment_author_email'] ),
				$html_req
			)
		),
		'url' => sprintf(
			'<div class="field-group comment-form-url sm:w-1/3 md:w-1/3 lg:w-1/3 xl:w-1/3 px-4">%s %s</div></div>',
			sprintf(
				'<label for="url">%s</label>',
				__( 'Website' )
			),
			sprintf(
				'<input class="wptw-input w-full" id="url" name="url" %s value="%s" size="30" maxlength="200" />',
				( $is_html5 ? 'type="url"' : 'type="text"' ),
				esc_attr( $commenter['comment_author_url'] )
			)
		),
	);
	
	return $fields;
}

add_filter( 'comment_form_defaults', 'wptw_comment_form' );
function wptw_comment_form( $args ) {
	$req = get_option( 'require_name_email' );
	$required_text = sprintf(
		' ' . __( 'Required fields are marked %s' ),
		'<span class="required">*</span>'
	);
	
	$args['comment_notes_before'] = sprintf(
		'<p class="comment-notes mb-4">%s%s</p>',
		sprintf(
			'<span id="email-notes">%s</span>',
			__( 'Your email address will not be published.' )
		),
		( $req ? $required_text : '' )
	);
	$args[ 'comment_field' ] = sprintf(
		'<div class="field-wrap comment-form-comment mb-4">%s %s</div>',
		sprintf(
			'<label class="block" for="comment">%s</label>',
			_x( 'Comment', 'wptailwind' )
		),
		'<textarea id="comment" class="wptw-input w-full" name="comment" cols="45" rows="6" maxlength="65525" required="required"></textarea>'
	);
	$args['title_reply_before'] = '<h3 id="reply-title" class="comment-reply-title mb-4">';
	$args['title_reply_after'] = '</h3>';
	$args[ 'class_submit' ]  = 'wptw-btn';
	
	return $args;
}
