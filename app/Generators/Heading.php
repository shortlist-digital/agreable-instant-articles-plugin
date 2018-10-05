<?php

namespace AgreableInstantArticlesPlugin\Generators;

class Heading extends TwigRenderer implements GeneratorInterface
{
    public function get( $widget ) {
        $text = strip_tags($widget['text']);
        $text = html_entity_decode($text);

        return $this->renderer->render(
            'heading.twig',
            array(
                'text' => $text
            )
        );
    }
}
