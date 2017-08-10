<?php

namespace AgreableInstantArticlesPlugin\Outlet\Facebook\Transforms;

use Sunra\PhpSimple\HtmlDomParser;

/**
 * Class Html
 *
 * @package AgreableInstantArticlesPlugin\Outlet\Facebook\Transforms
 */
class Html extends AbstractWidget {
	/**
	 * @param $widget
	 *
	 * @return array
	 */
	public function getData() {

		$embed     = "<div>" . $this->getField( 'html' ) . "</div>";
		$embed_dom = HtmlDomParser::str_get_html( $embed );

		// Tell playbuzz we're using instant articles
		$pb = $embed_dom->find( '.pb_feed' );
		if ( isset( $pb[0] ) ) {
			if ( isset( $pb[0]->{'data-game'} ) && $pb[0]->{'data-game'} ) {
				$pb[0]->{'data-origin'} = 'instant-article';
				$embed                  = $embed_dom->innertext;
			}
		}

		return array(
			'embed' => $embed
		);
	}
}
