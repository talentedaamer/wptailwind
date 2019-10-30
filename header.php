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

<body <?php body_class(); ?>>
    <?php
    if ( is_front_page() && is_home() ) :
        ?>
        <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
        <?php
    else :
        ?>
        <p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
        <?php
    endif;
    $wptailwind_description = get_bloginfo( 'description', 'display' );
    if ( $wptailwind_description || is_customize_preview() ) : ?>
        <p class="site-description"><?php echo $wptailwind_description; ?></p>
    <?php endif; ?>
    
    <nav id="site-navigation" class="main-navigation">
        <?php
        wp_nav_menu( [
            'theme_location' => 'menu-1',
            'menu_id' => 'primary-menu',
        ] );
        ?>
    </nav>
    
    <div id="content" class="content-wrap">
