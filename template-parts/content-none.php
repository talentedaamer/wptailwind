<?php
/*
 |-------------------------------------------------
 | Template Part: Content None
 |-------------------------------------------------
 |
 | Template part for not found posts pages
 |
 | @package wptailwind
 |
 */

# exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<?php esc_html_e( 'Nothing Found', 'wptailwind' ); ?>

<?php
if ( is_home() && current_user_can( 'publish_posts' ) ) :
	printf(
		'<p>' . wp_kses(
			__( 'Are you ready to publish your first post? <a href="%1$s">Get started here</a>.', 'wptailwind' ),
			array( 'a' => array( 'href' => array() ) )
		) . '</p>',
		esc_url( admin_url( 'post-new.php' ) )
	);
elseif ( is_search() ) :
	esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'wptailwind' );
	get_search_form();
else :
	esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'wptailwind' );
	get_search_form();
endif;
?>