<?php
/*
 |-------------------------------------------------
 | Theme Sidebar and Widget Areas
 |-------------------------------------------------
 |
 | Theme main widget areas and sidebars are
 | registered here in this file.
 |
 | @package wptailwind
 |
 */

# exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * return list of registered sidebar
 * from widget-areas.json file
 * @return array
 */
function wptw_get_sidebars() {
	$file     = get_parent_theme_file_path( 'inc/config/widget-areas.json' );
	$sidebars = (array) json_decode( file_get_contents( $file ), true );
	
	if ( ! $sidebars ) {
		$sidebars = array(
			'sidebar-1' => array(
				'name'        => 'Sidebar Primary',
				'description' => 'Main sidebar for Posts & Pages.',
			),
		);
	}
	
	$sidebars = apply_filters( 'wptw_registered_sidebars', $sidebars );
	
	return $sidebars;
}

if ( ! function_exists( 'wptw_register_sidebar' ) ) :
	/**
	 * Register sidebars based on the sidebars array
	 * sidebar array is returned from wptw_get_sidebars() function
	 */
	function wptw_register_sidebar() {
		$sidebars = wptw_get_sidebars();
		
		if ( $sidebars ) {
			/**
			 * common widget args
			 * used in all registered sidebars
			 */
			$common_args = array(
				'before_title'  => '<h4 class="widget-title text-gray-900 mb-4 uppercase">',
				'after_title'   => '</h4>',
				'before_widget' => '<section id="%1$s" class="widget mb-8 %2$s">',
				'after_widget'  => '</section>',
			);
			
			foreach ( $sidebars as $id => $sidebar ) {
				$name = ucwords($sidebar['name']);
				$sidebar_id = sanitize_title( $id );
				$description = $sidebar['description'] ? $sidebar['description'] : '';
				
				# register sidebar for each sidebar
				register_sidebar(
					array_merge(
						$common_args,
						array(
							'name' => $name,
							'id' => $sidebar_id,
							'description' => $description
						)
					)
				);
			}
		}
	}
	
	add_action( 'widgets_init', 'wptw_register_sidebar' );
endif;
