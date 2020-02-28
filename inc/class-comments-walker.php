<?php

if ( ! class_exists( 'wptw_comment_walker' ) ) {
	class wptw_comment_walker extends Walker_Comment {
		protected function html5_comment( $comment, $depth, $args ) {
			$tag                = ( 'div' === $args[ 'style' ] ) ? 'div' : 'li';
			$comment_author_url = get_comment_author_url( $comment );
			$comment_author     = get_comment_author( $comment );
			$avatar             = get_avatar(
				$comment,
				$args[ 'avatar_size' ],
				'',
				'',
				array(
					'class' => 'w-12 h-12 rounded-full border border-gray-300',
				)
			);
			?>
            <<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( $this->has_children ? 'parent' : '', $comment ); ?>>
            <article id="div-comment-<?php comment_ID(); ?>" class="comment-body w-full border-b border-gray-300 pb-8 mb-8">
                <header class="comment-meta mb-4">
                    <div class="comment-author vcard flex mb-4">
						<?php if ( 0 !== $args[ 'avatar_size' ] ) { ?>
                            <div class="author-avatar"><?php echo wp_kses_post( $avatar ); ?></div>
						<?php } ?>
                        <div class="author-meta ml-4">
							<?php
							if ( ! empty( $comment_author_url ) ) {
								printf(
									'<div class="author-link font-bold"><a href="%s" rel="external nofollow" class="url">%s</a></div>',
									$comment_author_url,
									esc_html( $comment_author )
								);
							}
							?>
                            <div class="comment-meta text-sm">
                                <?php
                                wptw_comment_posted_on( $comment, $args );
                                wptw_comment_edit_link();
								?>
                            </div>
                        </div>
                    </div>
                </header>

                <div class="comment-content entry-content">
					<?php
					comment_text();
					if ( '0' === $comment->comment_approved ) {
						?>
                        <p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'wptailwind' ); ?></p>
						<?php
					}
					?>
                </div>
				
				<?php
				$comment_reply_link = get_comment_reply_link(
					array_merge(
						$args,
						array(
							'add_below' => 'div-comment',
							'depth'     => $depth,
							'max_depth' => $args[ 'max_depth' ],
							'before'    => '<div class="comment-reply mt-4">',
							'after'     => '</div>',
						)
					)
				);
				
				$by_post_author = wptw_is_commenter_post_author( $comment );
				
				if ( $comment_reply_link || $by_post_author ) { ?>
                    <footer class="comment-footer-meta">
						<?php
						if ( $comment_reply_link ) {
							echo $comment_reply_link;
						}
						if ( $by_post_author ) {
							echo '<span class="by-post-author border-b-2 border-gray-700 font-bold text-gray-700 text-xs uppercase">' . __( 'By Post Author', 'twentytwenty' ) . '</span>';
						}
						?>
                    </footer>
					<?php
				}
				?>
            </article>
			
			<?php
		}
	}
}