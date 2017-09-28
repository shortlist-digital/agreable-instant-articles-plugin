<?php

namespace AgreableInstantArticlesPlugin\Generators;

use Timber;
use TimberLoader;

class Embed implements GeneratorInterface
{
    public function get( $widget ) {
<<<<<<< HEAD
        $widget['caption'] = strip_tags($widget['caption']);
        $html_as_string = Timber::compile( __DIR__ . '/views/embed.twig', $widget, false, TimberLoader::CACHE_NONE);
=======
        if ( ! isset( $widget['caption'] ) ) {
            return '';
        }

        $widget['caption'] = strip_tags( $widget['caption'] );
        $html_as_string = Timber::compile( __DIR__ . '/views/embed.twig', $widget );
>>>>>>> develop

        return $html_as_string;
    }
}
