<?php
/*
 |-------------------------------------------------
 | Custom Header Implementation
 |-------------------------------------------------
 |
 | Function definition for the custom header feature
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

/*
 |-------------------------------------------------
 | Add Theme Support for Custom Header
 |-------------------------------------------------
 |
 |
 |
 | @package wptailwind
 |
 */
function wptailwind_custom_header_setup() {
	add_theme_support( 'custom-header',
        apply_filters(
                'wptailwind_custom_header_args',
                [
	                get_parent_theme_file_uri( '/assets/images/header.min.jpg' ),
                    'width'            => 2000,
                    'height'           => 1200,
                    'flex-height'      => true,
                    'video'            => true, // TODO: fix video controlls
                    'wp-head-callback'       => 'wptailwind_header_style',
                ]
        )
    );
}
add_action( 'after_setup_theme', 'wptailwind_custom_header_setup' );

/**
 * Custom Header image styles
 */
if ( ! function_exists( 'wptailwind_header_style' ) ) :
	function wptailwind_header_style() {
		?>
		<style type="text/css">
		<?php
		// Has the text been hidden?
		if ( ! display_header_text() ) :
			?>
            .header-image-styles {}
		    <?php
		endif;
		?>
		</style>
		<?php
	}
endif;