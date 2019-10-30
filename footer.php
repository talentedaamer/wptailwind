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

	</div>
	<footer id="colophon" class="site-footer">
        <?php
        printf(
            esc_html__( 'Proudly powered by %s', 'wptailwind' ),
            'WordPress'
        );
        ?>
	</footer>

<?php wp_footer(); ?>

</body>
</html>
