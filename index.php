<?php
/*
 |-------------------------------------------------
 | The main template file
 |-------------------------------------------------
 |
 | The most generic template file in WordPress theme
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

<?php
if ( have_posts() ) :
	// TODO: enable disable via composer
	if ( is_home() && ! is_front_page() ) :
		single_post_title();
	endif;
	
	while ( have_posts() ) : the_post();
		get_template_part( 'template-parts/content', get_post_type() );
	endwhile;
	
	the_posts_navigation();
else :
	get_template_part( 'template-parts/content', 'none' );
endif;
?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
