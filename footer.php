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

<footer id="colophon" class="site-footer bg-gray-700">
    <div class="container bg-gray-200">
        <p class="px-2 py-4">
			<?php
			printf(
				esc_html__( 'Proudly powered by %s', 'wptailwind' ),
				'WordPress'
			);
			?>
        </p>
    </div>
</footer>



<div class="container text-center mt-4 mb-10">
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
		'user',
	);
	foreach ( $icons as $icon ) {
		?>
        <span class="p-4 mx-2 bg-indigo-700 text-white inline-block mb-4"><?php echo wptailwind_meta_icon( $icon, '40' ); ?></span>
		<?php
	}
	?>
</div>

<?php wp_footer(); ?>

</body>
</html>
