<?php

add_action( 'wptw_loop', 'wptw_do_loop', 10 );

add_action( 'wptw_sidebar', 'wptw_do_sidebar', 10 );

add_action( 'wptw_before_while_have_posts', 'wptw_do_archive_page_title', 20 );
add_action( 'wptw_before_while_have_posts', 'wptw_do_search_page_title', 20 );

/*
|-------------------------------------------------
| Custom Header Image
|-------------------------------------------------
|
| custom header image section below header
| conditional header classes added if header image
| in function-filter-hooks.php on 'wptw_header_class'
*/
if ( ! function_exists( 'wptw_custom_header_image' ) ) :
	function wptw_custom_header_image() {
		if ( ! has_header_image() ) {
			return;
		}
		
		$header_image_url = get_header_image();
		
		$header_image = sprintf(
			'<div class="wptw-header-image bg-fixed bg-no-repeat bg-cover bg-center mb-16" style="background-image: url(%1$s); height: 380px;"></div>',
			$header_image_url
		);
		
		echo apply_filters( 'wptw_custom_header_image', $header_image, $header_image_url );
	}
endif;
add_action( 'wptw_after_header', 'wptw_custom_header_image' );

/*
|-------------------------------------------------
| single home page post title
|-------------------------------------------------
|
| display on single home page title above the loop
|
*/
// TODO : test this
if ( ! function_exists( 'wptw_home_page_title' ) ) :
	function wptw_home_page_title() {
		if ( is_home() && ! is_front_page() ) :
			single_post_title();
		endif;
	}
endif;
add_action( 'wptw_before_while_have_posts', 'wptw_home_page_title' );

/*
|-------------------------------------------------
| Footer Credits
|-------------------------------------------------
|
| Include theme core functionality
|
*/
if ( ! function_exists( 'wptw_do_footer_credits' ) ) :
	function wptw_do_footer_credits() {
		$credits = sprintf(
			'<p class="wptw-footer-credits text-gray-700 text-center text-sm py-4">%s</p>',
			sprintf(
				esc_html__( 'Proudly Powered by %s', 'wptailwind' ),
				'WpTailwind'
			)
		);
		
		echo apply_filters( 'wptw_footer_credits_text', $credits );
	}
endif;
add_action( 'wptw_footer_credits', 'wptw_do_footer_credits' );

/*
|-------------------------------------------------
| Not Found Page Content
|-------------------------------------------------
|
| Inner content of 404 page. filterable via filters
|
*/
if ( ! function_exists( 'wptw_not_found_do_content' ) ) :
	function wptw_not_found_do_content() {
		$page_title = __( '404 Not Found', 'wptailwind' );
		$page_subtitle = __( 'Sorry Page could not be found.', 'wptailwind' );
		$content = sprintf(
			'<h1 class="entry-title">%s</h1><p>%s</p>',
	        $page_title,
			$page_subtitle
		);
		echo apply_filters( 'wptw_not_found_do_content', $content, $page_title, $page_subtitle );
	}
endif;
add_action( 'wptw_not_found_content', 'wptw_not_found_do_content' );
