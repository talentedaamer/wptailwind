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

<article id="post-<?php the_ID(); ?>" <?php post_class( 'mb-16' ); ?>>
	<?php
	the_title( '<h2 class="mb-4"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
	
	if ( 'post' === get_post_type() ) :
		?>
        <div class="post-meta-header mb-4">
			<?php
			wptailwind_posted_on();
			wptailwind_posted_by();
			wptailwind_comment_link();
			?>
        </div>
	<?php
	endif;
	
	the_excerpt();
	
	?>
    <div class="post-meta-footer mt-4">
		<?php wptailwind_entry_footer(); ?>
    </div>
</article>
