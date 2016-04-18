<?php namespace AgreableInstantArticlesPlugin\Hooks;

use AgreableInstantArticlesPlugin\Controllers\SaveController as Save;

use add_action;
use TimberPost;

class Hooks {

  public function init() {
    add_action('delete_post', array($this, 'custom_delete'), 10, 1);
    //add_action('apple_news_create_or_update', array($this, 'create_or_update'), 10, 1);
    //add_action('save_post', array($this, 'defer_to_cron'), 13, 1);
    add_action('save_post', array($this, 'create_or_update'), 13, 1);
  }

  function defer_to_cron($post_id) {
    wp_schedule_single_event(time(), 'apple_news_create_or_update', array($post_id));
  }

  public function create_or_update($post_id) {
    if (wp_is_post_revision( $post_id )) return;
    $post = new TimberPost($post_id);
    if (!empty($post->article_should_publish_to_instant_articles)) {
      $post = new TimberPost($post_id);
      $save = new Save($post);
    }
  }

  public function custom_delete($post_id) {
    $post = new TimberPost($post_id);
  }
}

(new Hooks)->init();

?>
