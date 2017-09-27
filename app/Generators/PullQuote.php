<?php

namespace AgreableInstantArticlesPlugin\Generators;

use Timber;
use TimberLoader;

class PullQuote implements GeneratorInterface
{
    public function get( $widget ) {
        $text = $widget['text'];
        $html_as_string = Timber::compile(
            __DIR__ . '/views/pull-quote.twig',
            [ 'text' => $text ],
            false, TimberLoader::CACHE_NONE
        );

        return $html_as_string;
    }
}
