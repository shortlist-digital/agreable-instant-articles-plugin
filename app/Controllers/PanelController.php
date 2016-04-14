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
    return view('@AgreableInstantArticlesPlugin/admin/index.twig', [
      'fields' => $this->fields
    ]);
  }

  public function saveConfig(Http $http) {
    $http->get('submit');
    $input = $http->all();
    print_r($input);die;
  }

}

