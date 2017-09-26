<?php

namespace AgreableInstantArticlesPlugin\Generators;

use Timber;
use TimberSite;

class Footer implements GeneratorInterface
{
    public function get( $post ) {
        $brand = get_field( 'body_class', 'option' );

        $html_as_string = Timber::compile(
            __DIR__ . '/views/footer.twig',
            [
                'brand' => $brand,
                'instant_article' => true,
                'SEGMENT_WRITE_KEY' => getenv( 'SEGMENT_WRITE_KEY' ),
                'name' => get_bloginfo('name')
            ]
        );

        return $html_as_string;
    }
}
