<?php
/*
 |-------------------------------------------------
 | Single Post File
 |-------------------------------------------------
 |
 | Template for displaying single posts.
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
while ( have_posts() ) : the_post();
	
	get_template_part( 'template-parts/content', get_post_type() );
	
	the_post_navigation();
	
	// TODO: comment form validation
	if ( comments_open() || get_comments_number() ) :
		comments_template();
	endif;

endwhile;
?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
