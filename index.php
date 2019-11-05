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
			if ( have_posts() ) :
				// TODO: enable disable via composer
				if ( is_home() && ! is_front_page() ) :
					single_post_title();
				endif;
				
				while ( have_posts() ) : the_post();
					get_template_part( 'template-parts/content', get_post_type() );
				endwhile;
				
				the_posts_navigation();
			else :
				get_template_part( 'template-parts/content', 'none' );
			endif;
			?>
        </div>
        
        <div class="w-full sm:w-1/3 md:w-1/3 lg:w-1/4 xl:w-1/4 px-4">
		    <?php get_sidebar(); ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>
