<?php


namespace AgreableInstantArticlesPlugin;


interface OutletInterface {

	/**
	 * @return GeneratorInterface
	 */
	public function createGenerator( $post_id );

	/**
	 * @return ApiInterface
	 */
	public function getApi();

	/**
	 * @return AdminInterface
	 */
	public function getAdmin();

	/**
	 * @return string
	 */
	public function getUniqueKey();

}