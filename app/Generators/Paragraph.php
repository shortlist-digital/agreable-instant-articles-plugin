<?php

namespace AgreableInstantArticlesPlugin\Generators;

use Timber;
use TimberLoader;

class Paragraph implements GeneratorInterface
{
    public function get( $widget ) {
        $html = $widget['paragraph'];

        if ( preg_match( '/data-firebase-id/', $html ) ) {
            return;
        } elseif ( preg_match_all( '/twitter-tweet|data-instgrm-version/', $html ) ) {
            $file = 'paragraph-social';
        } else {
            $file = 'paragraph-template';
        }

        $html_as_string = Timber::compile(
            __DIR__ . '/views/' . $file . '.twig',
            [ 'paragraph' => $html ],
            false, TimberLoader::CACHE_NONE
        );

        return $html_as_string;
    }
}
