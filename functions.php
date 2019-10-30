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

/**
 * exit if accessed directly
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Theme constants
 */
define( 'WPTAILWIND_VERSION', '1.0.0' );
if ( ! defined( 'WPTAILWIND_DIR' ) )
	define( 'WPTAILWIND_DIR', trailingslashit( get_template_directory() ) );
if ( ! defined( 'WPTAILWIND_URI' ) )
	define( 'WPTAILWIND_URI', trailingslashit( get_template_directory_uri() ) );

/*
 |-------------------------------------------------
 | Theme Setup
 |-------------------------------------------------
 |
 | Setup theme, register and add support for
 | various WordPress features.
 |
 */
if ( ! function_exists( 'wptailwind_setup' ) ) :
	function wptailwind_setup() {
		/*
		 * Make theme translation ready.
		 */
		load_theme_textdomain( 'wptailwind', get_template_directory() . '/langs' );
		
		/**
		 * add theme support for posts and comments RSS feed links.
		 */
		add_theme_support( 'automatic-feed-links' );
		
		/*
		 * Add theme support for document title.
		 */
		add_theme_support( 'title-tag' );
		
		/*
		 * Add theme support for post thumbnails
		 */
		add_theme_support( 'post-thumbnails' );
		
		/**
		 * Add theme support for navigation menus
		 */
		register_nav_menus( [
			'menu-1' => esc_html__( 'Primary Menu', 'wptailwind' ),
			'menu-2' => esc_html__( 'Secondary Menu', 'wptailwind' ),
		] );
		
		/**
		 * Add html5 tag support for comments, search, gallery, captions etc
		 */
		add_theme_support( 'html5', [
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		] );
		
		/**
		 * Add theme support for selective refresh for widgets.
		 */
		add_theme_support( 'customize-selective-refresh-widgets' );
	}
endif;
add_action( 'after_setup_theme', 'wptailwind_setup' );

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
		$GLOBALS[ 'content_width' ] = apply_filters( 'wptailwind_content_width', 640 );
	}
endif;
add_action( 'after_setup_theme', 'wptailwind_content_width', 0 );

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
		
		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);
		
		$posted_on = sprintf(
			esc_html_x( 'Posted on %s', 'post date', 'wptailwind' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);
		
		echo '<span class="posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK.
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
		$byline = sprintf(
			esc_html_x( 'by %s', 'post author', 'wptailwind' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);
		
		echo '<span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK
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
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function wptailwind_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'wptailwind' ) );
			if ( $categories_list ) {
				/* translators: 1: list of categories. */
				printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'wptailwind' ) . '</span>', $categories_list ); // WPCS: XSS OK.
			}
			
			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'wptailwind' ) );
			if ( $tags_list ) {
				/* translators: 1: list of tags. */
				printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'wptailwind' ) . '</span>', $tags_list ); // WPCS: XSS OK.
			}
		}
		
		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link(
				sprintf(
					wp_kses(
					/* translators: %s: post title */
						__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'wptailwind' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				)
			);
			echo '</span>';
		}
		
		edit_post_link(
			sprintf(
				wp_kses(
				/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Edit <span class="screen-reader-text">%s</span>', 'wptailwind' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			),
			'<span class="edit-link">',
			'</span>'
		);
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
| Widget areas
|-------------------------------------------------
|
| Register widget areas/sidebars for the theme
| sidebar-1 is main sidebar used on posts and pages
|
*/
function wptailwind_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar Primary', 'wptailwind' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Primary sidebar for posts and pages.', 'wptailwind' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'wptailwind_widgets_init' );

/*
|-------------------------------------------------
| Scripts & Styles
|-------------------------------------------------
|
| Register and enqueue theme scripts and styles
|
*/
function wptailwind_scripts() {
	wp_enqueue_style( 'wptailwind-style', get_stylesheet_uri() );
	
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'wptailwind_scripts' );
