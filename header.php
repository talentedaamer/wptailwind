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

/**
 * exit if accessed directly
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
	
	<?php wp_head(); ?>
</head>

<body <?php body_class( 'font-sans font-light text-lg leading-relaxed' ); ?>>

<!--wptw-header-->
<header id="wptw-header" class="wptw-header w-full bg-white shadow mb-16">
    <div class="container w-full mx-auto flex flex-wrap items-center justify-between py-4">
        <!--wptw-logo-wrap-->
        <div class="wptw-logo-wrap">
            <h1 class="font-bold">
                <a class="text-gray-900" href="#">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
				        <?php bloginfo( 'name' ); ?>
                    </a>
                </a>
            </h1>
	        <?php
	        $wptw_desc = get_bloginfo( 'description', 'display' );
	        if ( $wptw_desc || is_customize_preview() ) : ?>
                <p class="site-desc text-gray-700">
			        <?php echo $wptw_desc; ?>
                </p>
	        <?php endif; ?>
        </div>
        <!--end:wptw-logo-wrap-->
        
        <!--wptc-menu-toggle-->
        <div class="wptc-menu-toggle block lg:hidden">
            <button id="nav-toggle" class="flex items-center px-3 py-2 border rounded text-gray-500 border-gray-600 hover:text-gray-900 hover:border-teal-500 appearance-none focus:outline-none">
                <svg class="fill-current h-3 w-3" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><title>Menu</title><path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"></path></svg>
            </button>
        </div>
        <!--end:wptc-menu-toggle-->

        <!--wptc-primary-menu-wrap-->
        <div class="wptw-primary-menu-wrap w-full flex-grow lg:flex lg:items-center lg:w-auto hidden lg:block mt-2 lg:mt-0 md:bg-transparent z-20 bg-white" id="nav-content">
	        <?php
	        wp_nav_menu( [
		        'theme_location' => 'menu-1',
		        'container' => false,
		        'menu_id'        => 'primary-menu',
		        'menu_class'     => 'list-reset lg:flex justify-end flex-1 items-center',
	        ] );
	        ?>
        </div>
        <!--end:wptc-primary-menu-wrap-->
    </div>

    <!--wptw-header-image-->
	<?php
	// the_custom_header_markup();
	$header_image = get_header_image();
	if ( $header_image ) {
		echo '<div class="wptw-header-image bg-fixed bg-no-repeat bg-cover bg-center" style="background-image: url('.$header_image.'); height: 380px;"></div>';
	}
	?>
    <!--end:wptw-header-image-->
</header>
<!--end:wptw-header-->