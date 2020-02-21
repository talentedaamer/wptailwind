<?php
/*
 |-------------------------------------------------
 | The main footer file
 |-------------------------------------------------
 |
 | This is the main footer file which contains
 | footer widgets, copyright text and closing container
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

<div class="footer-widgets bg-gray-200">
    <div class="container px-4 text-center py-16">
	<?php
	$icons = array(
		'hash',
		'folder',
		'arrow-down',
		'arrow-left',
		'arrow-right',
		'arrow-up',
		'bookmark',
		'calendar',
		'chevron-down',
		'chevron-left',
		'chevron-right',
		'chevron-up',
		'clock',
		'corner-down-right',
		'edit',
		'pencil',
		'external-link',
		'heart',
		'home',
		'loader',
		'link',
		'mail',
		'map-pin',
		'menu',
		'message-circle',
		'message-square',
		'phone',
		'search',
		'tag',
		'user'
	);
	foreach ( $icons as $icon ) { ?>
    <span class="p-2 mx-1 bg-secondary-700 text-white inline-block mb-2 leading-none">
        <?php echo wptailwind_meta_icon( $icon, '20' ); ?>
    </span>
    <?php
	}
	?>
</div>
</div>

<?php do_action( 'wptw_before_footer' ); ?>
<footer <?php wptw_footer_class(); ?>>
    <div <?php wptw_container_class(); ?>>
	    <?php
	    /**
	     * standard footer copyright text
	     * @hooked: wptw_do_footer
	     */
	    do_action( 'wptw_footer_credits' );
	    ?>
    </div>
</footer>
<?php do_action( 'wptw_after_footer' ); ?>

<?php wp_footer(); ?>
</body>
</html>
