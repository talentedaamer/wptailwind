<?php
/*
 |-------------------------------------------------
 | Main Page template
 |-------------------------------------------------
 |
 | This is the main page template that displays
 | all pages by default. other than page templates
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
	
	get_template_part( 'template-parts/content', 'page' );
	
	// TODO: comment fields validation
	if ( comments_open() || get_comments_number() ) :
		comments_template();
	endif;

endwhile;
?>


<?php get_sidebar(); ?>
<?php get_footer(); ?>