<?php


namespace AgreableInstantArticlesPlugin;


/**
 * Interface ApiInterface
 *
 * @package AgreableInstantArticlesPlugin
 */
interface ApiInterface {

	/**
	 * @param int $post_id
	 *
	 * @param mixed $content
	 *
	 * @return string
	 */
	public function update( int $post_id, $content ): string;

	/**
	 * @param int $post_id
	 *
	 * @return string
	 */
	public function delete( int $post_id ): string;

	/**
	 * @param int $post_id
	 *
	 * @return string
	 */
	public function getStatus( int $post_id ): string;

	/**
	 * @return string
	 */
	public function getUniqueKey(): string;

}