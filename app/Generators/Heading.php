<?php

namespace AgreableInstantArticlesPlugin\Generators;

class Heading implements GeneratorInterface
{
    public function get( $widget ) {
        $text = strip_tags($widget['text']);
        $text = html_entity_decode($text);
        $html_as_string = \Timber::compile(
            __DIR__ . '/views/heading.twig',
            array(
                'text' => $text
            ),
            false, \TimberLoader::CACHE_NONE
        );
        return $html_as_string;
    }
}
