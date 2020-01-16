<?php
/*
|-------------------------------------------------
| standard wordpress loop function
|-------------------------------------------------
|
| standard loop placed in function for DRY
|
*/
function wptw_loop_cb() {
    if ( have_posts() ) {
        
        /**
         * hook: wptw_before_while_have_posts
         * @hooked : wptw_home_single_post_title 5
         */
        do_action( 'wptw_before_while_have_posts' );
        
        while ( have_posts() ) {
            
            the_post();
            
            /**
             * hook: wptw_before_entry
             */
            do_action( 'wptw_before_entry' );
            
            # load entry content template
            wptw_get_template_part( 'content', get_post_type() );
            
            /**
             * hook: wptw_after_entry
             */
            do_action( 'wptw_after_entry' );
            
        } # while() loop
        
        /**
         * hook: wptw_after_endwhile_have_posts
         */
        do_action( 'wptw_after_endwhile_have_posts' );
        
    } else {
        
        # load no post found template
        wptw_get_template_part( 'content', 'none' );
        
    } # end: if have_posts()
}