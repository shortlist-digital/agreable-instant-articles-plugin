<?php


namespace AgreableInstantArticlesPlugin;


interface OutletInterface {
	/**
	 * @return string
	 */
	public function getName();

	/**
	 * @return GeneratorInterface
	 */
	public function getGenerator();

	/**
	 * @return ApiInterface
	 */
	public function getApi();

	/**
	 * @return mixed
	 */
	public function getAdmin();
}