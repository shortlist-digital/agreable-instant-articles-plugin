<?php namespace AgreableInstantArticlesPlugin\Services;

use AgreableInstantArticlesPlugin\Services\BundleManifest;
use AgreableInstantArticlesPlugin\Services\ArticleWalker;
use TimberPost;

class BundleFiles {
  function __construct(TimberPost $post) {
    $this->post = $post;
    $upload_dir = wp_upload_dir()['basedir'];
    $this->tmp_dir = "$upload_dir/instant-articles-tmp";

    $bundle_manifest = new BundleManifest($post);
    $this->article_json = $bundle_manifest->json();

    $article_walker = new ArticleWalker($post);
    $this->asset_urls = array_merge($article_walker->get_array_of_asset_urls(), $this->get_common_bundle_array());

    $unmodified_json = file_get_contents($post->guid."/instant-articles?bypass");
    $this->article = json_decode($unmodified_json, true);
  }

  private function get_common_bundle_array() {
    $common_files = get_field('apple_news_common_files', 'option');
    $urls = array();
    if ($common_files) {
      foreach($common_files as $file) {
        array_push($urls, $file['file']['url']);
      }
    }
    return array_filter($urls);
  }

  public function article_json_string() {
    return $this->article_json;
  }

  private function ensure_apple_news_tmp() {
    if (!file_exists($this->tmp_dir)) {
      mkdir($this->tmp_dir, 0777, true);
    }
  }

  public function bundle() {
    $this->ensure_apple_news_tmp();
    $this->bundle_path = $this->create_bundle_tmp_folder();
    $this->store_asset_files();
    $this->store_article_json_file();
  }

  public function bundle_path() {
    return $this->bundle_path;
  }

  private function store_article_json_file() {
    $path = $this->bundle_path."/article.json";
    return file_put_contents($path, $this->article_json);

  }

  private function store_asset_files() {
    foreach($this->asset_urls as $url) {
      $this->store_asset($url);
    }
  }

  private function store_asset($url) {
    $asset = file_get_contents($url);
    $path = $this->bundle_path."/".pathinfo($url, PATHINFO_BASENAME);
    return file_put_contents($path, $asset);
  }

  private function create_bundle_tmp_folder() {
    $folder_name = md5($this->post->guid);
    $bundle_dir = "$this->tmp_dir/$folder_name";
    if (!file_exists($bundle_dir)) {
      mkdir($bundle_dir, 0777, true);
    }
    return $bundle_dir;

  }
}
