<?php namespace AgreableInstantArticlesPlugin;

/** @var \Herbert\Framework\Router $router */

$router->get([
  'as'   => 'testView',
  'uri'  => '/instant-articles/test',
  'uses' => __NAMESPACE__ . '\Controllers\PanelController@test'
]);

$router->post([
  'as'   => 'saveConfig',
  'uri'  => '/instant-articles/save-config',
  'uses' => __NAMESPACE__ . '\Controllers\PanelController@saveConfig'
]);

$router->post([
  'as'   => 'saveConfig',
  'uri'  => '/instant-articles/save-config',
  'uses' => __NAMESPACE__ . '\Controllers\PanelController@saveConfig'
]);

$router->get([
  'as'   => 'clearConfig',
  'uri'  => '/instant-articles/clear-config',
  'uses' => __NAMESPACE__ . '\Controllers\PanelController@clearConfig'
]);

$router->get([
  'as'   => 'postView',
  'uri'  => '/{category_slug}/{post_slug}/instant-articles',
  'uses' => __NAMESPACE__ . '\Controllers\PostController@view'
]);

$router->get([
  'as'   => 'postView',
  'uri'  => '/{category_slug}/{sub_category_slug}/{post_slug}/instant-articles',
  'uses' => __NAMESPACE__ . '\Controllers\PostController@view'
]);

$router->get([
  'as'   => 'statusView',
  'uri'  => '/{category_slug}/{post_slug}/instant-articles/status',
  'uses' => __NAMESPACE__ . '\Controllers\StatusController@index'
]);

$router->get([
  'as'   => 'statusView',
  'uri'  => '/{category_slug}/{sub_category_slug}/{post_slug}/instant-articles/status',
  'uses' => __NAMESPACE__ . '\Controllers\StatusController@index'
]);
