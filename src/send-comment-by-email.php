<?php

/**
 * by ShellHacks
 * WordPress script: send-comment-by-email
 * Copyright (c) 2011-2024 www.ShellHacks.com <mail@shellhacks.com>
 *
 * Send new WordPress comments by email 
 * Documentation: https://www.shellhacks.com/wordpress-comment-hook-trigger-action-example
 * Source: https://github.com/shellhacks/WordPress/blob/main/src/send-comment-by-email.php
 *
 * Tested on WordPress, version=6.4.2
 * Version: 1.0.0
 */

function send_comment_by_email( $comment_id, $comment_approved ) {
  if ( ! $comment_approved ) {
    $comment = get_comment( $comment_id );
    $mail = 'my_address@email.tld';
    $subject = sprintf( 'New Comment by: %s', $comment->comment_author );
    $message = $comment->comment_content;
    wp_mail( $mail, $subject, $message );
  }
}
add_action( 'comment_post', 'send_comment_by_email', 10, 2 );
?>
