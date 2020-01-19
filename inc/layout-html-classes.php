<?php
/**
 * this file contains default html classes for theme layout
 */

# site body classes

# site header classes

# site container classes

# site content-sidebar-wrapper classes

# content wrapper classes

# content classes

# sidebar wrapper classes

# sidebar classes

/**
 * displays the classes for the content sidebar wrap element
 *
 * @param string|array $class one or more classes to add to the class list.
 */
function wptw_content_sidebar_class( $class = '' ) {
    # Separates classes with a single space
    echo 'class="' . join( ' ', wptw_get_content_sidebar_class( $class ) ) . '"';
}

/**
 * retrieves an array of the class names for the content sidebar wrap container
 * these classes are based on tailwind css framework which make content/sidebar layout
 *
 * @since 1.0.1
 *
 * @param string $class Space-separated string or array of class names to add to the class list.
 *
 * @return array array of class names.
 */
function wptw_get_content_sidebar_class( $class = '' ) {
    $classes = array();
    
    if ( $class ) {
        if ( ! is_array( $class ) ) {
            $class = preg_split( '#\s+#', $class );
        }
        $classes = array_map( 'esc_attr', $class );
    } else {
        // Ensure that we always coerce class to being an array.
        $class = array();
    }
    
    $classes[] = 'wptw-content-sidebar-wrap';
    $classes[] = 'flex';
    $classes[] = '-mx-4';
    
    /**
     * filters the list of CSS class names for content sidebar wrap element
     *
     * @since 1.0.1
     *
     * @param string[] $classes An array of post class names.
     * @param string[] $class An array of additional class names added to the post.
     */
    $classes = apply_filters( 'wptw_content_sidebar_class', $classes, $class );
    
    return array_unique( $classes );
}

/**
 * displays the classes for the content wrap element
 *
 * @param string|array $class one or more classes to add to the class list.
 */
function wptw_content_class( $class = '' ) {
    # Separates classes with a single space
    echo 'class="' . join( ' ', wptw_get_content_class( $class ) ) . '"';
}

/**
 * retrieves an array of the class names for the content wrap container
 * these classes are based on tailwind css framework which make layout
 *
 * @since 1.0.1
 *
 * @param string $class Space-separated string or array of class names to add to the class list.
 *
 * @return array array of class names.
 */
function wptw_get_content_class( $class = '' ) {
    $classes = array();
    
    if ( $class ) {
        if ( ! is_array( $class ) ) {
            $class = preg_split( '#\s+#', $class );
        }
        $classes = array_map( 'esc_attr', $class );
    } else {
        // Ensure that we always coerce class to being an array.
        $class = array();
    }
    
    $classes[] = 'content-wrap';
    $classes[] = 'sm:w-1/3';
    $classes[] = 'md:w-2/3';
    $classes[] = 'lg:w-3/4';
    $classes[] = 'xl:w-3/4';
    $classes[] = 'w-full';
    $classes[] = 'px-4';
    
    /**
     * filters the list of CSS class names for content wrap element
     *
     * @since 1.0.1
     *
     * @param string[] $classes An array of post class names.
     * @param string[] $class An array of additional class names added to the post.
     */
    $classes = apply_filters( 'wptw_content_class', $classes, $class );
    
    return array_unique( $classes );
}

/**
 * displays the classes for the sidebar wrap element
 *
 * @param string|array $class one or more classes to add to the class list.
 */
function wptw_sidebar_class( $class = '' ) {
    # Separates classes with a single space
    echo 'class="' . join( ' ', wptw_get_sidebar_class( $class ) ) . '"';
}

/**
 * retrieves an array of the class names for the sidebar wrap container
 * these classes are based on tailwind css framework which make layout
 *
 * @since 1.0.1
 *
 * @param string $class Space-separated string or array of class names to add to the class list.
 *
 * @return array array of class names.
 */
function wptw_get_sidebar_class( $class = '' ) {
    $classes = array();
    
    if ( $class ) {
        if ( ! is_array( $class ) ) {
            $class = preg_split( '#\s+#', $class );
        }
        $classes = array_map( 'esc_attr', $class );
    } else {
        // Ensure that we always coerce class to being an array.
        $class = array();
    }
    
    $classes[] = 'sidebar-wrap';
    $classes[] = 'sm:w-1/3';
    $classes[] = 'md:w-1/3';
    $classes[] = 'lg:w-1/4';
    $classes[] = 'xl:w-1/4';
    $classes[] = 'w-full';
    $classes[] = 'px-4';
    
    /**
     * filters the list of CSS class names for sidebar wrap element
     *
     * @since 1.0.1
     *
     * @param string[] $classes An array of post class names.
     * @param string[] $class An array of additional class names added to the post.
     */
    $classes = apply_filters( 'wptw_sidebar_class', $classes, $class );
    
    return array_unique( $classes );
}