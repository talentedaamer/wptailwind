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

<article id="post-<?php the_ID(); ?>" <?php post_class('mb-16'); ?>>
	<?php
	the_title( '<h1 class="entry-title">', '</h1>' );
	
	?>
    <div class="post-meta-header mb-4">
        <?php
        wptailwind_posted_on();
        wptailwind_posted_by();
        wptailwind_comment_link();
        ?>
    </div>
    <?php
    
	wptailwind_post_thumbnail();
	
	the_content();
	
	wp_link_pages();
	
	?>
    <div class="post-meta-footer mt-4">
	    <?php wptailwind_page_footer(); ?>
    </div>
</article>
