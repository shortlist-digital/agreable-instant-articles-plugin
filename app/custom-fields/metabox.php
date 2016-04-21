<?php

if( function_exists('acf_add_local_field_group') ):


  acf_add_local_field_group(array (
    'key' => 'article_should_publish_to_instant_articles_metabox',
    'title' => 'Instant Articles',
    'fields' => array (
      array (
        'key' => 'article_should_publish_to_instant_articles',
        'label' => 'Publish this post to Instant Articles',
        'name' => 'article_should_publish_to_instant_articles',
        'instructions' => 'Publish an Instant Articles compatible verion of this post for Facebook mobile users',
        'wrapper' => array (
          'width' => '49%',
        ),
        'type' => 'true_false',
        'default_value' => false
      ),
      array (
        'key' => 'instant_articles_is_preview',
        'label' => 'Publish to Instant Articles as Preview',
        'name' => 'instant_articles_is_preview',
        'instructions' => 'Publish to Instant Articles as a preview (in the Pages Manager App)',
        'wrapper' => array (
          'width' => '49%',
        ),
        'type' => 'true_false',
        'default_value' => true
      ),
    ),

    'location' => array (
      array (
        array (
          'param' => 'post_type',
          'operator' => '==',
          'value' => 'post',
        ),
      ),
    ),
    'menu_order' => 10,
    'position' => 'side',
  ));

endif;
