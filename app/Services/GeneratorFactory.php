<?php

namespace AgreableInstantArticlesPlugin\Services;

use AgreableInstantArticlesPlugin\Generators\GeneratorInterface;

class GeneratorFactory
{
    public static function create( $widget_name ) : GeneratorInterface {
        $class = '';

        foreach( explode( '-', $widget_name ) as $widget_name_fragment ) {
            $class .= ucfirst( $widget_name_fragment );
        }
        $class = 'AgreableInstantArticlesPlugin\\Generators\\' . $class;

        return new $class;
    }
}
