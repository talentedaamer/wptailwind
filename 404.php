<?php
/*
 |-------------------------------------------------
 | 404 Not Found Template
 |-------------------------------------------------
 |
 | Template for displaying 404, not found page
 |
 | @package wptailwind
 |
 */

# exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

# get header.php
get_header(); ?>

<div <?php wptw_container_class( 'container px-4' ); ?>>
    <div <?php wptw_content_sidebar_class(); ?>>
        <div <?php wptw_content_class(); ?>>
			<?php
			/**
			 * 404 page generic content
			 * @hooked: wptw_not_found_do_content
			 */
			do_action( 'wptw_not_found_content' );
			?>
        </div>
    </div>
</div>

<?php get_footer(); ?>
