<?php


namespace AgreableInstantArticlesPlugin;


use AgreableInstantArticlesPlugin\Exceptions\ApiException;

interface ApiInterface {

	/**
	 * @param $post_id
	 *
	 * @return int
	 * @throws ApiException
	 */
	public function update( $post_id,$content );

	/**
	 * @param $post_id
	 *
	 * @return bool
	 */
	public function delete( $post_id );

	/**
	 * @return mixed
	 */
	public function getStatus( $post_id );

	/**
	 * @return string
	 */
	public function getUniqueKey();

}