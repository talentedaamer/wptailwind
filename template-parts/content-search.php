<?php
/*
 |-------------------------------------------------
 | Template Part: Content-Search
 |-------------------------------------------------
 |
 | Template part for displaying results page content.
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
	the_title(
		sprintf( '<a href="%s" rel="bookmark">', esc_url( get_permalink() ) ),
		'</a>'
	);
	
	if ( 'post' === get_post_type() ) :
		wptailwind_posted_on();
		wptailwind_posted_by();
	endif;
	
	the_excerpt();
	
	wptailwind_entry_footer();
	?>
</article>
