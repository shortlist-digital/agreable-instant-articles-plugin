<?php

namespace AgreableInstantArticlesPlugin\Generators;

use Timber;
use TimberLoader;

class Image implements GeneratorInterface
{
    public function get( $widget ) {
        $image = $widget['image']['url'];
        $caption = strip_tags($widget['caption']);

        $html_as_string = Timber::compile(
            __DIR__ . '/views/image.twig',
            [
                'image' => $image,
                'caption' => $caption
            ],
            false, TimberLoader::CACHE_NONE
        );

        return $html_as_string;
    }
}
