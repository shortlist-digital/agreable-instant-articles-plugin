<?php namespace AgreableInstantArticlesPlugin\Controllers;

use Timberpost;

use AgreableInstantArticlesPlugin\Services\Client;
use AgreableInstantArticlesPlugin\Services\ClientProvider;

class DeleteController {

  function __construct(Timberpost $post) {
    $this->post = $post;
    $client = (new ClientProvider())->get_client_instance();
    $client->removeArticle($post->catfish_importer_url);
  }


}
