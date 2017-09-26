<?php

namespace AgreableInstantArticlesPlugin\Generators;

use AgreableInstantArticlesPlugin\Services\GeneratorFactory;

class Listicle implements GeneratorInterface
{
    public function get( $widgets ) {
        if ( ! isset( $widgets['item'] ) && ! is_array( $widgets['item'] ) ) {
            return '';
        }

        $html_as_string = '';
        foreach( $widgets['item'] as $widget ) {
            if ( ! isset( $widget['media_type'] ) ) {
                continue;
            }

            $class = GeneratorFactory::create( $widget['media_type'] );
            $html_as_string .= $class->get( $widget );
        }

        return $html_as_string;
    }
}
