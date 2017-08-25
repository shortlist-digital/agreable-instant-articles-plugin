<?php


namespace AgreableInstantArticlesPlugin;


/**
 * Interface GeneratorInterface
 *
 * @package AgreableInstantArticlesPlugin
 */
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
	 * @return mixed whatever type is required for api
	 */
	public function get();


	/**
	 * @return array
	 */
	public function generateDebugCode(): array;
}