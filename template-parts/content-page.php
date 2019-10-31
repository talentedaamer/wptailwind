<?php
/*
 |-------------------------------------------------
 | Template Part: Content-Page
 |-------------------------------------------------
 |
 | Template part for displaying page content.
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
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php
	the_title( '<h1 class="entry-title">', '</h1>' );
	
	wptailwind_post_thumbnail();
	
	the_content();
	
	wp_link_pages();
	
	wptailwind_page_footer();
	?>
</article>
