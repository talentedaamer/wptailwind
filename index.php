<?php
/*
 |-------------------------------------------------
 | The main template file
 |-------------------------------------------------
 |
 | The most generic template file in WordPress theme
 |
 | @package wptailwind
 |
 */

# exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
    exit;
}

get_header(); ?>

<div class="container px-4">
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
