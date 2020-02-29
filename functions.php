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
define( 'WPTAILWIND_VERSION', '1.0.0' );
define( 'WPTW_TEMPLATE_VIEWS_PATH', trailingslashit( 'template-parts' ) );
# theme directory path
if ( ! defined( 'WPTW_DIR_PATH' ) ) {
	define( 'WPTW_DIR_PATH', trailingslashit( get_template_directory() ) );
}
# theme direcoty uri (for css, js, images etc)
if ( ! defined( 'WPTW_DIR_URI' ) ) {
	define( 'WPTW_DIR_URI', trailingslashit( get_template_directory_uri() ) );
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
 | WPTailwind Logo
 |-------------------------------------------------
 |
 | Display wptailwind logo
 |
 */
if ( ! function_exists( 'wptw_logo' ) ) :
	function wptw_logo() {
		$logo = sprintf(
			'<h1 class="font-bold text-2xl"><a href="%s">%s</a></h1>',
			esc_url( get_home_url( '/' ) ),
			wptw_get_icon( 'chevron-left', 32 ) . '<span>WpTailwind</span>' . wptw_get_icon( 'chevron-right', 32 )
		);
		
		$logo = apply_filters( 'wptw_logo_markup', $logo );
		
		echo $logo;
	}
endif;

/*
 |-------------------------------------------------
 | Post meta posted_on
 |-------------------------------------------------
 |
 | Display post meta posted on information e.g date
 | displayed only on post type 'post'.
 |
 */
if ( ! function_exists( 'wptailwind_posted_on' ) ) :
	function wptailwind_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}
		
		$time_string = sprintf(
			$time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);
		
		printf(
			'<span class="posted-on wptw-svg-icon">%1$s<a class="font-serif ml-1" href="%2$s" rel="bookmark">%3$s</a></span>',
			wptw_meta_icon( 'clock' ),
			esc_url( get_permalink() ),
			$time_string
		);
	}
endif;

/*
 |-------------------------------------------------
 | Post meta posted_by
 |-------------------------------------------------
 |
 | Display post meta posted by author information
 | displayed only on post type 'post'.
 |
 */
if ( ! function_exists( 'wptailwind_posted_by' ) ) :
	/**
	 * Prints HTML with meta information for the current author.
	 */
	function wptailwind_posted_by() {
		$byline = '<a class="font-serif ml-1" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a>';
		echo '<span class="posted-by wptw-svg-icon ml-4"> ' . wptw_meta_icon( 'user' ) . $byline . '</span>'; // WPCS: XSS OK
	}
endif;

/*
 |-------------------------------------------------
 | Post meta comments
 |-------------------------------------------------
 |
 | Display post meta comments or post comment link
 | displayed only on post type 'post'.
 |
 */
if ( ! function_exists( 'wptailwind_comment_link' ) ) :
	function wptailwind_comment_link() {
		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) : ?>
            <span class="comments-link wptw-svg-icon ml-4">
                <?php echo wptw_meta_icon( 'message-circle' ); ?>
                <?php comments_popup_link( false, false, false, 'font-serif ml-1', false ); ?>
            </span>
		<?php endif;
	}
endif;

/*
|-------------------------------------------------
| Post footer meta
|-------------------------------------------------
|
| Display post footer meta information
| e.g; post tags, post categories, edit link, comments
|
*/
if ( ! function_exists( 'wptailwind_entry_footer' ) ) :
	function wptailwind_entry_footer() {
		// display only on post type 'post'
		if ( 'post' === get_post_type() ) {
			$categories_list = get_the_category_list( esc_html__( ', ', 'wptailwind' ) );
			if ( $categories_list ) {
				printf(
					'<span class="cat-links wptw-svg-icon">%1$s<span class="font-serif ml-1">%2$s</span></span>',
					wptw_meta_icon( 'folder' ),
					$categories_list
				);
			}
			
			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'wptailwind' ) );
			if ( $tags_list ) {
				/* translators: 1: list of tags. */
				printf(
					'<span class="tags-links wptw-svg-icon ml-4">%1$s<span class="font-serif ml-1">%2$s</span></span>',
					wptw_meta_icon( 'hash' ),
					$tags_list
				);
			}
		}
		
		edit_post_link(
			sprintf(
				wp_kses(
					__( 'Edit <span class="screen-reader-text">%s</span>', 'wptailwind' ),
					[ 'span' => [ 'class' => [] ] ]
				),
				get_the_title()
			),
			'<span class="edit-link wptw-svg-icon ml-4">' . wptw_meta_icon( 'edit' ),
			'</span>',
			null,
			'ml-1'
		);
	}
endif;

/*
|-------------------------------------------------
| Page footer meta
|-------------------------------------------------
|
| Display page footer edit page link
|
*/
if ( ! function_exists( 'wptailwind_page_footer' ) ) :
	function wptailwind_page_footer() {
		if ( get_edit_post_link() ) :
			edit_post_link(
				sprintf(
					wp_kses(
						__( 'Edit <span class="screen-reader-text">%s</span>', 'wptailwind' ),
						[ 'span' => [ 'class' => [] ] ]
					),
					get_the_title()
				),
				'<span class="edit-link">',
				'</span>'
			);
		endif;
	}
endif;

