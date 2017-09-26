<?php

namespace AgreableInstantArticlesPlugin\Generators;

use Timber;
use TimberSite;
use TimberPost;
use TimberImage;

class StandFirst implements GeneratorInterface
{
    public function get( $post ) {
      $standFirst = $post->standfirst;
      $html_as_string = Timber::compile(
        __DIR__ . '/views/standfirst.twig',
            [ 'standfirst' => $standFirst ]
        );
    }

}
