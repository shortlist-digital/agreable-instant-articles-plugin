<?php
namespace AgreableInstantArticlesPlugin\Controllers;

use Herbert\Framework\Http;

class PanelController {

  public $fields = [
    ['name'=> 'instant_articles_app_id', 'label'=> 'Instant Articles App ID', 'description'=> 'The Facebook App ID for your Instant Articles'],
    ['name'=> 'instant_articles_app_secret', 'label'=> 'Instant Articles App Secret', 'description'=> 'The Facebook App secret for your Instant Articles'],
    ['name'=> 'instant_articles_page_id', 'label'=> 'Instant Articles Page ID', 'description'=> 'The Facebook Page ID to post to Instant Articles']
  ];

  public function index() {
    foreach($this->fields as &$field) {
      $field['value'] = get_option($field['name']);
    }
    return view('@AgreableInstantArticlesPlugin/admin/index.twig', [
      'fields' => $this->fields
    ]);
  }

  public function saveConfig(Http $http) {
    foreach($this->fields as $field) {
      update_option($field['name'], $http->get($field['name']));
    }
    $redirect = $_SERVER['HTTP_REFERER'];
    header("location: $redirect");
  }

}

