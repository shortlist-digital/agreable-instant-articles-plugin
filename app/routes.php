<?php namespace AgreableInstantArticlesPlugin;

/** @var \Herbert\Framework\Router $router */

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
