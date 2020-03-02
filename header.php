<?php
/*
 |-------------------------------------------------
 | The main header file
 |-------------------------------------------------
 |
 | This is the main header file which contains
 | <head> section of theme, header layout, nav
 | and starting container of the theme
 |
 | @package wptailwind
 |
 */

# exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
    <!doctype html>
<html <?php language_attributes(); ?>>
    <head>
		<?php do_action( 'wptw_before_head' ); ?>
        <meta charset="<?php bloginfo( 'charset' ); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="profile" href="https://gmpg.org/xfn/11">
		
		<?php wp_head(); ?>
		<?php do_action( 'wptw_after_head' ); ?>
    </head>
<body <?php body_class( 'font-sans font-light text-base leading-relaxed' ); ?>>

<?php
/**
 * before header element hook
 */
do_action( 'wptw_before_header' ); ?>

    <header id="wptw-header" <?php wptw_header_class( 'w-full bg-white shadow py-4' ); ?>>
        <div class="container w-full mx-auto flex flex-wrap items-center justify-between px-4">
            <div class="wptw-logo-wrap">
				<?php wptw_site_logo(); ?>
                <?php wptw_site_description(); ?>
            </div>
            <div class="wptw-menu-toggle block lg:hidden">
                <button id="nav-toggle" class="flex items-center px-3 py-2 border rounded text-gray-500 border-gray-600 hover:text-gray-900 hover:border-teal-500 appearance-none focus:outline-none">
                    <svg class="fill-current h-3 w-3" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><title>
                            Menu</title>
                        <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"></path>
                    </svg>
                </button>
            </div>
            <div id="nav-content" class="wptw-primary-menu-wrap w-full flex-grow lg:flex lg:items-center lg:w-auto hidden lg:block mt-2 lg:mt-0 md:bg-transparent z-20 bg-white">
				<?php
				wp_nav_menu( [
					'theme_location' => 'menu-1',
					'container'      => false,
					'menu_id'        => 'primary-menu',
					'menu_class'     => 'wptw-navbar list-reset lg:flex justify-end flex-1 items-center',
					'fallback_cb'    => 'WPTW_Nav_Walker::fallback',
				] );
				?>
            </div>
        </div>
    </header>

<?php
/**
 * after header element hook
 * @hooked: wptw_custom_header_image
 */
do_action( 'wptw_after_header' );
?>