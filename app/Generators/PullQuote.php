<?php

namespace AgreableInstantArticlesPlugin\Generators;

class PullQuote extends TwigRenderer implements GeneratorInterface
{
	public function get( $widget ) {
		$text = $this->remove_quotes(
			$this->replace_smart_quotes($widget['text'])
		);

		return $this->renderer->render(
			'pull-quote.twig',
			[ 'text' => $text ]
		);
	}

	private function remove_quotes( $text ) {
		if ( substr( $text, 0, 1) === '"') {
			$text = substr( $text, 1, strlen( $text ) );
		}

		if ( substr( $text, -1, 1) === '"') {
			$text = substr( $text, 0, -1 );
		}

		return $text;
	}

	private function replace_smart_quotes( $text ) {
		$text = str_replace(
			[
				"\xe2\x80\x98",
				"\xe2\x80\x99",
				"\xe2\x80\x9c",
				"\xe2\x80\x9d",
				"\xe2\x80\x93",
				"\xe2\x80\x94",
				"\xe2\x80\xa6"
			],
			[
				"'",
				"'",
				'"',
				'"',
				'-',
				'--',
				'...'
			],
			$text
		);

		return str_replace(
			[ chr(145), chr(146), chr(147), chr(148), chr(150), chr(151), chr(133) ],
			[ "'", "'", '"', '"', '-', '--', '...' ],
			$text
		);
	}
}
