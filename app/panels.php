<?php namespace AgreableInstantArticlesPlugin;

use AgreableInstantArticlesPlugin\Helper;
// $ns = Helper::get('agreable_namespace');
$ns = 'agreable_instant_articles';

/*
 * Although we're in the Herbert panel file, we're not using any built in
 * panel functionality because you have to write you're own HTML forms and
 * logic. We're using ACF instead but seems sensible to leave ACF logic in
 * here (??).
 */


// Constructed using (lowercased and hyphenated) 'menu_title' from above.
$options_page_name = 'acf-options';

if( function_exists('register_field_group') ):

register_field_group(array (
  'key' => 'group_'.$ns.'_plugin',
  'title' => 'Instant Articles API Credentials',
  'fields' => array (
    array (
      'key' => 'instant_articles_app_id',
      'label' => 'Instant Articles App ID',
      'name' => 'instant_articles_app_id',
      'type' => 'text',
      'wrapper' => array (
        'width' => '33%',
      ),
    ),
    array (
      'key' => 'instant_articles_app_secret',
      'label' => 'Instant Articles App Secret',
      'name' => 'instant_articles_app_secret',
      'type' => 'password',
      'wrapper' => array (
        'width' => '33%',
      ),
    ),
    array (
      'key' => 'instant_articles_page_id',
      'label' => 'Instant Articles Page ID',
      'name' => 'instant_articles_page_id',
      'type' => 'text',
      'wrapper' => array (
        'width' => '33%',
      ),
    ),
  ),
  'location' => array (
    array (
      array (
        'param' => 'options_page',
        'operator' => '==',
        'value' => $options_page_name,
      ),
    ),
  ),
  'menu_order' => 10,
  'position' => 'normal',
  'style' => 'default',
  'label_placement' => 'top',
  'instruction_placement' => 'label',
  'hide_on_screen' => '',
));

endif;
