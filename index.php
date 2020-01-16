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

/**
 * exit if accessed directly
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header(); ?>

<div class="container px-4">
    <div class="content-sidebar-wrap flex -mx-4">
        <div class="w-full sm:w-1/3 md:w-2/3 lg:w-3/4 xl:w-3/4 px-4">
			<?php
			/**
			 * standard wordpress loop
			 */
			do_action( 'wptc_loop' );
			?>
        </div>
        
        <div class="w-full sm:w-1/3 md:w-1/3 lg:w-1/4 xl:w-1/4 px-4">
		    <?php get_sidebar(); ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>
