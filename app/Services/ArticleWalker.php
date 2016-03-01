<?php namespace AgreableInstantArticlesPlugin\Services;

use TimberPost;

class ArticleWalker {

  function __construct(TimberPost $post) {
    $this->post = $post;
    $this->json = file_get_contents($post->guid."/instant-articles?bypass");
    $this->article_array = json_decode($this->json, true);

  }

  public function check_if_asset($value) {
    $check_1 = $this->begins_with_http($value);
    $check_2 = $this->has_asset_file_type($value);
    return ($check_1 && $check_2);
  }

  public function get_array_of_asset_urls() {
    $a = $this->article_array;
    $assets = array();
    array_walk_recursive($a, function($value, $key) use (&$assets) {
      if ($this->check_if_asset($value)) {
        array_push($assets, $value);
      };
    });
    return $assets;
  }


  private function has_asset_file_type($string) {
    $allowed_types = array(
      'jpg',
      'png',
      'gif',
      'ttf',
      'otf',
      'woff'
    );
    $ext = pathinfo($string, PATHINFO_EXTENSION);
    return in_array($ext, $allowed_types);
  }

  private function begins_with_http($string) {
    return substr($string, 0, 4) === 'http';
  }


}

