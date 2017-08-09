<?php
namespace AgreableInstantArticlesPlugin\Outlet\Facebook\Transforms;


class PullQuote  extends AbstractWidget{
  public function get($widget) {

    $text = $widget['text'];

    $html_as_string = Timber::compile(
      './template.twig',
      array(
        'text' => $text
      )
    );

    return $html_as_string;
  }
}
