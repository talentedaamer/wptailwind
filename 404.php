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

/**
 * exit if accessed directly
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header(); ?>

<div <?php wptw_container_class(); ?>>
	<?php
	esc_html_e( 'Sorry Page could not be found.', 'wptailwind' );
	
	esc_html_e( 'The page is removed or URL changes. Please search by keyword.', 'wptailwind' );
	
	get_search_form();
	?>
</div>

<?php get_footer(); ?>
