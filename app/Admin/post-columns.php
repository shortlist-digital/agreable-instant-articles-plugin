<?php

function add_apple_news_status_column($post_type) {
  \Jigsaw::add_column($post_type, 'Instant Articles Status', function($pid) {
    $apple_id = get_post_meta($pid, 'apple_news_api_id');
    if ($apple_id) {
      $last_modified = get_post_meta($pid, 'apple_news_api_modified_at')[0];
      $post_created = get_post_meta($pid, 'apple_news_api_created_at')[0];
      $time_ago = new \TimeAgo();
      $last_update = $time_ago->inWords($last_modified);
      $created = $time_ago->inWords($post_created);
      echo "<strong>Status:</strong></br>";
      echo "<span style='color:green;'>Synced</span></br>";
      echo "<hr>";
      echo "<strong>Created:</strong></br>";
      echo "<span title='$post_created'> $created</span></br>";
      echo "<hr>";
      echo "<strong>Last Modified:</strong></br>";
      echo "<span title='$last_modified'>$last_update</span></br>";
    } else {
      echo "<span>Not synced</span>";
    }
  }, 5);
}

\add_action('admin_init', function() {
  add_apple_news_status_column('post');
  add_apple_news_status_column('features-post');
});
