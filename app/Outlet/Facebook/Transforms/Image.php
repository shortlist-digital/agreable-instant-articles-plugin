<?php
namespace AgreableInstantArticlesPlugin\Outlet\Facebook\Transforms;


class Image extends AbstractWidget {

  public function get($widget) {

    $image = $widget['image']['url'];
    $caption = strip_tags($widget['caption']);

    $html_as_string = Timber::compile(
      './template.twig',
      array(
        'image' => $image,
        'caption' => $caption
      )
    );

    return $html_as_string;

  }
}
