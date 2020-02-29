<?php
/*
 |-------------------------------------------------
 | Functions definitions for filter hooks
 |-------------------------------------------------
 |
 | The main functions file for all filters hoos in
 | wordpress and this theme.
 |
 | @package wptailwind
 |
 */

# exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function wptw_filter_header_class( $class ) {
	if ( ! has_header_image() ) {
		$class[] = 'mb-16';
	}
	
	return $class;
}
add_filter( 'wptw_header_class', 'wptw_filter_header_class' );
/*
|-------------------------------------------------
| Body Classes
|-------------------------------------------------
|
| conditionally filtered body classes
|
*/
if ( ! function_exists( 'wptw_body_classes' ) ) {
	function wptw_body_classes( $classes ) {
		
		if ( is_multi_author() ) {
			$classes[] = 'group-blog';
		}
		
		if ( ! is_singular() ) {
			$classes[] = 'hfeed';
		}
		
		if ( has_header_image() ) {
			$classes[] = 'wptw-has-header-image';
		}
		
		return apply_filters( 'wptw_body_classes', $classes );
	}
}
add_filter( 'body_class', 'wptw_body_classes' );

/*
|-------------------------------------------------
| Post Classes
|-------------------------------------------------
|
| conditionally filtered post classes
|
*/
if ( ! function_exists( 'wptw_post_classes' ) ) {
	function wptw_post_classes( $classes, $class, $post_id ) {
		if ( ! is_singular() && is_sticky() ) {
			$classes[] = 'p-10 bg-gray-100 border-2 border-gray-300';
		}
		
		return apply_filters( 'wptw_post_classes', $classes );
	}
}
add_filter( 'post_class', 'wptw_post_classes', 10, 3 );

/*
|-------------------------------------------------
| Comments Classes
|-------------------------------------------------
|
| classes for post item.
|
*/
if ( ! function_exists( 'wptw_comment_classes' ) ) :
	function wptw_comment_classes( $classes ) {
		// $classes[] = '';
		
		$classes = apply_filters( 'wptw_comment_class', $classes );
		
		return array_unique( $classes );
	}
endif;
add_filter( 'comment_class', 'wptw_comment_classes' );

/*
|-------------------------------------------------
| Filter Search Page template part
|-------------------------------------------------
|
| custom templat part for the search page.
| load content-search.php template part if page is
| search results
|
*/
if ( ! function_exists( 'wptw_search_page_template_part' ) ) :
	function wptw_search_page_template_part( $template ) {
		if ( is_search() ) {
			$template = locate_template(
				template_path() . "content-search.php",
				false,
				false
			);
			
			return $template;
		}
		
		return apply_filters( 'wptw_search_page_template_part', $template );
	}
endif;
add_filter( 'wptw_get_template_part', 'wptw_search_page_template_part' );

/*
|-------------------------------------------------
| Search Form Formation
|-------------------------------------------------
|
| custom formation for search form
|
*/
if ( ! function_exists( 'wptw_get_search_form' ) ) :
	function wptw_get_search_form() {
		$search_form = sprintf(
			'<form role="search" method="get" class="flex search-form" action="%1$s" xmlns="http://www.w3.org/1999/html">
                <input type="search" class="wptw-input w-full" placeholder="%2$s" value="%3$s" name="s" />
                <button type="submit" class="w-auto flex justify-end items-center wptw-btn">%4$s</button>
            </form>',
			esc_url( get_home_url( '/' ) ),
			esc_attr_x( 'Search &hellip;', 'placeholder' ),
			get_search_query(),
			wptw_get_icon( 'search', 18 )
		);
		
		return apply_filters( 'wptw_search_form', $search_form );
	}
endif;
add_filter( 'get_search_form', 'wptw_get_search_form' );