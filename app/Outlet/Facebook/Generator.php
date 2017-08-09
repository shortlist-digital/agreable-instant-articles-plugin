<?php


namespace AgreableInstantArticlesPlugin\Outlet\Facebook;


use AgreableInstantArticlesPlugin\GeneratorInterface;

class Generator implements GeneratorInterface {

	/**
	 * @var int
	 */
	public $post_id;

	/**
	 * @var array
	 */
	private $widgets = [];

	/**
	 * Generator constructor.
	 *
	 * @param $post_id
	 */
	public function __construct( $post_id ) {

		$this->post_id = $post_id;
		$widgets       = get_field( 'widgets', $post_id );
		$this->widgets = is_null( $widgets ) ? [] : $widgets;
	}

	/**
	 *
	 * @return bool
	 */
	public function qualifies() {
		return true;
	}

	/**
	 * @return mixed whatever type is required for api
	 */
	public function render() {
		$widgets = $this->getWidgets();

		foreach ( $widgets as $index => $widget ) {

		}

	}

	/**
	 * @return array
	 */
	public function getWidgets() {
		return $this->widgets;
	}


}