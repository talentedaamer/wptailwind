<?php
/*
 |-------------------------------------------------
 | Search Results Template
 |-------------------------------------------------
 |
 | This is the template that display search results
 |
 | @package wptailwind
 |
 */

# exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

# get header.php
get_header(); ?>

<div <?php wptw_container_class( 'container px-4' ); ?>>
    <div <?php wptw_content_sidebar_class(); ?>>
        <div <?php wptw_content_class(); ?>>
            <?php
            /**
             * standard wordpress loop
             * @hooked: wptw_do_loop
             */
            do_action( 'wptw_loop' );
            ?>
        </div>

        <div <?php wptw_sidebar_class(); ?>>
            <?php
            /**
             * standard wordpress sidebar
             * @hooked: wptw_do_sidebar
             */
            do_action( 'wptw_sidebar' );
            ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>