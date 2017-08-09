<?php
namespace AgreableInstantArticlesPlugin\Outlet\Facebook\Transforms;


class Paragraph extends AbstractWidget {
  public function get($widget) {

    $html = $widget['paragraph'];

    if (preg_match('/data-firebase-id/',$html)) {
      return;
    } elseif (preg_match_all('/twitter-tweet|data-instgrm-version/',$html)) {
      $file = 'social';
    } else {
      $file = 'template';
    }

    $html_as_string = Timber::compile(
      './'.$file.'.twig',
      array(
        'paragraph' => $html
      )
    );

    return $html_as_string;
  }
}
