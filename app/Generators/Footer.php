<?php

namespace AgreableInstantArticlesPlugin\Generators;

class Footer extends TwigRenderer implements GeneratorInterface
{
    public function get( $post = null ) {
        return $this->renderer->render(
            'footer.twig',
            [
                'name' => get_bloginfo('name')
            ]
        );
    }
}
