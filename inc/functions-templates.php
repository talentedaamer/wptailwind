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
		
		$template = apply_filters( 'wptw_get_template_part', $template );
		
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

function wptw_do_archive_page_title() {
	if ( is_archive() ) {
		printf(
			'<div class="archive-page-header mb-8"><h1 class="archive-title">%1$s</h1><div class="archive-description mt-2">%2$s</div></div>',
			get_the_archive_title(),
			get_the_archive_description()
		);
	}
}

function wptw_do_search_page_title() {
	if ( is_search() ) {
		printf(
			'<div class="archive-page-header mb-8"><h1 class="archive-title">%s</h1></div>',
			sprintf(
				__( 'Results Filtered by: %s', 'wptailwind' ),
				get_search_query()
			)
		);
	}
}

function wptw_get_search_template_part( $template ) {
	if ( is_search() ) {
		$template = locate_template(
			template_path() . "content-search.php",
			false,
			false
		);
		
		return $template;
	}
	
	return $template;
}

function wptw_comments_nav() {
	if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
        <ul id="comments-nav" class="comments-nav flex justify-between mb-4">
			<?php
			if ( get_previous_comments_link() ) {
				printf(
					'<li>%s</li>',
					sprintf(
						get_previous_comments_link( __( '%s Older Comments', 'wptailwind' ) ),
						wptw_get_icon( 'arrow-left', 16 )
					)
				);
			}
			if ( get_next_comments_link() ) {
				printf(
					'<li>%s</li>',
					sprintf(
						get_next_comments_link( __( 'Newer Comments %s', 'wptailwind' ) ),
						wptw_get_icon( 'arrow-right', 16 )
					)
				);
			}
			?>
        </ul>
	<?php
	endif;
}

function wptw_posts_nav( $args) {
	$previous_link = get_previous_post_link( '<div class="nav-previous">%link</div>' );
	$next_link = get_next_post_link( '<div class="nav-next">%link</div>' );
	
	echo $previous_link . ' ' . $next_link;
}

add_filter( 'navigation_markup_template', function ( $template ) {
	$template = '
	<nav class="navigation" role="navigation" aria-label="%4$s">
		<div class="nav-links flex justify-between mb-4">%3$s</div>
	</nav>';
	
	$template = apply_filters( 'wptw_posts_nav_markup_template', $template );
	
	return $template;
} );

// add_filter( 'previous_comments_link_attributes', function () {
// 	return 'class="wptw-btn wptw-btn-sm"';
// } );
//
// add_filter( 'next_comments_link_attributes', function () {
// 	return 'class="wptw-btn wptw-btn-sm"';
// } );