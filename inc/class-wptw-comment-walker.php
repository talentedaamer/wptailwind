<?php
if ( ! class_exists( 'WPTW_Comment_Walker' ) ) {
	class WPTW_Comment_Walker extends Walker_Comment {
		protected function html5_comment( $comment, $depth, $args ) {
			$tag = ( 'div' === $args[ 'style' ] ) ? 'div' : 'li';
			?>
            <<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( $this->has_children ? 'parent mb-4' : 'mb-4', $comment ); ?>>
            <article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
                <footer class="comment-meta">
                    <div class="comment-author vcard">
						<?php
						$comment_author_url = get_comment_author_url( $comment );
						$comment_author     = get_comment_author( $comment );
						$avatar             = get_avatar( $comment, $args[ 'avatar_size' ] );
						if ( 0 !== $args[ 'avatar_size' ] ) {
							if ( empty( $comment_author_url ) ) {
								echo wp_kses_post( $avatar );
							} else {
								printf( '<a href="%s" rel="external nofollow" class="url">', $comment_author_url ); //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped --Escaped in https://developer.wordpress.org/reference/functions/get_comment_author_url/
								echo wp_kses_post( $avatar );
							}
						}
						
						printf(
							'<span class="fn">%1$s</span><span class="screen-reader-text says">%2$s</span>',
							esc_html( $comment_author ),
							__( 'says:', 'twentytwenty' )
						);
						
						if ( ! empty( $comment_author_url ) ) {
							echo '</a>';
						}
						?>
                    </div><!-- .comment-author -->

                    <div class="comment-metadata">
                        <a href="<?php echo esc_url( get_comment_link( $comment, $args ) ); ?>">
							<?php
							/* Translators: 1 = comment date, 2 = comment time */
							$comment_timestamp = sprintf( __( '%1$s at %2$s', 'twentytwenty' ), get_comment_date( '', $comment ), get_comment_time() );
							?>
                            <time datetime="<?php comment_time( 'c' ); ?>"
                                  title="<?php echo esc_attr( $comment_timestamp ); ?>">
								<?php echo esc_html( $comment_timestamp ); ?>
                            </time>
                        </a>
						<?php
						if ( get_edit_comment_link() ) {
							echo ' <span aria-hidden="true">&bull;</span> <a class="comment-edit-link" href="' . esc_url( get_edit_comment_link() ) . '">' . __( 'Edit', 'twentytwenty' ) . '</a>';
						}
						?>
                    </div><!-- .comment-metadata -->

                </footer><!-- .comment-meta -->

                <div class="comment-content entry-content">
					
					<?php
					
					comment_text();
					
					if ( '0' === $comment->comment_approved ) {
						?>
                        <p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'twentytwenty' ); ?></p>
						<?php
					}
					
					?>

                </div><!-- .comment-content -->
				
				<?php
				
				$comment_reply_link = get_comment_reply_link(
					array_merge(
						$args,
						array(
							'add_below' => 'div-comment',
							'depth'     => $depth,
							'max_depth' => $args[ 'max_depth' ],
							'before'    => '<span class="comment-reply">',
							'after'     => '</span>',
						)
					)
				);
				
				$by_post_author = twentytwenty_is_comment_by_post_author( $comment );
				
				if ( $comment_reply_link || $by_post_author ) {
					?>

                    <footer class="comment-footer-meta">
						
						<?php
						if ( $comment_reply_link ) {
							echo $comment_reply_link; //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped --Link is escaped in https://developer.wordpress.org/reference/functions/get_comment_reply_link/
						}
						if ( $by_post_author ) {
							echo '<span class="by-post-author">' . __( 'By Post Author', 'twentytwenty' ) . '</span>';
						}
						?>

                    </footer>
					
					<?php
				}
				?>

            </article><!-- .comment-body -->
			
			<?php
		}
	}
}

function twentytwenty_is_comment_by_post_author( $comment = null ) {
	
	if ( is_object( $comment ) && $comment->user_id > 0 ) {
		
		$user = get_userdata( $comment->user_id );
		$post = get_post( $comment->comment_post_ID );
		
		if ( ! empty( $user ) && ! empty( $post ) ) {
			
			return $comment->user_id === $post->post_author;
			
		}
	}
	return false;
	
}