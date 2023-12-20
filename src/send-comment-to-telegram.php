 <?php

/**
 * by ShellHacks
 * WordPress script: send-comment-to-telegram
 * Copyright (c) 2011-2024 www.ShellHacks.com <mail@shellhacks.com>
 *
 * Send new WordPress comments to Telegram 
 * Documentation: https://www.shellhacks.com/wordpress-comment-hook-trigger-action-example/
 * Source: https://github.com/shellhacks/WordPress/blob/main/src/send-comment-to-telegram.php
 *
 * Tested on WordPress, version=6.4.2
 * Version: 1.0.0
 */

function send_comment_to_telegram( $comment_id, $comment_approved ) {
  if ( ! $comment_approved ) {
    $apiToken = "0123456789:ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghi";
    $comment = get_comment( $comment_id );
    $comment_parent_id = $comment->comment_parent;
    if ( $comment_parent_id != 0) {
      $comment_parent = get_comment( $comment_parent_id );
      $comment_parent_author = $comment_parent->comment_author;
    };
    $comment_author = $comment->comment_author;
    $comment_content = $comment->comment_content;
    $post_url = get_permalink( $comment->comment_post_ID );
    $post_title = get_the_title( $comment->comment_post_ID );
    if ( $comment_parent_id != 0) {
      $message_header = sprintf( "&#8617;&#65039; by <em>%s</em> to <a href=\"%s/#comment-%s\"><em>%s</em></a>:", $comment_author,
                                                                                                                  $post_url,
                                                                                                                  $comment_parent_id,
                                                                                                                  $comment_parent_author);
    } else {
      $message_header = sprintf( "&#128172; by <em>%s</em>:", $comment_author);
    };
    $message = sprintf( "%s\n<blockquote>%s</blockquote>\n&#127760; <a href=\"%s\">%s</a>", $message_header,
                                                                                            $comment_content,
                                                                                            $post_url,
                                                                                            $post_title );
    $data = [
      'chat_id' => '012345678',
      'text' => $message,
      'parse_mode' => 'html',
      'disable_web_page_preview' => 'True'
    ];
    $response = file_get_contents("https://api.telegram.org/bot$apiToken/sendMessage?" . http_build_query($data) );
  }
}
add_action( 'comment_post', 'send_comment_to_telegram', 10, 2 );
?>
