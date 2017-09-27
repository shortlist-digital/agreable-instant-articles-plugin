<?php

namespace AgreableInstantArticlesPlugin\Generators;

use Timber;
use TimberLoader;

class Gallery implements GeneratorInterface
{
    public function get( $widget ) {
      $images = $widget['gallery_items'];
      $html_as_string = Timber::compile(
        __DIR__ . '/views/gallery.twig',
        array(
          'images' => $images
        ),
        false, TimberLoader::CACHE_NONE
      );
      return $html_as_string;
    }
}
