<?php

namespace AgreableInstantArticlesPlugin\Generators;

use Timber;

class PullQuote implements GeneratorInterface
{
    public function get( $widget ) {
        $text = $widget['text'];
        $html_as_string = Timber::compile(
            __DIR__ . '/views/pull-quote.twig',
            [ 'text' => $text ]
        );

        return $html_as_string;
    }
}
