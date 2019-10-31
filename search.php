<?php
/*
 |-------------------------------------------------
 | Search Results Template
 |-------------------------------------------------
 |
 | This is the template that display search results
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

get_header(); ?>

<?php if ( have_posts() ) :
	printf(
		esc_html__( 'Results Filtered by: %s', 'wptailwind' ),
		get_search_query()
	);
	
	while ( have_posts() ) : the_post();
		get_template_part( 'template-parts/content', 'search' );
	endwhile;
	
	the_posts_navigation();
else :
	get_template_part( 'template-parts/content', 'none' );
endif;
?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>