<?php
/*
 |-------------------------------------------------
 | Theme template functions
 |-------------------------------------------------
 |
 | site template functions like post or page meta
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
 | Post meta posted_on
 |-------------------------------------------------
 |
 | Display post meta posted on information e.g date
 | displayed only on post type 'post'.
 |
 */
if ( ! function_exists( 'wptw_posted_on' ) ) :
	function wptw_posted_on() {
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
		
		$posted_on = sprintf(
			'<span class="posted-on wptw-svg-icon">%1$s<a class="font-serif ml-1" href="%2$s" rel="bookmark">%3$s</a></span>',
			wptw_meta_icon( 'clock' ),
			esc_url( get_permalink() ),
			$time_string
		);
		
		$posted_on = apply_filters( 'wptw_posted_on', $posted_on, $time_string );
		
		echo $posted_on;
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
if ( ! function_exists( 'wptw_posted_by' ) ) :
	/**
	 * Prints HTML with meta information for the current author.
	 */
	function wptw_posted_by() {
		$byline = sprintf(
			'<a class="font-serif ml-1" href="%1$s">%2$s</a>',
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_html( get_the_author() )
		);
		
		$posted_by = sprintf( '<span class="posted-by wptw-svg-icon ml-4">%1$s %2$s</span>',
			wptw_get_icon( 'user', 16 ),
			$byline
		);
		
		$posted_by = apply_filters( 'wptw_posted_by', $posted_by, $byline );
		
		echo $posted_by;
	}
endif;

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
function wptw_get_template_part( $slug, $name = '' ) {
	# serialize key to store the cache
	$cache_key = sanitize_key( implode( '-', array( 'template-part', $slug, $name ) ) );
	
	# load get template from wp_cache object
	$template = (string) wp_cache_get( $cache_key, 'wctw_cache' );
	
	# if template is not in cache
	if ( ! $template ) {
		$template_arr = array();
		/**
		 * if template name is provided to function
		 * load template if developer has set another path
		 */
		if ( $name ) {
			$template_arr[] = template_path() . "{$slug}-{$name}.php";
		}
		$template_arr[] = template_path() . "{$slug}.php";
		$template       = locate_template( $template_arr, false, false );
		
		/**
		 * if above template is not found
		 * load the default templates
		 */
		if ( ! $template ) {
			$base_template = WPTW_DIR_PATH . "/template-parts/{$slug}-{$name}.php";
			$template      = file_exists( $base_template ) ? $base_template : '';
		}
		
		$template = apply_filters( 'wptw_get_template_part', $template );
		
		# cache found template for rest of loop
		wp_cache_set( $cache_key, $template, 'wctw_cache' );
	}
	
	# if template found load the template
	if ( $template ) {
		load_template( $template, false );
	}
}

/*
 |-------------------------------------------------
 | Post meta comments
 |-------------------------------------------------
 |
 | Display post meta comments or post comment link
 | displayed only on post type 'post'.
 |
 */
if ( ! function_exists( 'wptw_comment_link' ) ) :
	function wptw_comment_link() {
		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) :
			?>
            <span class="comments-link wptw-svg-icon ml-4">
                <?php echo wptw_get_icon( 'message-circle', 16 ); ?>
                <?php comments_popup_link( false, false, false, 'font-serif ml-1', false ); ?>
            </span>
		<?php
		endif;
	}
endif;

