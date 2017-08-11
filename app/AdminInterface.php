<?php


namespace AgreableInstantArticlesPlugin;


/**
 * Interface AdminInterface
 *
 * @package AgreableInstantArticlesPlugin
 */
interface AdminInterface {


	/**
	 * @return string
	 */
	public function render();

	/**
	 * @return bool
	 */
	public function handleChange();

	/**
	 * @return string
	 */
	public function printStats();
}