<?php

namespace AgreableInstantArticlesPlugin\Generators;

use Timber;

class Divider implements GeneratorInterface
{
    public function get( $widget ) {
        return "<hr/>";
    }
}
