<?php
namespace AgreableInstantArticlesPlugin\Services;

class ClientProvider {

  function __construct() {
    $this->client = Client::create(
      get_option('instant_articles_app_id'),
      get_option('instant_articles_app_secret'),
      get_option('instant_articles_page_token'),
      get_option('instant_articles_page_id'),
      true// development environment?
    );
  }

  public function get_client_instance() {
    return $this->client;
  }

}

