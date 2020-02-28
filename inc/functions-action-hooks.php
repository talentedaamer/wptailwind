<?php

add_action( 'wptw_loop', 'wptw_do_loop', 10 );

add_action( 'wptw_sidebar', 'wptw_do_sidebar', 10 );

// TODO : test this
add_action( 'wptw_before_while_have_posts', 'wptw_home_single_post_title', 10 );

add_action( 'wptw_before_while_have_posts', 'wptw_do_archive_page_title', 20 );
add_action( 'wptw_before_while_have_posts', 'wptw_do_search_page_title', 20 );

/*
|-------------------------------------------------
| Footer Credits
|-------------------------------------------------
|
| Include theme core functionality
|
*/
add_action( 'wptw_footer_credits', 'wptw_do_footer_credits' );
function wptw_do_footer_credits() {
	$credits = sprintf(
		'<p class="wptw-footer-credits text-gray-700 text-center text-sm py-4">%s</p>',
		sprintf(
			esc_html__( 'Proudly Powered by %s', 'wptailwind' ),
			'WpTailwind'
		)
	);
	
	$credits = apply_filters( 'wptw_footer_credits_text', $credits );
	
	echo $credits;
}


/*
|-------------------------------------------------
| Not Found Page Content
|-------------------------------------------------
|
| Inner content of 404 page. filterable via filters
|
*/
add_action( 'wptw_not_found_content', 'wptw_not_found_do_content' );
function wptw_not_found_do_content() {
	$page_title = apply_filters( 'wptw_not_found_do_content_title', __( '404 Not Found', 'wptailwind' ) );
	$page_subtitle = apply_filters( 'wptw_not_found_do_content_subtitle', __( 'Sorry Page could not be found.', 'wptailwind' ) );
	$content = sprintf(
		'<h1 class="entry-title">%s</h1><p>%s</p>',
 		$page_title,
		$page_subtitle
	);
	
	$content = apply_filters( 'wptw_not_found_do_content', $content );
	
	echo $content;
}

// get_search_form();
