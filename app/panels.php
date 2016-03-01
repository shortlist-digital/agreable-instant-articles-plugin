<?php namespace AgreableInstantArticlesPlugin;

use AgreableInstantArticlesPlugin\Helper;
// $ns = Helper::get('agreable_namespace');
$ns = 'agreable_news';

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
      'key' => 'apple_news_channel_id',
      'label' => 'Instant Articles Channel ID',
      'name' => 'apple_news_channel_id',
      'type' => 'text',
      'instructions' => '',
      'required' => 0,
      'conditional_logic' => 0,
      'wrapper' => array (
        'width' => '',
        'class' => '',
        'id' => '',
      ),
      'default_value' => '',
      'placeholder' => '',
      'prepend' => '',
      'append' => '',
      'maxlength' => '',
      'readonly' => 0,
      'disabled' => 0,
    ),
    array (
      'key' => 'apple_new_api_key',
      'label' => 'Instant Articles API Key',
      'name' => 'apple_news_api_key',
      'type' => 'text',
      'instructions' => '',
      'required' => 0,
      'conditional_logic' => 0,
      'wrapper' => array (
        'width' => '',
        'class' => '',
        'id' => '',
      ),
      'default_value' => '',
      'placeholder' => '',
      'prepend' => '',
      'append' => '',
      'maxlength' => '',
      'readonly' => 0,
      'disabled' => 0,
    ),
    array (
      'key' => 'apple_news_api_secret',
      'label' => 'Instant Articles API Secret',
      'name' => 'apple_news_api_secret',
      'type' => 'password',
      'instructions' => '',
      'required' => 0,
      'conditional_logic' => 0,
      'wrapper' => array (
        'width' => '',
        'class' => '',
        'id' => '',
      ),
      'placeholder' => '',
      'prepend' => '',
      'append' => '',
      'readonly' => 0,
      'disabled' => 0,
    ),
    array (
      'key' => 'apple_news_api_channel',
      'label' => 'Instant Articles API Channel',
      'name' => 'apple_news_api_channel',
      'type' => 'text',
      'instructions' => '',
      'required' => 0,
      'conditional_logic' => 0,
      'wrapper' => array (
        'width' => '',
        'class' => '',
        'id' => '',
      ),
      'default_value' => '',
      'placeholder' => '',
      'prepend' => '',
      'append' => '',
      'maxlength' => '',
      'readonly' => 0,
      'disabled' => 0,
    ),
    array (
      'key' => 'apple_news_common_files',
      'label' => 'Common Files',
      'name' => 'common_files',
      'type' => 'repeater',
      'instructions' => 'Add files that should be included in every Instant Articles bundle, such as fonts, logos, and icons',
      'required' => 0,
      'conditional_logic' => 0,
      'wrapper' => array (
        'width' => '',
        'class' => '',
        'id' => '',
      ),
      'min' => '',
      'max' => '',
      'layout' => 'row',
      'button_label' => 'Add File',
      'sub_fields' => array (
        array (
          'key' => 'apple_news_common_files_file',
          'label' => 'File',
          'name' => 'file',
          'type' => 'file',
          'instructions' => '',
          'required' => 0,
          'conditional_logic' => 0,
          'wrapper' => array (
            'width' => '',
            'class' => '',
            'id' => '',
          ),
          'return_format' => 'array',
          'library' => 'all',
          'min_size' => '',
          'max_size' => '',
          'mime_types' => ''
        ),
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
