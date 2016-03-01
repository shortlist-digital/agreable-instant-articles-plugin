<?php namespace AgreableInstantArticlesPlugin\Services;

use TimberPost;

class BundleManifest {

  function __construct(TimberPost $post) {
    $article_json = file_get_contents($post->guid."/instant-articles?bypass");
    $this->article_json = $this->update_asset_locations_to_bundle($article_json);
  }

  private function update_url_to_bundle($url) {
    return "bundle://".pathinfo($url, PATHINFO_BASENAME);
  }

  private function check_node_for_asset(&$value, $key) {
    $check_1 = $this->begins_with_http($value);
    $check_2 = $this->has_asset_file_type($value);
    if ($check_1 && $check_2) {
      return $value = $this->update_url_to_bundle($value);
    }
    return $value;
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

  private function update_asset_locations_to_bundle($json) {
    $article = json_decode($json, true);
    array_walk_recursive($article, array($this, 'check_node_for_asset'));
    return json_encode($article, JSON_PRETTY_PRINT);
  }
  public function json() {
    return $this->article_json;
  }

}
