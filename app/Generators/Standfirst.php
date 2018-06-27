<?php

namespace AgreableInstantArticlesPlugin\Generators;

class Standfirst extends TwigRenderer implements GeneratorInterface
{
	public function get( $post ) {
		$standFirst = get_field( 'standfirst', $post->ID ) ?: '';

		return $this->renderer->render(
			'standfirst.twig',
			[ 'standfirst' => $standFirst ]
		);
	}

}
