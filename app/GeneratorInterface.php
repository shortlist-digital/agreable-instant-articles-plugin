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
	 * You have here option to bail out if article is not valid
	 * To bail you can return array of error messages or just false for generic message
	 *
	 * @return bool|[]
	 */
	public function qualifies();

	/**
	 * @return mixed whatever type is required for api
	 */
	public function render();

}