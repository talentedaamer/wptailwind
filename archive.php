<?php
/*
 |-------------------------------------------------
 | Archive template
 |-------------------------------------------------
 |
 | Template for displaying archive pages, category
 | tags, author, archive by date etc
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
	the_archive_title( '<h1 class="page-title">', '</h1>' );
	the_archive_description( '<div class="archive-description">', '</div>' );
	
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
