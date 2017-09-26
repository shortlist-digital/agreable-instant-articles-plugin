<?php

namespace AgreableInstantArticlesPlugin\Generators;

use Timber;

class Embed implements GeneratorInterface
{
    public function get( $widget ) {
        $widget['caption'] = strip_tags($widget['caption']);
        $html_as_string = Timber::compile( __DIR__ . '/views/embed.twig', $widget );

        return $html_as_string;
    }
}
