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
    wp_schedule_single_event(time(), 'create_or_update', array($post_id));
  }

  public function create_or_update($post_id) {
    $check_status = !empty($post->article_should_publish_to_instant_articles);
    print_r($check_status);die;
    if (wp_is_post_revision( $post_id )) return;
    $post = new TimberPost($post_id);
    if ($post->post_status != 'trash') {
      if (!empty($post->article_should_publish_to_instant_articles)) {
        $post = new TimberPost($post_id);
        $save = new Save($post);
      }
      if (!empty($post->article_should_publish_to_instant_articles != true)) {
        $this->custom_delete($post_id);
      }
    }
    if ($post->post_status == 'trash') {
      $this->custom_delete($post_id);
    }
  }

  public function custom_delete($post_id) {
    $post = new TimberPost($post_id);
  }
}

(new Hooks)->init();

?>
