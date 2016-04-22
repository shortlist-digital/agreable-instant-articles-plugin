<?php namespace AgreableInstantArticlesPlugin\Controllers;

use Timberpost;

use AgreableInstantArticlesPlugin\Services\Client;
use AgreableInstantArticlesPlugin\Services\ClientProvider;

class DeleteController {

  function __construct(Timberpost $post) {
    $this->post = $post;
    if (property_exists($post, 'catfish_importer_url')) {
      $client = (new ClientProvider())->get_client_instance();
      $client->removeArticle($post->catfish_importer_url);
    }
  }


}
