<?php

namespace AgreableInstantArticlesPlugin\Outlet\Facebook\Transforms;


/**
 * Class Image
 *
 * @package AgreableInstantArticlesPlugin\Outlet\Facebook\Transforms
 */
class Image extends AbstractWidget {

	/**
	 * @param $widget
	 *
	 * @return array
	 */
	public function getData() {

		$image   = $this->getField( 'image.url', null );
		$caption = strip_tags( $this->getField( 'caption' ) );

		return array(
			'image'   => $image,
			'caption' => $caption
		);

	}
}