/*
|-------------------------------------------------
| Post footer meta
|-------------------------------------------------
|
| Display post footer meta information
| post tags, post categories, edit link, comments
|
*/
if ( ! function_exists( 'wptw_entry_footer' ) ) :
	function wptw_entry_footer() {
		
		# display only on post type 'post'
		if ( 'post' === get_post_type() ) {
			$categories_list = get_the_category_list( esc_html__( ', ', 'wptailwind' ) );
			if ( $categories_list ) {
				$post_categories = sprintf(
					'<span class="cat-links wptw-svg-icon">%1$s<span class="font-serif ml-1">%2$s</span></span>',
					wptw_get_icon( 'folder', 16 ),
					$categories_list
				);
				echo apply_filters( 'wptw_entry_footer_categories_link', $post_categories, $categories_list );
			}
			
			$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'wptailwind' ) );
			if ( $tags_list ) {
				$post_tags = sprintf(
					'<span class="tags-links wptw-svg-icon ml-4">%1$s<span class="font-serif ml-1">%2$s</span></span>',
					wptw_meta_icon( 'hash' ),
					$tags_list
				);
				echo apply_filters( 'wptw_entry_footer_tags_link', $post_tags, $tags_list );
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
if ( ! function_exists( 'wptw_page_footer' ) ) :
	function wptw_page_footer() {
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
| Displays an optional post thumbnail. Wrapped in
| anchor tags on index and div on single post.
|
*/
if ( ! function_exists( 'wptw_post_thumbnail' ) ) :
	function wptw_post_thumbnail() {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}
		
		if ( is_singular() ) :
			?>
            <div class="post-thumbnail-classes">
				<?php the_post_thumbnail(); ?>
            </div>
		<?php
		else :
			?>
            <a class="post-thumbnail-classes" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
				<?php
				the_post_thumbnail( 'post-thumbnail', [
					'alt' => the_title_attribute( [ 'echo' => false ] ),
				] );
				?>
            </a>
		<?php
		endif;
	}
endif;

/*
|-------------------------------------------------
| Posts Pagination
|-------------------------------------------------
|
| posts pagination
|
*/
if ( ! function_exists( 'wptw_posts_pagination' ) ) :
	function wptw_posts_pagination( $mid_size = 2 ) {
		$prev_text = sprintf(
			'%s <span class="nav-prev-text">%s</span>',
			wptw_get_icon( 'chevron-left' ),
			__( 'Newer posts', 'wptailwind' )
		);
		$next_text = sprintf(
			'<span class="nav-next-text">%s</span> %s',
			__( 'Older posts', 'wptailwind' ),
			wptw_get_icon( 'chevron-right' )
		);
		
		$post_pagination = get_the_posts_pagination(
			array(
				'mid_size' => $mid_size,
				'before_page_number' => '<span class="bg-indigo-700 px-2 py-2 text-white">',
				'after_page_number' => '</span>',
				'prev_text' => $prev_text,
				'next_text' => $next_text,
			)
		);
		
		echo apply_filters( 'wptw_posts_pagination', $post_pagination, $prev_text, $next_text );
	}
endif;

function wptw_comments_nav() {
	if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
        <ul id="comments-nav" class="comments-nav flex justify-between mb-4">
			<?php
			if ( get_previous_comments_link() ) {
				printf(
					'<li>%s</li>',
					sprintf(
						get_previous_comments_link( __( '%s Older Comments', 'wptailwind' ) ),
						wptw_get_icon( 'arrow-left', 16 )
					)
				);
			}
			if ( get_next_comments_link() ) {
				printf(
					'<li>%s</li>',
					sprintf(
						get_next_comments_link( __( 'Newer Comments %s', 'wptailwind' ) ),
						wptw_get_icon( 'arrow-right', 16 )
					)
				);
			}
			?>
        </ul>
	<?php
	endif;
}

function wptw_posts_nav( $args ) {
	$previous_link = get_previous_post_link( '<div class="nav-previous">%link</div>' );
	$next_link     = get_next_post_link( '<div class="nav-next">%link</div>' );
	
	echo $previous_link . ' ' . $next_link;
}

add_filter( 'navigation_markup_template', function ( $template ) {
	$template = '
	<nav class="navigation" role="navigation" aria-label="%4$s">
		<div class="nav-links flex justify-between mb-4">%3$s</div>
	</nav>';
	
	$template = apply_filters( 'wptw_posts_nav_markup_template', $template );
	
	return $template;
} );

// add_filter( 'previous_comments_link_attributes', function () {
// 	return 'class="wptw-btn wptw-btn-sm"';
// } );
//
// add_filter( 'next_comments_link_attributes', function () {
// 	return 'class="wptw-btn wptw-btn-sm"';
// } );