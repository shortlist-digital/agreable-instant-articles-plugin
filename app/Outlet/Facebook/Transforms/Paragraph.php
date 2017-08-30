<?php

namespace AgreableInstantArticlesPlugin\Outlet\Facebook\Transforms;


/**
 * Class Paragraph
 *
 * @package AgreableInstantArticlesPlugin\Outlet\Facebook\Transforms
 */
class Paragraph extends AbstractWidget {
	/**
	 * @return array
	 */
	public function getData() {

		$html = $this->getField( 'paragraph', '' );

		return [
			'paragraph' => $html
		];
	}

	/**
	 * @return mixed|null
	 */
	public function getTemplate() {

		$html      = $this->getField( 'paragraph', '' );
		$extension = '.twig';

		if ( preg_match( '/data-firebase-id/', $html ) ) {
			return null;
		} elseif ( preg_match_all( '/twitter-tweet|data-instgrm-version/', $html ) ) {
			$extension = '-social.twig';
		}

		return str_replace( '.twig', $extension, parent::getTemplate() );
	}

}
