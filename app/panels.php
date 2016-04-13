<?php namespace AgreableInstantArticlesPlugin;

/** @var \Herbert\Framework\Panel $panel */

$panel->add([
    'type'   => 'panel',
    'as'     => 'instantArticlesPanel',
    'title'  => 'Instant Articles',
    'slug'   => 'instant-articles-index',
    'icon'   => 'dashicons-facebook',
    'uses'   => __NAMESPACE__ . '\Controllers\PanelController@index'
]);
