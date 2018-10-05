<?php

namespace AgreableInstantArticlesPlugin\Generators;

class Image extends TwigRenderer implements GeneratorInterface
{
	public function get( $widget ) {
		$image = $widget['image']['url'];
		$caption = strip_tags($widget['caption']);

		return $this->renderer->render(
			'image.twig',
			[
				'image' => $image,
				'caption' => $caption
			]
		);
	}
}
