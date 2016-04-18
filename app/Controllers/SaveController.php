<?php namespace AgreableInstantArticlesPlugin\Controllers;

use TimberPost;

use Facebook\InstantArticles\Elements\InstantArticle;
use Facebook\InstantArticles\Transformer\Transfomer;

class SaveController {

  function __construct(TimberPost $post) {
    $this->post = $post;
    $this->instant_article = InstantArticle::create();
    $permalink = get_permalink($this->post->id);
    $url = "$permalink/instant-articles";
    $this->build_article_object($url);
    print_r($url);die;
  }

  public function build_article_object($url) {
    try {
      $html = file_get_contents($url);
    } catch (\Exception $e) {
      echo $e->getMessage();
      die;
    }
    print_r($html);die;
  }

}
