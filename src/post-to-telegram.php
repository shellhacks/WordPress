<?php

/**
 * by ShellHacks
 * WordPress script: post-to-telegram
 * Copyright (c) 2011-2024 www.ShellHacks.com <mail@shellhacks.com>
 *
 * Send new WordPress posts to Telegram
 * Documentation: https://www.shellhacks.com/wordpress-auto-post-to-telegram-channel-no-plugin
 * Source: https://github.com/shellhacks/WordPress/src/post-to-telegram.php
 *
 * Tested on WordPress, version=6.4.2
 * Version: 1.0.0
 */

  function post_to_telegram( $new_status, $old_status, $post ) {
  if( $new_status == 'publish' &&
      $old_status != 'publish' &&
      $post->post_type == 'post') {
  $apiToken = "5082654068:AAF7quCLZ4xuTq2FBdo3POssdJsM_FRHwTs";
  $post_url = get_permalink($post->ID);
  $post_title = get_the_title($post->ID);
  // HTML tags supported by Telegram (https://core.telegram.org/bots/api#html-style)
  $arr = array( 'a' => array(
                  'href' => array()
                ),
                'b' => array(),
                'code' => array(),
                'del' => array(),
                'em' => array(),
                'i' => array(),
                'ins' => array(),
                'pre' => array(),
                's' => array(),
                'span' => array(),
                'strike' => array(),
                'strong' => array(),
                'tg-spoiler' => array(),
                'u' => array()
              );
  // Get the post content but keep the supported HTML tags only
  $post_content = wp_kses(get_the_content($more_link_text = "
\n&#128214; Continue Reading", false, $post->ID), $arr);
  $message = sprintf( "&#127760; <a href=\"%s\">%s</a>\n\n%s", $post_url,
                                                               $post_title,
                                                               $post_content );
  $data = [
      'chat_id' => '-1002623654901',
      'text' => $message,
      'parse_mode' => 'html'
  ];
  $response = file_get_contents("https://api.telegram.org/bot$apiToken/sendMessage?" .
                                 http_build_query($data));
  }
  }
  add_action( 'transition_post_status', 'post_to_telegram', 10, 3 );
?>