<?php namespace AgreableInstantArticlesPlugin\Controllers;

use TimberPost;

use AgreableInstantArticlesPlugin\Services\Client;
use AgreableInstantArticlesPlugin\Services\ClientProvider;
use Facebook\InstantArticles\Elements\InstantArticle;
use Facebook\InstantArticles\Transformer\Transformer;

class SaveController {

  function __construct(TimberPost $post) {
    if (!property_exists($post, 'catfish_importer_url')) return;
    $this->post = $post;
    $take_live = !empty($post->instant_articles_is_preview);
    $permalink = get_permalink($this->post->id);
    $url = "$permalink/instant-articles?bypass";
    $instant_article = $this->build_article_object($url);
    $client = (new ClientProvider())->get_client_instance();
    try {
      $client->importArticle($instant_article, $take_live);
    } catch (Exception $e) {
      echo 'Could not import the article: '.$e->getMessage();
    }
  }

  public function build_article_object($url) {
    try {
      $html = file_get_contents($url, true);
    } catch (\Exception $e) {
      echo $e->getMessage();
      die;
    }
    return $html;

  }

}
