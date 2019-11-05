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

<header id="wptw-header" class="wptw-header py-8 mb-16 border-b border-gray-300">
    <div class="container">
        <div class="flex items-center flex-wrap">
            <div class="flex flex-col items-start flex-shrink-0 mr-6">
                <h1 class="site-title">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
                </h1>
				<?php
				$wptw_desc = get_bloginfo( 'description', 'display' );
				if ( $wptw_desc || is_customize_preview() ) : ?>
                    <p class="site-desc mt-2">
						<?php echo $wptw_desc; ?>
                    </p>
				<?php endif; ?>
            </div>

            <div id="primary-nav" class="primary-nav w-full block flex-grow lg:flex lg:items-center lg:w-auto">
                <div class="text-sm lg:flex-grow">
					<?php
					wp_nav_menu( [
						'theme_location' => 'menu-1',
						'menu_id'        => 'primary-menu',
						'menu_class'     => 'flex',
					] );
					?>
                </div>
            </div>
        </div>
    </div>
</header><!--wptw-header-->
