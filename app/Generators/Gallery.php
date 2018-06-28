<?php

namespace AgreableInstantArticlesPlugin\Generators;

class Gallery extends TwigRenderer implements GeneratorInterface
{
	public function get( $widget ) {
		return $this->renderer->render(
			'gallery.twig',
			[
				'images' => $widget['gallery_items']
			]
		);
	}
}
