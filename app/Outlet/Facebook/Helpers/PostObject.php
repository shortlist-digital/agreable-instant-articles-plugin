<?php


namespace AgreableInstantArticlesPlugin\Outlet\Facebook\Helpers;

use Croissant\Helper\ArrayHelper;


/**
 * Class PostObject
 *
 * @package AgreableInstantArticlesPlugin\Outlet\Facebook\Helpers
 */
class PostObject extends \ArrayObject {

	/**
	 * @var
	 */
	public $post_id;

	/**
	 * PostObject constructor.
	 *
	 * @param $post_id int
	 */
	public function __construct( $post_id ) {

		$post = get_post( (int) $post_id );
		parent::__construct( $post->to_array() );

	}

	/**
	 * @param $name
	 *
	 * @return mixed|null
	 */
	public function __get( $name ) {
		if ( isset( $this->{'post_' . $name} ) ) {
			return $this->{'post_' . $name};
		}

		return get_field( $name, $this->post_id );
	}

	public function getField( $path ) {
		ArrayHelper::getValueByPath( $this, $path, null );
	}
}