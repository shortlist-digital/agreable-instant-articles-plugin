<?php

namespace AgreableInstantArticlesPlugin\Generators;

class Paragraph extends TwigRenderer implements GeneratorInterface
{
	public function get( $widget ) {
		$html = $widget['paragraph'];

		if ( preg_match( '/data-firebase-id/', $html ) ) {
			return;
		} elseif ( preg_match_all( '/twitter-tweet|data-instgrm-version/', $html ) ) {
			$file = 'paragraph-social';
		} else {
			$file = 'paragraph-template';
		}

		return $this->renderer->render(
			$file . '.twig',
			[ 'paragraph' => $html ]
		);
	}
}
