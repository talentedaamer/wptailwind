<?php
/*
|-------------------------------------------------
| standard wordpress loop function
|-------------------------------------------------
|
| standard loop placed in function for DRY
|
*/
function wptw_do_loop() {
	if ( is_singular()) {
		wptw_single_loop();
	} else {
		wptw_standard_loop();
	}
}


function wptw_standard_loop() {
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
		}
		
		/**
		 * hook: wptw_after_endwhile_have_posts
		 */
		do_action( 'wptw_after_endwhile_have_posts' );
	} else {
		# load no post found template
		wptw_get_template_part( 'content', 'none' );
	}
}

function wptw_single_loop() {
	
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
		
		if ( is_singular( 'post' ) ) {
			the_post_navigation();
		}
		
		/**
		 * hook: wptw_before_comments
		 */
		do_action( 'wptw_before_comments' );
		
		// TODO: comment form validation
		// TODO: comments template
		if ( comments_open() || get_comments_number() ) :
			comments_template();
		endif;
		
		/**
		 * hook: wptw_after_entry
		 */
		do_action( 'wptw_after_comments' );
	}
	
	/**
	 * hook: wptw_after_endwhile_have_posts
	 */
	do_action( 'wptw_after_endwhile_have_posts' );
}