<?php
namespace AgreableInstantArticlesPlugin\Outlet\Facebook\Transforms;


class PullQuote  extends AbstractWidget{
  public function get($widget) {
	return ['text'=>$this->getData()]
    $text = $widget['text'];

    $html_as_string = Timber::compile(
      './template.twig',

    );

    return $html_as_string;
  }
}
