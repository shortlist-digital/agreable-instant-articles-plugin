<?php namespace AgreableInstantArticlesPlugin;

/** @var \Herbert\Framework\Router $router */
/**
 * This does not work currently.
 * $router->get([
 * 'as'   => 'postView',
 * 'uri'  => '/{category_slug}/{post_slug}/instant-articles',
 * 'uses' => __NAMESPACE__ . '\Controllers\PostController@view'
 * ]);
 *
 * $router->get([
 * 'as'   => 'postView',
 * 'uri'  => '/{category_slug}/{sub_category_slug}/{post_slug}/{post_id}/instant-articles',
 * 'uses' => __NAMESPACE__ . '\Controllers\PostController@view'
 * ]);
 *
 * $router->get([
 * 'as'   => 'statusView',
 * 'uri'  => '/{category_slug}/{post_slug}/instant-articles/status',
 * 'uses' => __NAMESPACE__ . '\Controllers\StatusController@index'
 * ]);
 *
 * $router->get([
 * 'as'   => 'statusView',
 * 'uri'  => '/{category_slug}/{sub_category_slug}/{post_slug}/instant-articles/status',
 * 'uses' => __NAMESPACE__ . '\Controllers\StatusController@index'
 * ]);
 **/