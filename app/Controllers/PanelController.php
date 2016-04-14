<?php
namespace AgreableInstantArticlesPlugin\Controllers;

use Herbert\Framework\Http;
use Facebook\InstantArticles\Client\Client;
use Facebook\InstantArticles\Client\Helper;
use Facebook\Authentication\AccessToken;

class PanelController {

  public $fields = [
    ['name'=> 'instant_articles_app_id', 'label'=> 'Instant Articles App ID', 'description'=> 'The Facebook App ID for your Instant Articles'],
    ['name'=> 'instant_articles_app_secret', 'label'=> 'Instant Articles App Secret', 'description'=> 'The Facebook App secret for your Instant Articles', 'type' => 'password'],
    ['name'=> 'instant_articles_page_id', 'label'=> 'Instant Articles Page ID', 'description'=> 'The Facebook Page ID to post to Instant Articles']
  ];

  public function index() {
    foreach($this->fields as &$field) {
      $field['value'] = get_option($field['name']);
    }
    return view('@AgreableInstantArticlesPlugin/admin/index.twig', [
      'fields' => $this->fields,
      'pages' => $this->pages()
    ]);
  }

  public function pages() {

    $userAccessToken = new AccessToken("CAACzof7cFC0BAPKtFaJ5k5DdZCuwcqpKzNgZBIidaciBlzYsCswzksMXNP9OlthMZBotFU7vPZBYNZB8STIZAooE9TIcDqkZALOSK2DdvLszcpsANXZCvFrDce2kgaZA7smvsxhiiuJEec5rwjx0PVZCLqAgChGTgBZCiLkyU5QXVC1Ty3cTOt6ZA77tn9MQeSaidEcZD");

    $helper = Helper::create(
      get_option('instant_articles_app_id'),
      get_option('instant_articles_app_secret')
    );

    // Grab pages you are admin of and tokens
    return $helper->getPagesAndTokens($userAccessToken)->all();
  }

  public function saveConfig(Http $http) {
    echo "<pre>";print_r($http->all());die;
    foreach($this->fields as $field) {
      update_option($field['name'], $http->get($field['name']));
    }
    $redirect = $_SERVER['HTTP_REFERER'];
    header("location: $redirect");
  }

  public function clearConfig() {
    echo "Deleted:</br>";
    foreach($this->fields as $field) {
      delete_option($field['name']);
      echo $field['name']."</br>";
    }
  }

}

