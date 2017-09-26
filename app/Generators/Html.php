<?php

namespace AgreableInstantArticlesPlugin\Generators;

use Timber;
use Sunra\PhpSimple\HtmlDomParser;

class Html implements GeneratorInterface
{
    public function get($widget) {
        $embed = "<div>".$widget['html']."</div>";
        $embed_dom = HtmlDomParser::str_get_html($embed);

        // Tell playbuzz we're using instant articles
        $pb = $embed_dom->find('.pb_feed');
        if ( isset( $pb[0] ) ) {
            if ($pb[0]->{'data-game'}) {
                $pb[0]->{'data-origin'} = 'instant-article';
                $embed = $embed_dom->innertext;
            }
        }

        $html_as_string = Timber::compile(
            __DIR__ . '/views/html.twig',
            [ 'embed' => $embed ]
        );

        return $html_as_string;
    }
}
