<?php
namespace AgreableInstantArticlesPlugin\Controllers;

use Herbert\Framework\Http;
use Facebook\InstantArticles\Client\Client;
use Facebook\InstantArticles\Client\Helper;
use Facebook\Authentication\AccessToken;

class PanelController {

  public $fields = [
    ['name'=> 'instant_articles_app_user_access_token', 'label'=> 'User Access Token', 'description'=> 'A user access token for someone with access to the relevant Facebook Page.</br><a href="https://developers.facebook.com/tools/accesstoken" target="_blank"/">Generate one here</a>. (Click "debug", and extend the token)', 'type' => 'password'],
    ['name'=> 'instant_articles_app_id', 'label'=> 'App ID', 'description'=> 'The Facebook App ID for your Instant Articles'],
    ['name'=> 'instant_articles_app_secret', 'label'=> 'App Secret', 'description'=> 'The Facebook App secret for your Instant Articles', 'type' => 'password'],
    ['name'=> 'instant_articles_page_id', 'label'=> 'Page ID', 'description'=> 'The Facebook Page ID to post to Instant Articles', 'disabled' => true]
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

    if (get_option('instant_articles_app_user_access_token')) {
      $userAccessToken = new AccessToken(get_option('instant_articles_app_user_access_token'));

      $helper = Helper::create(
        get_option('instant_articles_app_id'),
        get_option('instant_articles_app_secret')
      );

      // Grab pages you are admin of and tokens
      return $helper->getPagesAndTokens($userAccessToken)->all();
    } else {
      return false;
    }
  }

  public function saveConfig(Http $http) {
    $do_next_fields = false;
    if (get_option('instant_articles_app_id')) {
      $do_next_fields = true;
    }
    foreach($this->fields as $field) {
      update_option($field['name'], $http->get($field['name']));
    }
    if ($do_next_fields) {
      $this->decode_facebook_page_data($http->get('instant_articles_page'));
    }
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
    echo delete_option('instant_articles_page_name');
    echo delete_option('instant_articles_page_token');
  }

}

