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
if ( ! defined( 'WPTAILWIND_DIR' ) ) {
	define( 'WPTAILWIND_DIR', trailingslashit( get_template_directory() ) );
}
if ( ! defined( 'WPTAILWIND_URI' ) ) {
	define( 'WPTAILWIND_URI', trailingslashit( get_template_directory_uri() ) );
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
		
		$posted_on = '<a class="font-serif ml-1" href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>';
		
		echo '<span class="posted-on wptw-svg-icon">' . wptailwind_meta_icon( 'clock' ) . $posted_on . '</span>';
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
		echo '<span class="posted-by wptw-svg-icon ml-2"> ' . wptailwind_meta_icon( 'user' ) . $byline . '</span>'; // WPCS: XSS OK
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
					__( 'Edit <span class="screen-reader-text">%s</span>', 'wptailwind' ),
					[ 'span' => [ 'class' => [] ] ]
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
					'alt' => the_title_attribute( [ 'echo' => FALSE ] ),
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
		'before_widget' => '<section id="%1$s" class="mb-8 p-4 widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="mb-4 widget-title">',
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
	// wp_enqueue_style( 'google-fonts', 'https://fonts.googleapis.com/css?family=PT+Sans:400,700|Playfair+Display:400,700&display=swap', '', WPTAILWIND_VERSION );
	wp_enqueue_style( 'google-fonts', 'https://fonts.googleapis.com/css?family=Lato:300,400,700|Raleway:400,700&display=swap', '', WPTAILWIND_VERSION );
	wp_enqueue_style( 'wptailwind-style', get_stylesheet_uri() );
	wp_enqueue_style( 'wptailwind-main-css', WPTAILWIND_URI . 'assets/css/app.css', '', WPTAILWIND_VERSION );
	
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
function wptailwind_get_search_form() {
	$form = '<form role="search" method="get" class="search-form input-group" action="' . esc_url( home_url( '/' ) ) . '" xmlns="http://www.w3.org/1999/html">
							<input type="search" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500" placeholder="' . esc_attr_x( 'Search &hellip;', 'placeholder' ) . '" value="' . get_search_query() . '" name="s" />
						<span class="input-group-btn">
							<button type="submit" class="btn btn-primary">'. wptailwind_meta_icon( 'search', 16 ) .'</button>
						</span>
					</form>';
	
	return $form;
}

add_filter( 'get_search_form', 'wptailwind_get_search_form' );

require WPTAILWIND_DIR . '/inc/functions-icons.php';