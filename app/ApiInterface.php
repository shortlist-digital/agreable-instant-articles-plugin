<?php


namespace AgreableInstantArticlesPlugin;


use AgreableInstantArticlesPlugin\Exceptions\ApiFailException;

interface ApiInterface {
	/**
	 * @param $post_id int
	 *
	 * @return int Outlet id of element
	 */
	public function create( $post_id );

	/**
	 * @param $post_id
	 * @return int
	 * @throws ApiFailException
	 */
	public function update( $post_id );

	/**
	 * @param $post_id
	 *
	 * @return mixed
	 */
	public function delete( $post_id );
}