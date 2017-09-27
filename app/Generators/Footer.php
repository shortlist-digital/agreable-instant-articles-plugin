<?php

namespace AgreableInstantArticlesPlugin\Generators;

use Timber;
use TimberSite;

class Footer implements GeneratorInterface
{
    public function get( $post ) {

        $html_as_string = Timber::compile(
            __DIR__ . '/views/footer.twig',
            [
                'name' => get_bloginfo('name')
            ]
        );

        return $html_as_string;
    }
}
