<?php namespace AgreableInstantArticlesPlugin\Services;

use AgreableInstantArticlesPlugin\Services\BundleFiles;
use AgreableInstantArticlesPlugin\Services\Request;
use AgreableInstantArticlesPlugin\Services\Credentials;
use AgreableInstantArticlesPlugin\Controllers\InstantArticlesResponseHandler;

use TimberPost;

class Compiler  {
  function __construct(TimberPost $post) {
    $this->post = $post;
    $this->bundle_files = new BundleFiles($post);
    $this->bundle_files->bundle();
    $this->bundle_path = $this->bundle_files->bundle_path();
    $this->credentials = $this->set_credentials();
    $this->request = new Request($this->credentials);
    $this->apple_id = get_post_meta($post->id, 'apple_news_api_id', true);
  }

  function run() {
    if (empty($this->apple_id)) {
      return $this->create_post();
    } else {
      return $this->update_post();
    }
  }

  function update_post() {
    $revision = get_post_meta($this->post->id, 'apple_news_api_revision', true);
    $url = $this->build_update_endpoint_url($this->apple_id);
    $paths = $this->get_attachment_paths();
    $article_json = $this->bundle_files->article_json_string();
    $meta = array(
      'data' => array(
        'revision' => $revision
      )
    );
    $response = $this->request->post($url, $article_json, $paths, $meta);
    $anrh = new InstantArticlesResponseHandler($response, $this->post);
    return $anrh->handle();
  }

  function delete_post() {
    $url = $this->build_delete_endpoint_url($this->apple_id);
    $response = $this->request->delete($url);
    $anrh = new InstantArticlesResponseHandler($response, $this->post);
    return $anrh->handle_delete();

  }

  function create_post() {
    $url = $this->build_create_endpoint_url();
    $paths = $this->get_attachment_paths();
    $article_json = $this->bundle_files->article_json_string();
    $response = $this->request->post($url, $article_json, $paths);
    $anrh = new InstantArticlesResponseHandler($response, $this->post);
    return $anrh->handle();
  }

  public function set_credentials() {
    $key = get_field('apple_news_api_key', 'option');
    $secret = get_field('apple_news_api_secret', 'option');
    return new Credentials($key, $secret);
  }

  function perform_request($url) {
    $paths = $this->get_attachment_paths();
    $article_json = $this->bundle_files->article_json_string();
    return $this->request->post($url, $article_json, $paths);
  }

  function build_delete_endpoint_url($article_id) {
    $base = "https://news-api.apple.com";
    return "$base/articles/$article_id";
  }

  function build_create_endpoint_url() {
    $base = "https://news-api.apple.com";
    $channel_id = get_field('apple_news_channel_id', 'option');
    return "$base/channels/$channel_id/articles";
  }

  function build_update_endpoint_url($article_id) {
    $base = "https://news-api.apple.com";
    return "$base/articles/$article_id";

  }

  function get_attachment_paths() {
    $attachment_paths = array();
    if ($handle = opendir($this->bundle_path  )) {
      while (false !== ($entry = readdir($handle))) {
        if ($entry != "." && $entry != ".." && $entry != "article.json") {
          array_push($attachment_paths, "$this->bundle_path/$entry");
        }
      }
      closedir($handle);
    }
    return $attachment_paths;
  }

}
