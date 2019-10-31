<?php
/*
 |-------------------------------------------------
 | Main Sidebar
 |-------------------------------------------------
 |
 | Sidebar template loads main widget area on sidebar
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
 * if no widget added, return;
 */
if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}

dynamic_sidebar( 'sidebar-1' );
?>