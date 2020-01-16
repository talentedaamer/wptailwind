<?php
/**
 * layout configurations
 */

function wptw_layouts() {
	return [
		'left_sidebar' => [
			'label' => __( 'Left Sidebar', 'wptailwind' )
		],
		'right_sidebar' => [
			'label' => __( 'Right Sidebar', 'wptailwind' )
		],
		'no_sidebar' => [
			'label' => __( 'No Sidebar', 'wptailwind' )
		]
	];
}

function wptw_layout_type() {
	return [
		'boxed' => [
			'label' => __( 'Boxed Layout', 'wptailwind' )
		],
		'wide' => [
			'label' => __( 'Wide Layout', 'wptailwind' )
		]
	];
}

/**
 * color configurations
 */
function wptw_colors() {
	return [
		'light' => [
			'label' => __( 'Light', 'wptailwind' ),
			'colors' => [
				'primary' => '#f0f0f0',
				'secondary' => '#dddddd',
				'ascent' => '#cccccc'
			]
		],
		'dark' => [
			'label' => __( 'Dark', 'wptailwind' ),
			'colors' => [
				'primary' => '#333333',
				'secondary' => '#ffffff',
				'ascent' => '#dddddd'
			]
		]
	];
}

/**
 * get content template path
 *
 * @return string
 */
function template_path() {
    return apply_filters( 'wptw_template_views_path', trailingslashit('template-parts') );
}
