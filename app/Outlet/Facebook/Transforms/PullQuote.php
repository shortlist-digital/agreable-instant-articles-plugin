<?php

namespace AgreableInstantArticlesPlugin\Outlet\Facebook\Transforms;


/**
 * Class PullQuote
 *
 * @package AgreableInstantArticlesPlugin\Outlet\Facebook\Transforms
 */
class PullQuote extends AbstractWidget {
	/**
	 * @return array
	 */
	public function getData() {
		return [ 'text' => $this->getField( 'text', '' ) ];
	}
}
