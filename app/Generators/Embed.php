<?php

namespace AgreableInstantArticlesPlugin\Generators;

class Embed implements GeneratorInterface
{
    public function get( $widget ) {
        if ( ! isset( $widget['caption'] ) ) {
            return '';
        }
        $widget['caption'] = strip_tags( $widget['caption'] );

        return \Timber::compile( __DIR__ . '/views/embed.twig', $widget );
    }
}
