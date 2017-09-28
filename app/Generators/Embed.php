<?php

namespace AgreableInstantArticlesPlugin\Generators;

use Timber;

class Embed implements GeneratorInterface
{
    public function get( $widget ) {
        if ( ! isset( $widget['caption'] ) ) {
            return '';
        }

        $widget['caption'] = strip_tags( $widget['caption'] );
        $html_as_string = Timber::compile( __DIR__ . '/views/embed.twig', $widget );

        return $html_as_string;
    }
}
