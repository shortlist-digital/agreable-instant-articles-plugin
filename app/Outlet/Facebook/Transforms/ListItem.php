<?php
namespace AgreableInstantArticlesPlugin\Outlet\Facebook\Transforms;


class ListItem extends AbstractWidget {
  public function get($widget) {

    $heading = strip_tags($widget['heading']);
    $heading = html_entity_decode($heading);

    $image = $widget['image']['url'];

    $caption = strip_tags($widget['copy']);
    $caption = html_entity_decode($caption);

    $html_as_string = Timber::compile(
      './template.twig',
      array(
        'heading' => $heading,
        'image' => $image,
        'caption' => $caption
      )
    );

    return $html_as_string;
  }
}

