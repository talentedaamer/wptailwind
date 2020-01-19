<?php

add_action( 'wptw_loop', 'wptw_do_loop', 10 );

add_action( 'wptw_sidebar', 'wptw_do_sidebar', 10 );

// TODO : test this
add_action( 'wptw_before_while_have_posts', 'wptw_home_single_post_title', 10 );

add_action( 'wptw_before_while_have_posts', 'wptw_do_archive_page_title', 20 );
add_action( 'wptw_before_while_have_posts', 'wptw_do_search_page_title', 20 );