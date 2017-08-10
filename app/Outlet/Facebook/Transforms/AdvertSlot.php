<?php


namespace AgreableInstantArticlesPlugin\Outlet\Facebook\Transforms;


/**
 * Class AdvertSlot
 *
 * @package AgreableInstantArticlesPlugin\Outlet\Facebook\Transforms
 */
class AdvertSlot extends AbstractWidget {
	/**
	 * @return array
	 */
	public function getData() {
		return array_merge( parent::getData(), [
			'advert_url_base' => getenv( 'WEB_BASE_URL' ) . '/advert/' . $this->post_id,
		] );
	}
}