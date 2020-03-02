<?php
/*
 |-------------------------------------------------
 | Theme Action Hooks
 |-------------------------------------------------
 |
 | All action hooks are placed in this file
 |
 | @package wptailwind
 |
 */

# exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

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
| Blog Page Title
|-------------------------------------------------
|
| display on blog page above the loop set in
| settings under following.
| settings -> reading -> a static page -> posts page
|
*/
if ( ! function_exists( 'wptw_posts_page_title' ) ) :
	function wptw_posts_page_title() {
		if ( is_home() && ! is_front_page() ) :
			$title = sprintf(
				'<h1 class="entry-title">%1$s</h1>',
				single_post_title( '', false )
			);
		
			echo apply_filters( 'wptw_posts_page_title', $title );
		endif;
	}
endif;
add_action( 'wptw_before_while_have_posts', 'wptw_posts_page_title', 10 );

/*
|-------------------------------------------------
| Archive Page Title
|-------------------------------------------------
|
| display archive page title above the loop
|
*/
if ( ! function_exists( 'wptw_archive_page_title' ) ) :
	function wptw_archive_page_title() {
		if ( is_archive() ) {
			$title = sprintf(
				'<h1 class="archive-title">%1$s</h1>',
				get_the_archive_title()
			);
			
			if ( get_the_archive_description() ) {
				$description = sprintf(
					'<div class="archive-description mt-2">%1$s</div>',
					get_the_archive_description()
				);
				
				$archive_title = sprintf(
					'<div class="archive-page-header mb-8">%1$s %2$s</div>',
					$title,
					$description
				);
			} else {
				$archive_title = sprintf(
					'<div class="archive-page-header mb-8">%1$s</div>',
					$title
				);
			}
			
			echo apply_filters( 'wptw_archive_page_title', $archive_title );
		}
	}
endif;
add_action( 'wptw_before_while_have_posts', 'wptw_archive_page_title', 20 );

/*
|-------------------------------------------------
| Search Page Title
|-------------------------------------------------
|
| display search page title above the loop
|
*/
if ( ! function_exists( 'wptw_search_page_title' ) ) :
	function wptw_search_page_title() {
		if ( is_search() ) {
			$title = sprintf(
				__( 'Results Filtered by: %s', 'wptailwind' ),
				get_search_query()
			);
			
			$search_title = sprintf(
				'<div class="archive-page-header mb-8"><h1 class="archive-title">%s</h1></div>',
				$title
			);
			
			echo apply_filters( 'wptw_search_page_title', $search_title );
		}
	}
endif;
add_action( 'wptw_before_while_have_posts', 'wptw_search_page_title', 20 );

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
