<?php namespace AgreableInstantArticlesPlugin\Hooks;

use AgreableInstantArticlesPlugin\Helper;
use AgreableInstantArticlesPlugin\SaveController;
use AgreableInstantArticlesPlugin\UpdateController;
use AgreableInstantArticlesPlugin\DeleteController;
use AgreableInstantArticlesPlugin\Services\Compiler;
use \add_action;
use \TimberPost;

class AgreableInstantArticlesHookLoader {

  public function font_mime_types($mime_types) {
    $mime_types['otf'] = 'font/opentype';
    $mime_types['ttf'] = 'application/octet-stream';
    $mime_types['woff'] = 'application/x-font-woff';
    return $mime_types;
  }

  public function init() {
    add_action('delete_post', array($this, 'custom_delete'), 10, 1);
    add_action('apple_news_create_or_update', array($this, 'create_or_update'), 10, 1);
    add_action('save_post', array($this, 'defer_to_cron'), 13, 1);
    add_filter('upload_mimes', array($this, 'font_mime_types'), 1, 1);
  }

  function defer_to_cron($post_id) {
    wp_schedule_single_event(time(), 'apple_news_create_or_update', array($post_id));
  }

  public function create_or_update($post_id) {
    if (wp_is_post_revision( $post_id )) return;
    $post = new TimberPost($post_id);
    if (!in_array($post->post_type, array('post', 'feature', 'partnership'))) {return;}
    if ($post->status === 'publish') {
      $compiler = new Compiler($post);
      $compiler->run();
    }
  }

  public function custom_delete($post_id) {
    if (wp_is_post_revision( $post_id )) return;
    $post = new TimberPost($post_id);
    if (!in_array($post->post_type, array('post', 'feature', 'partnership'))) {return;}
    $post = new TimberPost($post_id);
    $compiler = new Compiler($post);
    $compiler->delete_post($post);
  }
}

(new AgreableInstantArticlesHookLoader())->init();

?>
