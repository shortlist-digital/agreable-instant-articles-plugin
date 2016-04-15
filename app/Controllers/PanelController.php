<?php
namespace AgreableInstantArticlesPlugin\Controllers;

use Herbert\Framework\Http;
use Facebook\InstantArticles\Client\Client;
use Facebook\InstantArticles\Client\Helper;
use Facebook\Authentication\AccessToken;

class PanelController {

  public $fields = [
    ['name'=> 'instant_articles_app_user_access_token', 'label'=> 'Instant Articles User Access Token', 'description'=> 'A user access token for someone with access to the relevant Facebook Page.</br><a href="https://developers.facebook.com/tools/accesstoken target="_blank"/">Generate one here</a>. Click "debug", and extend the token', 'type' => 'password'],
    ['name'=> 'instant_articles_app_id', 'label'=> 'Instant Articles App ID', 'description'=> 'The Facebook App ID for your Instant Articles'],
    ['name'=> 'instant_articles_app_secret', 'label'=> 'Instant Articles App Secret', 'description'=> 'The Facebook App secret for your Instant Articles', 'type' => 'password'],
    ['name'=> 'instant_articles_page_id', 'label'=> 'Instant Articles Page ID', 'description'=> 'The Facebook Page ID to post to Instant Articles', 'disabled' => true]
  ];

  public function index() {
    foreach($this->fields as &$field) {
      $field['value'] = get_option($field['name']);
    }
    return view('@AgreableInstantArticlesPlugin/admin/index.twig', [
      'fields' => $this->fields,
      'pages' => $this->pages(),
      'selected' => get_option('instant_articles_page_name')
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
    foreach($this->fields as $field) {
      update_option($field['name'], $http->get($field['name']));
    }
    $this->decode_facebook_page_data($http->get('instant_articles_page'));
    $redirect = $_SERVER['HTTP_REFERER'];
    header("location: $redirect");
  }

  public function decode_facebook_page_data($data_string) {
    $page_data = json_decode($data_string, true);
    foreach($page_data as $key => $value) {
      update_option("instant_articles_page_$key", $value);
    }
  }

  public function clearConfig() {
    echo "Deleted:</br>";
    foreach($this->fields as $field) {
      delete_option($field['name']);
      echo $field['name']."</br>";
    }
  }

}

