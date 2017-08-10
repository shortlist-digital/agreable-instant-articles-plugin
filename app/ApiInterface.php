<?php


namespace AgreableInstantArticlesPlugin;


use AgreableInstantArticlesPlugin\Exceptions\ApiException;

interface ApiInterface {
	/**
	 * @param $post_id int
	 *
	 * @return int Outlet id of element
	 */
	public function add( $post_id );

	/**
	 * @param $post_id
	 *
	 * @return int
	 * @throws ApiException
	 */
	public function update( $post_id );

	/**
	 * @param $post_id
	 *
	 * @return bool
	 */
	public function delete( $post_id );

	/**
	 * @return mixed
	 */
	public function getStatus();
}