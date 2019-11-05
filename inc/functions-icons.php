<?php
/*
 |-------------------------------------------------
 | Theme Icon Functions
 |-------------------------------------------------
 |
 | This theme uses a super fast svg icon loading
 | technique which does not involve loading icons
 | via http requests. these function load & display
 | svg icon in theme.
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

/**
 * Load icons svg file which contains all icons definitions
 */
function wptailwind_load_icons() {
	// Define SVG sprite file.
	$svg_icons = get_parent_theme_file_path( '/assets/images/wptw-icons.svg' );
	// If it exists, include it.
	if ( file_exists( $svg_icons ) ) {
		require_once( $svg_icons );
	}
}

add_action( 'wp_footer', 'wptailwind_load_icons', 9999 );

function wptailwind_get_svg( $args = [] ) {
	// Make sure $args are an array.
	if ( empty( $args ) ) {
		return __( 'Please define default parameters in the form of an array.', 'wptailwind' );
	}
	
	// Define an icon.
	if ( FALSE === array_key_exists( 'icon', $args ) ) {
		return __( 'Please define an SVG icon name.', 'wptailwind' );
	}
	
	// Set defaults.
	$defaults = [
		'icon'     => '',
		'size'     => '24',
		'title'    => '',
		'desc'     => '',
		'fallback' => FALSE,
	];
	
	// merge user args into defaults
	$args = wp_parse_args( $args, $defaults );
	
	// Set aria-labelledby.
	$aria_labelledby = '';
	if ( $args[ 'title' ] && $args[ 'desc' ] ) {
		$aria_labelledby = ' aria-labelledby="title desc"';
	}
	
	// Begin SVG markup.
	$svg = sprintf( '<svg class="wptw-icon-' . esc_attr( $args[ 'icon' ] ) . ' inline-block" width="%d" height="%d" aria-hidden="true" %d focusable="false" role="img">', $args['size'], $args['size'], $aria_labelledby );
	
	// If there is a title, display it.
	if ( $args[ 'title' ] ) {
		$svg .= '<title>' . esc_html( $args[ 'title' ] ) . '</title>';
	}
	
	// If there is a description, display it.
	if ( $args[ 'desc' ] ) {
		$svg .= '<desc>' . esc_html( $args[ 'desc' ] ) . '</desc>';
	}
	
	// Use absolute path in the Customizer so that icons show up in there.
	if ( is_customize_preview() ) {
		$svg .= '<use xlink:href="' . get_parent_theme_file_uri( '/assets/images/wptw-icons.svg#wptw-icon-' . esc_html( $args[ 'icon' ] ) ) . '"></use>';
	} else {
		$svg .= '<use xlink:href="#wptw-icon-' . esc_html( $args[ 'icon' ] ) . '"></use>';
	}
	
	// Add some markup to use as a fallback for browsers that do not support SVGs.
	if ( $args[ 'fallback' ] ) {
		// TODO: style svg-fallback class as box
		$svg .= '<span class="svg-fallback wptw-icon-' . esc_attr( $args[ 'icon' ] ) . '"></span>';
	}
	$svg .= '</svg>';
	
	// remove new line (\n) and tab (\t) character from svg
	$svg  = preg_replace( "/([\n\t]+)/", ' ', $svg );
	// remove white spaces between svg tags
	$svg  = preg_replace( '/>\s*</', '><', $svg );
	
	return $svg;
}

function wptailwind_meta_icon( $icon, $size = 16 ) {
	return wptailwind_get_svg( [
		'icon' => $icon,
		'size' => $size
	] );
}