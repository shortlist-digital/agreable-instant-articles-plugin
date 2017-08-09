<?php


namespace AgreableInstantArticlesPlugin;


interface GeneratorInterface {
	/**
	 * Generator constructor.
	 *
	 * @param $post_id
	 */
	public function __construct( $post_id );

	/**
	 *
	 * @return bool
	 */
	public function qualifies();

	/**
	 * @return mixed whatever type is required for api
	 */
	public function render();
}