<?php

namespace AgreableInstantArticlesPlugin\Generators;

class Divider implements GeneratorInterface
{
    public function get( $widget = null ) {
        return "<hr/>";
    }
}
