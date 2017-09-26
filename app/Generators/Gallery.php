<?php

namespace AgreableInstantArticlesPlugin\Generators;

use Timber;

class Gallery implements GeneratorInterface
{
    public function get( $widget ) {
      $images = $widget['gallery_items'];
      $html_as_string = Timber::compile(
        __DIR__ . '/views/gallery.twig',
        array(
          'images' => $images
        )
      );
      return $html_as_string;
    }
}
