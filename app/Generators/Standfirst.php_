<?php

namespace AgreableInstantArticlesPlugin\Generators;

use Timber;
use TimberLoader;
use TimberSite;
use TimberPost;
use TimberImage;

class Standfirst implements GeneratorInterface
{
    public function get( $post ) {
      $standFirst = $post->standfirst;
      $html_as_string = Timber::compile(
        __DIR__ . '/views/standfirst.twig',
            [ 'standfirst' => $standFirst ],
            false, TimberLoader::CACHE_NONE
        );

      return $html_as_string;
    }

}
