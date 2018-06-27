<?php

namespace AgreableInstantArticlesPlugin\Generators;

class Embed extends TwigRenderer implements GeneratorInterface
{
    public function get( $widget ) {
        if ( ! isset( $widget['caption'] ) ) {
            return '';
        }
        $widget['caption'] = strip_tags( $widget['caption'] );

        return $this->renderer->render( 'embed.twig', $widget );
    }
}
