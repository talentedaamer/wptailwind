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
if ( !defined( 'ABSPATH' ) ) {
    exit;
}

// TODO: Remove dev env after completion
define( 'WPTW_ENV', 'development' );

/**
 * Theme constants
 */
define( 'WPTAILWIND_VERSION', '1.0.0' );

/**
 * usage: if child theme or customize theme can give own template directory path
 */
define( 'WPTW_TEMPLATE_VIEWS_PATH', trailingslashit( 'template-parts' ) );

if ( !defined( 'WPTW_DIR_PATH' ) ) {
    define( 'WPTW_DIR_PATH', trailingslashit( get_template_directory() ) );
}
if ( !defined( 'WPTW_DIR_URI' ) ) {
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
if ( !function_exists( 'wptailwind_setup' ) ) :
    function wptailwind_setup()
    {
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
if ( !function_exists( 'wptailwind_content_width' ) ) :
    function wptailwind_content_width()
    {
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
if ( !function_exists( 'wptailwind_posted_on' ) ) :
    function wptailwind_posted_on()
    {
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
            wptailwind_meta_icon( 'clock' ),
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
if ( !function_exists( 'wptailwind_posted_by' ) ) :
    /**
     * Prints HTML with meta information for the current author.
     */
    function wptailwind_posted_by()
    {
        $byline = '<a class="font-serif ml-1" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a>';
        echo '<span class="posted-by wptw-svg-icon ml-4"> ' . wptailwind_meta_icon( 'user' ) . $byline . '</span>'; // WPCS: XSS OK
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
if ( !function_exists( 'wptailwind_comment_link' ) ) :
    function wptailwind_comment_link()
    {
        if ( !is_single() && !post_password_required() && ( comments_open() || get_comments_number() ) ) : ?>
            <span class="comments-link wptw-svg-icon ml-4">
                <?php echo wptailwind_meta_icon( 'message-circle' ); ?>
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
if ( !function_exists( 'wptailwind_entry_footer' ) ) :
    function wptailwind_entry_footer()
    {
        // display only on post type 'post'
        if ( 'post' === get_post_type() ) {
            $categories_list = get_the_category_list( esc_html__( ', ', 'wptailwind' ) );
            if ( $categories_list ) {
                printf(
                    '<span class="cat-links wptw-svg-icon">%1$s<span class="font-serif ml-1">%2$s</span></span>',
                    wptailwind_meta_icon( 'folder' ),
                    $categories_list
                );
            }
            
            /* translators: used between list items, there is a space after the comma */
            $tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'wptailwind' ) );
            if ( $tags_list ) {
                /* translators: 1: list of tags. */
                printf(
                    '<span class="tags-links wptw-svg-icon ml-4">%1$s<span class="font-serif ml-1">%2$s</span></span>',
                    wptailwind_meta_icon( 'hash' ),
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
            '<span class="edit-link wptw-svg-icon ml-4">' . wptailwind_meta_icon( 'edit' ),
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
if ( !function_exists( 'wptailwind_page_footer' ) ) :
    function wptailwind_page_footer()
    {
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
if ( !function_exists( 'wptailwind_post_thumbnail' ) ) :
    /**
     * Displays an optional post thumbnail.
     *
     * Wraps the post thumbnail in an anchor element on index views, or a div
     * element when on single views.
     */
    function wptailwind_post_thumbnail()
    {
        if ( post_password_required() || is_attachment() || !has_post_thumbnail() ) {
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
function wptailwind_widgets_init()
{
    register_sidebar( array(
        'name' => esc_html__( 'Sidebar Primary', 'wptailwind' ),
        'id' => 'sidebar-1',
        'description' => esc_html__( 'Primary sidebar for posts and pages.', 'wptailwind' ),
        'before_widget' => '<section id="%1$s" class="mb-8 widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h4 class="widget-title text-gray-900 mb-4 uppercase">',
        'after_title' => '</h2>',
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
function wptailwind_scripts()
{
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

function wptailwind_get_search_form()
{
    return '<form role="search" method="get" class="flex search-form" action="' . esc_url( home_url( '/' ) ) . '" xmlns="http://www.w3.org/1999/html">
        <input type="search" class="wptw-input w-full" placeholder="' . esc_attr_x( 'Search &hellip;', 'placeholder' ) . '" value="' . get_search_query() . '" name="s" />
        <button type="submit" class="w-auto flex justify-end items-center wptw-btn">' . wptailwind_meta_icon( 'search', 18 ) . '</button>
    </form>';
}
add_filter( 'get_search_form', 'wptailwind_get_search_form' );

if ( !function_exists( 'wptailwind_posts_pagination' ) ) :
    /**
     * Documentation for function.
     */
    function wptailwind_posts_pagination()
    {
        the_posts_pagination(
            array(
                'mid_size' => 2,
                // 'prev_next' => false,
                'before_page_number' => '<span class="bg-indigo-700 px-2 py-2 text-white">',
                'after_page_number' => '</span>',
                'prev_text' => sprintf(
                    '%s <span class="nav-prev-text">%s</span>',
                    wptailwind_get_icon( 'chevron-left' ),
                    __( 'Newer posts', 'wptailwind' )
                ),
                'next_text' => sprintf(
                    '<span class="nav-next-text">%s</span> %s',
                    __( 'Older posts', 'wptailwind' ),
                    wptailwind_get_icon( 'chevron-right' )
                ),
            )
        );
    }
endif;


/**
 * Astra Pagination
 */
if ( ! function_exists( 'astra_number_pagination' ) ) {
    
    /**
     * Astra Pagination
     *
     * @since 1.0.0
     * @return void            Generate & echo pagination markup.
     */
    function astra_number_pagination() {
        global $numpages;
        $enabled = apply_filters( 'astra_pagination_enabled', true );
        
        if ( isset( $numpages ) && $enabled ) {
            ob_start();
            echo "<div class='ast-pagination'>";
            the_posts_pagination(
                array(
                    'prev_text'    => astra_default_strings( 'string-blog-navigation-previous', false ),
                    'next_text'    => astra_default_strings( 'string-blog-navigation-next', false ),
                    'taxonomy'     => 'category',
                    'in_same_term' => true,
                )
            );
            echo '</div>';
            $output = ob_get_clean();
            echo apply_filters( 'astra_pagination_markup', $output ); // WPCS: XSS OK.
        }
    }
}

add_action( 'astra_pagination', 'astra_number_pagination' );


if ( !function_exists( 'wptailwind_body_classes' ) ) {
    function wptailwind_body_classes( $classes )
    {
        
        // Adds a class of group-blog to blogs with more than 1 published author.
        if ( is_multi_author() ) {
            $classes[] = 'group-blog';
        }
        // Adds a class of hfeed to non-singular pages.
        if ( !is_singular() ) {
            $classes[] = 'hfeed';
        }
        
        // get layout container type.
        // $container_typ = get_theme_mod( 'bp_container_type' );
        // Adds class of 'bp-boxed-layout' if boxed layout selected.
        // if ( 'container' == $container_typ ) {
        // 	$classes[] = 'bp-boxed-layout';
        // }
        
        
        return $classes;
    }
}
add_filter( 'body_class', 'wptailwind_body_classes' );

if ( !function_exists( 'wptailwind_post_classes' ) ) {
    function wptailwind_post_classes( $classes, $class, $post_id )
    {
        // echo '<pre>';
        // print_r($post_id);
        // print_r($classes);
        // echo '</pre>';
        // if ( ! is_admin() ) { //make sure we are in the dashboard
        // 	return $classes;
        // }
        // $screen = get_current_screen(); //verify which page we're on
        // if ('my-custom-type' != $screen->post_type && 'edit' != $screen->base) {
        // 	return $classes;
        // }
        // //check if some meta field is set
        // $profile_incomplete = get_post_meta($post_id, 'profile_incomplete', true);
        // if ('yes' == $profile_incomplete) {
        // 	$classes[] = 'profile_incomplete'; //add a custom class to highlight this row in the table
        // }
        
        // if ( is_sticky( $post_id ) ) {
        //    $classes[] = 'bg-gray-200';
        // }
        
        // $stickies = get_option( 'sticky_posts' );
        // is_array( $stickies ) && in_array( $post_id, $stickies )
        
        if ( !is_singular() && is_sticky() ) {
            $classes[] = 'p-10 bg-gray-100 border-2 border-gray-300';
        }
        
        return $classes;
    }
}
add_filter( 'post_class', 'wptailwind_post_classes', 10, 3 );


require WPTW_DIR_PATH . 'inc/functions-icons.php';
require WPTW_DIR_PATH . 'inc/functions-header-image.php';
require WPTW_DIR_PATH . 'inc/config/config.php';


add_action( 'wptc_loop', 'wptc_loop_cb' );
function wptc_loop_cb()
{
    
    if ( have_posts() ) {
        
        /**
         * hook: wptc_before_while_have_posts
         * @hooked : wptc_home_single_post_title 5
         * @hooked : hooked actions TODO
         */
        do_action( 'wptc_before_while_have_posts' );
        
        while ( have_posts() ) {
            
            the_post();
            
            /**
             * hook: wptc_before_entry
             */
            do_action( 'wptc_before_entry' );
            
            /**
             * load entry content template
             */
            wptw_get_template_part( 'content', get_post_type() );
            
            /**
             * hook: wptc_after_entry
             */
            do_action( 'wptc_after_entry' );
            
        } // while() loop
        
        /**
         * hook: wptc_after_endwhile_have_posts
         */
        do_action( 'wptc_after_endwhile_have_posts' );
        
    } else {
        
        /**
         * load no post found template
         */
        wptw_get_template_part( 'content', 'none' );
        
    } // end: if have_posts()
}


/*
|-------------------------------------------------
| get template part with cache
|-------------------------------------------------
|
| get template part for content template for loop
|
| @param string $slug template slug
| @param string $name template name
|
*/
function wptw_get_template_part( $slug, $name = '' )
{
    /**
     * serialize key to store the cache
     */
    $cache_key = sanitize_key( implode( '-', array( 'template-part', $slug, $name ) ) );
    
    /**
     * load get template from wp_cache object
     */
    $template = (string)wp_cache_get( $cache_key, 'wctw_cache' );
    
    /**
     * if template is not in cache
     */
    if ( !$template ) {
        $template_arr = array();
        /**
         * if template name is provided to function
         */
        if ( $name ) {
            $template_arr[] = template_path() . "{$slug}-{$name}.php";
        }
        $template_arr[] = template_path() . "{$slug}.php";
        $template = locate_template( $template_arr, false, false );
        
        /**
         * if above template is not found
         */
        if ( !$template ) {
            $base_template = WPTW_DIR_PATH . "/template-parts/{$slug}-{$name}.php";
            $template = file_exists( $base_template ) ? $base_template : '';
        }
        
        /**
         * Saves the data to the cache
         */
        wp_cache_set( $cache_key, $template, 'wctw_cache' );
    }
    
    /**
     * if template found load the template
     */
    if ( $template ) {
        load_template( $template, false );
    }
}

// TODO : test this
add_action( 'wptc_before_while_have_posts', 'wptc_home_single_post_title', 5 );
function wptc_home_single_post_title() {
   if ( is_home() && ! is_front_page() ) :
       single_post_title();
   endif;
}