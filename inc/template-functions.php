<?php
/*
|-------------------------------------------------
| get template part with cache
|-------------------------------------------------
|
| get template part for content template for loop
|
| @param string $slug template slug
| @param string $name template name
|
*/
function wptw_get_template_part( $slug, $name = '' ) {
	# serialize key to store the cache
	$cache_key = sanitize_key( implode( '-', array( 'template-part', $slug, $name ) ) );
	
	# load get template from wp_cache object
	$template = (string) wp_cache_get( $cache_key, 'wctw_cache' );
	
	# if template is not in cache
	if ( ! $template ) {
		$template_arr = array();
		/**
		 * if template name is provided to function
		 * load template if developer has set another path
		 */
		if ( $name ) {
			$template_arr[] = template_path() . "{$slug}-{$name}.php";
		}
		$template_arr[] = template_path() . "{$slug}.php";
		$template       = locate_template( $template_arr, false, false );
		
		/**
		 * if above template is not found
		 * load the default templates
		 */
		if ( ! $template ) {
			$base_template = WPTW_DIR_PATH . "/template-parts/{$slug}-{$name}.php";
			$template      = file_exists( $base_template ) ? $base_template : '';
		}
		
		# cache found template for rest of loop
		wp_cache_set( $cache_key, $template, 'wctw_cache' );
	}
	
	# if template found load the template
	if ( $template ) {
		load_template( $template, false );
	}
}

/*
|-------------------------------------------------
| single home page post title
|-------------------------------------------------
|
| display on single home page title above the loop
|
*/
function wptw_home_single_post_title() {
	if ( is_home() && ! is_front_page() ) :
		single_post_title();
	endif;
}

/**
 * dispkay sidebar template sidebar.php or sidebar-{name}.php
 *
 * @param string $sidebar sidebar name e.g for sidebar-page.php name will be 'page'
 */
function wptw_do_sidebar( $sidebar = '' ) {
	get_sidebar( $sidebar );
}