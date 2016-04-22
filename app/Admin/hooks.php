<?php namespace AgreableInstantArticlesPlugin\Hooks;

use AgreableInstantArticlesPlugin\Controllers\SaveController as Save;
use AgreableInstantArticlesPlugin\Controllers\DeleteController as Delete;

use add_action;
use TimberPost;

class Hooks {

  function __construct() {
    //add_action('useful-hooks-create', array($this, 'create_or_update'), 13, 1);
    add_action('useful-hooks-update', array($this, 'create_or_update'), 13, 1);
    add_action('useful-hooks-delete', array($this, 'custom_delete'), 13, 1);
  }

  public function create_or_update($post_id) {
    if (wp_is_post_revision( $post_id )) return;
    $post = new TimberPost($post_id);
    if (property_exists($post, 'article_should_publish_to_instant_articles') && ($post->article_should_publish_to_instant_articles == 1)) {
      $post = new TimberPost($post_id);
      $save = new Save($post);
    } else if (property_exists($post, 'article_should_publish_to_instant_articles')) {
      $this->custom_delete($post_id);
    }
  }

  public function custom_delete($post_id) {
    $post = new TimberPost($post_id);
    new Delete($post);
  }
}

new Hooks();

?>
