<?php

namespace AgreableInstantArticlesPlugin\Outlet\Facebook\Transforms;


/**
 * Class ListItem
 *
 * @package AgreableInstantArticlesPlugin\Outlet\Facebook\Transforms
 */
class ListItem extends AbstractWidget {
	/**
	 * @param $widget
	 *
	 * @return array
	 */
	public function getData() {

		$heading = strip_tags( $this->getField( 'heading' ) );
		$heading = html_entity_decode( $heading );

		$image = $this->getField( 'image.url' );

		$caption = strip_tags( $this->getField( 'copy' ) );
		$caption = html_entity_decode( $caption );

		return array(
			'heading' => trim( $heading ),
			'image'   => trim( $image ),
			'caption' => trim( $caption )
		);
	}
}

