<?php

namespace AgreableInstantArticlesPlugin\Generators;

class PullQuote extends TwigRenderer implements GeneratorInterface
{
	public function get( $widget ) {
		return $this->renderer->render(
			'pull-quote.twig',
			[ 'text' => $widget['text'] ]
		);
	}
}