/*
|-------------------------------------------------
| Post thumbnail image
|-------------------------------------------------
|
| Display post thumbnail image on post
|
*/
if ( ! function_exists( 'wptailwind_post_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function wptailwind_post_thumbnail() {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		} ?>
		
		<?php if ( is_singular() ) : ?>
            <div class="post-thumbnail-classes">
				<?php the_post_thumbnail(); ?>
            </div>
		<?php else : ?>
            <a class="post-thumbnail-classes" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
				<?php
				the_post_thumbnail( 'post-thumbnail', [
					'alt' => the_title_attribute( [ 'echo' => false ] ),
				] );
				?>
            </a>
		<?php endif;
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
function wptailwind_scripts() {
	// wp_enqueue_style( 'google-fonts', 'https://fonts.googleapis.com/css?family=PT+Sans:400,700|Playfair+Display:400,700&display=swap', '', WPTAILWIND_VERSION );
	wp_enqueue_style( 'google-fonts', 'https://fonts.googleapis.com/css?family=Lato:300,400,700|Raleway:400,700&display=swap', '', WPTAILWIND_VERSION );
	wp_enqueue_style( 'wptailwind-style', get_stylesheet_uri() );
	wp_enqueue_style( 'wptailwind-main-css', WPTW_DIR_URI . 'assets/css/app.css', '', WPTAILWIND_VERSION );
	
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

add_action( 'wp_enqueue_scripts', 'wptailwind_scripts' );

/*
|-------------------------------------------------
| Search Form Formation
|-------------------------------------------------
|
| custom formation for search form
|
| @return string
|
*/
if ( ! function_exists( 'wptailwind_get_search_form' ) ) :
	function wptailwind_get_search_form() {
		return '<form role="search" method="get" class="flex search-form" action="' . esc_url( home_url( '/' ) ) . '" xmlns="http://www.w3.org/1999/html">
            <input type="search" class="wptw-input w-full" placeholder="' . esc_attr_x( 'Search &hellip;', 'placeholder' ) . '" value="' . get_search_query() . '" name="s" />
            <button type="submit" class="w-auto flex justify-end items-center wptw-btn">' . wptw_meta_icon( 'search', 18 ) . '</button>
        </form>';
	}
endif;
add_filter( 'get_search_form', 'wptailwind_get_search_form' );

/*
|-------------------------------------------------
| Posts Pagination
|-------------------------------------------------
|
| posts pagination
|
*/
if ( ! function_exists( 'wptailwind_posts_pagination' ) ) :
	function wptailwind_posts_pagination() {
		the_posts_pagination(
			array(
				'mid_size'           => 2,
				// 'prev_next' => false,
				'before_page_number' => '<span class="bg-indigo-700 px-2 py-2 text-white">',
				'after_page_number'  => '</span>',
				'prev_text'          => sprintf(
					'%s <span class="nav-prev-text">%s</span>',
					wptw_get_icon( 'chevron-left' ),
					__( 'Newer posts', 'wptailwind' )
				),
				'next_text'          => sprintf(
					'<span class="nav-next-text">%s</span> %s',
					__( 'Older posts', 'wptailwind' ),
					wptw_get_icon( 'chevron-right' )
				),
			)
		);
	}
endif;

/*
|-------------------------------------------------
| Body Classes
|-------------------------------------------------
|
| conditional body classes
|
*/
if ( ! function_exists( 'wptailwind_body_classes' ) ) {
	function wptailwind_body_classes( $classes ) {
		
		if ( is_multi_author() ) {
			$classes[] = 'group-blog';
		}
		
		if ( ! is_singular() ) {
			$classes[] = 'hfeed';
		}
		
		# TODO: get layout width from customizer and add body class
		
		return $classes;
	}
}
add_filter( 'body_class', 'wptailwind_body_classes' );

/*
|-------------------------------------------------
| Post Classes
|-------------------------------------------------
|
| conditional post classes
|
*/
if ( ! function_exists( 'wptailwind_post_classes' ) ) {
	function wptailwind_post_classes( $classes, $class, $post_id ) {
		if ( ! is_singular() && is_sticky() ) {
			$classes[] = 'p-10 bg-gray-100 border-2 border-gray-300';
		}
		
		return $classes;
	}
}
add_filter( 'post_class', 'wptailwind_post_classes', 10, 3 );

/*
|-------------------------------------------------
| Comments Classes
|-------------------------------------------------
|
| classes for post item.
|
*/
add_filter( 'comment_class', function ( $classes ) {
	
	// $classes[] = '';
	
	/**
	 * filters the list of CSS class names for comments
	 *
	 * @since 1.0.1
	 *
	 * @param string[] $classes An array of comment class names.
	 */
	$classes = apply_filters( 'wptw_comment_class', $classes );
	
	return array_unique( $classes );
} );

/*
|-------------------------------------------------
| Include Functions, Filters, Classes
|-------------------------------------------------
|
| Include theme core functionality
|
*/
if ( defined( 'WPTW_DIR_PATH' ) ) {
	define( 'WPTW_INC_DIR_PATH', trailingslashit( WPTW_DIR_PATH . 'inc' ) );
} else {
	define( 'WPTW_INC_DIR_PATH', trailingslashit( trailingslashit( get_template_directory() ) . 'inc' ) );
}
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
require WPTW_INC_DIR_PATH . 'class-comments-walker.php';