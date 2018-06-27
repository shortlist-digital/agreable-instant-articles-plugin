<?php

namespace AgreableInstantArticlesPlugin\Generators;

class TwigRenderer
{
	protected $renderer;

	public function __construct() {
		$this->renderer = new \Twig_Environment(
			new \Twig_Loader_Filesystem( __DIR__ . '/views' )
		);
	}
}
