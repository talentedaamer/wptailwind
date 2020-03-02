<?php
/*
 |-------------------------------------------------
 | The main functions and definitions file
 |-------------------------------------------------
 |
 | The main file for function definitions and
 | other file loading.
 |
 | @package wptailwind
 |
 */

# exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
 |-------------------------------------------------
 | Theme Constants
 |-------------------------------------------------
 |
 | Theme constant variables like version, theme dir,
 | theme dir uri, template-parts directory path.
 |
 | WPTW_TEMPLATE_VIEWS_PATH
 | usage: if child theme or customize this theme
 | user can give own template directory path
 | without overwriting the main template files
 |
 */
# theme version
define( 'WPTW_VERSION', '1.0.0' );

# theme template-parts directory path
define( 'WPTW_TEMPLATE_VIEWS_PATH', trailingslashit( 'template-parts' ) );

# theme directory path
if ( ! defined( 'WPTW_DIR_PATH' ) ) {
	define( 'WPTW_DIR_PATH', trailingslashit( get_template_directory() ) );
}

# theme direcoty uri (for css, js, images etc)
if ( ! defined( 'WPTW_DIR_URI' ) ) {
	define( 'WPTW_DIR_URI', trailingslashit( get_template_directory_uri() ) );
}

# includes directory path
if ( defined( 'WPTW_DIR_PATH' ) ) {
	define( 'WPTW_INC_DIR_PATH', trailingslashit( WPTW_DIR_PATH . 'inc' ) );
} else {
	define( 'WPTW_INC_DIR_PATH', trailingslashit( trailingslashit( get_template_directory() ) . 'inc' ) );
}


/*
 |-------------------------------------------------
 | Theme Setup
 |-------------------------------------------------
 |
 | Setup theme, register and add support for
 | various WordPress features.
 |
 */
if ( ! function_exists( 'wptw_setup' ) ) :
	function wptw_setup() {
		# Make the theme translation ready.
		load_theme_textdomain( 'wptailwind', get_template_directory() . '/langs' );
		
		# add theme support for posts and comments RSS feed links.
		add_theme_support( 'automatic-feed-links' );
		
		# Add theme support for document title.
		add_theme_support( 'title-tag' );
		
		# Add theme support for post thumbnails
		add_theme_support( 'post-thumbnails' );
		
		# add theme support for custom headers
		add_theme_support( 'custom-header', array( 'uploads' => true ) );
		
		# Add theme support for navigation menus
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary Menu', 'wptailwind' ),
			'menu-2' => esc_html__( 'Secondary Menu', 'wptailwind' ),
		) );
		
		# Add html5 tag support for comments, search, gallery, captions etc
		add_theme_support( 'html5', [
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		] );
		
		# Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );
	}
endif;
add_action( 'after_setup_theme', 'wptw_setup' );

/*
 |-------------------------------------------------
 | Content area width
 |-------------------------------------------------
 |
 | Sets a global width to the content area
 |
 */
if ( ! function_exists( 'wptailwind_content_width' ) ) :
	function wptailwind_content_width() {
		$GLOBALS[ 'content_width' ] = apply_filters( 'wptailwind_content_width', 845 );
	}
endif;
add_action( 'after_setup_theme', 'wptailwind_content_width', 0 );

/*
 |-------------------------------------------------
 | Site Title
 |-------------------------------------------------
 |
 | Function to display site title or logo default
 | is site title
 |
 */
if ( ! function_exists( 'wptw_site_logo' ) ) :
	function wptw_site_logo() {
		$logo = sprintf(
			'<h1 class="font-bold text-2xl"><a href="%s">%s</a></h1>',
			esc_url( get_home_url( '/' ) ),
			esc_attr( get_bloginfo( 'name' ) )
		);
		
		$logo = apply_filters( 'wptw_logo_markup', $logo );
		
		echo $logo;
	}
endif;

/*
 |-------------------------------------------------
 | Site Description
 |-------------------------------------------------
 |
 | Function to display description or tagline
 | default is site description.
 |
 */
if ( ! function_exists( 'wptw_site_description' ) ) :
	function wptw_site_description() {
		$description = '';
		$site_desc = get_bloginfo( 'description' );
		if ( $site_desc || is_customize_preview() ) :
            $description = sprintf(
            	'<p class="site-desc text-gray-700">%s</p>',
	            $site_desc
            );
		endif;
		
		echo apply_filters( 'wptw_site_description', $description, $site_desc );
	}
endif;

/*
|-------------------------------------------------
| Scripts & Styles
|-------------------------------------------------
|
| Register and enqueue theme scripts and styles
|
*/
if ( ! function_exists( 'wptw_scripts' ) ) :
	function wptw_scripts() {
		wp_enqueue_style(
			'wptw-google-fonts',
			'https://fonts.googleapis.com/css?family=Lato:300,400,700|Raleway:400,700&display=swap',
			array(),
			WPTW_VERSION
		);
		wp_enqueue_style(
			'wptw-main-css',
			WPTW_DIR_URI . 'assets/css/app.css',
			array(),
			WPTW_VERSION
		);
		wp_enqueue_style(
			'wptw-style',
			get_stylesheet_uri()
		);
		
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}
endif;
add_action( 'wp_enqueue_scripts', 'wptw_scripts' );

/*
|-------------------------------------------------
| Include Functions & Classes
|-------------------------------------------------
|
| Include theme functions and classes for different
| features, actions, filters etc.
|
*/
require WPTW_INC_DIR_PATH . 'config/config.php';
require WPTW_INC_DIR_PATH . 'functions-loop.php';
require WPTW_INC_DIR_PATH . 'functions-icons.php';
require WPTW_INC_DIR_PATH . 'functions-sidebar.php';
require WPTW_INC_DIR_PATH . 'functions-header-image.php';
require WPTW_INC_DIR_PATH . 'functions-action-hooks.php';
require WPTW_INC_DIR_PATH . 'functions-filter-hooks.php';
require WPTW_INC_DIR_PATH . 'functions-templates.php';
require WPTW_INC_DIR_PATH . 'functions-comments.php';
require WPTW_INC_DIR_PATH . 'functions-layout-classes.php';
# classes
require WPTW_INC_DIR_PATH . 'class-nav-walker.php';
require WPTW_INC_DIR_PATH . 'class-comments-walker.php';
