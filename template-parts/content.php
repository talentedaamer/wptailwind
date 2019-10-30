<?php
/*
 |-------------------------------------------------
 | Template Part: Content
 |-------------------------------------------------
 |
 | Template part for displaying posts content.
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
	if ( is_singular() ) :
		the_title( '<h1>', '</h1>' );
	else :
		the_title( '<h2><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
	endif;
	
	if ( 'post' === get_post_type() ) :
		wptailwind_posted_on();
		wptailwind_posted_by();
	endif;
	
	wptailwind_post_thumbnail();
	
	the_content( sprintf(
		wp_kses(
			__( 'Read More<span class="screen-reader-text"> "%s"</span>', 'wptailwind' ),
			array( 'span' => array( 'class' => array() ) )
		),
		get_the_title()
	) );
	
	wp_link_pages();
	
	wptailwind_entry_footer();
	?>
</article>
