<?php
/*
 |-------------------------------------------------
 | WPTW_Nav_Walker Class
 |-------------------------------------------------
 |
 | Class to extend the WordPress Nav Menu class for
 | creating custom menu classes for tailwind
 |
 | @package wptailwind
 |
 */

# exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WPTW_Nav_Walker' ) ) :
	class WPTW_Nav_Walker extends Walker_Nav_Menu {
		/**
		 * fallback function when no menu is selected
		 *
		 * @param $args wp_nav_menu() args
		 *
		 * @return string
		 */
		public static function fallback( $args ) {
			if ( current_user_can( 'edit_theme_options' ) ) {
				$menu_class      = $args[ 'menu_class' ];
				$fallback_output = '<ul';
				if ( $menu_class ) {
					$fallback_output .= ' class="' . esc_attr( $menu_class ) . '"';
				}
				$fallback_output .= '>';
				$fallback_output .= '<li class="nav-menu-item flex"><a href="' . esc_url( admin_url( 'nav-menus.php' ) ) . '" class="flex items-center wptw-btn">' . esc_html__( 'Add a Menu', 'wptailwind' ) . '</a></li>';
				$fallback_output .= '</ul>';
				
				if ( array_key_exists( 'echo', $args ) && $args[ 'echo' ] ) {
					echo $fallback_output;
				} else {
					return $fallback_output;
				}
			}
		}
	}
endif;