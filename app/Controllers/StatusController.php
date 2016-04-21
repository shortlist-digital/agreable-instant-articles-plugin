<?php
namespace AgreableInstantArticlesPlugin\Controllers;

use AgreableInstantArticlesPlugin\Services\ClientProvider;
use TimberPost;

class StatusController {

  function __construct() {
    $this->client = (new ClientProvider())->get_client_instance();
  }

  public function index($category_slug, $post_slug) {
    $post = get_page_by_path($post_slug, OBJECT,'post');
    $post = new TimberPost($post->ID);
    $canonical_url = $post->catfish_importer_url;
    try {
      $article_id = $this->client->getArticleIDFromCanonicalURL($canonical_url);
    } catch(\Exception $e) {
      print_r($e);die;
    }
    print_r($article_id);die;
  }

}
