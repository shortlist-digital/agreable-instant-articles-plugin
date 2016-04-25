<?php
namespace AgreableInstantArticlesPlugin\Services;

class ClientProvider {

  function __construct() {

    // String is needed for the comparison
    if (getenv('FB_INSTANT_ARTICLES_DEVELOPMENT_MODE') === "false") {
      $development_mode = false;
    } else {
      $development_mode = true;
    }

    $this->client = Client::create(
      get_option('instant_articles_app_id'),
      get_option('instant_articles_app_secret'),
      get_option('instant_articles_page_token'),
      get_option('instant_articles_page_id'),
      $development_mode
    );
  }

  public function get_client_instance() {
    return $this->client;
  }

}

