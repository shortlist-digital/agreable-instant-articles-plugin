<?php namespace AgreableInstantArticlesPlugin;

/** @var \Herbert\Framework\Router $router */

$router->get([
  'as'   => 'testView',
  'uri'  => '/instant-articles/test',
  'uses' => __NAMESPACE__ . '\Controllers\TestController@index'
]);

$router->post([
  'as'   => 'save-config',
  'uri'  => '/instant-articles/save-config',
  'uses' => __NAMESPACE__ . '\Controllers\PanelController@saveConfig'
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
