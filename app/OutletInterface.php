<?php


namespace AgreableInstantArticlesPlugin;


/**
 * Interface OutletInterface
 *
 * @package AgreableInstantArticlesPlugin
 */
interface OutletInterface {

	/**
	 * Generates unique key for the outlet
	 * This key is used across different places and most of all allows us to have multiple instances of this same outlet
	 * @return string
	 */
	public function getUniqueKey();

	/**
	 * @param int $post_id
	 * @return string
	 */
	public function getStatus( int $post_id ): string;

	/**
	 * @param int $post_id
	 *
	 * @return bool
	 */
	public function handleChange( int $post_id ): bool;

	/**
	 * @param int $post_id
	 *
	 * @return array
	 */
	public function generateExetrnalPageDebugCode( int $post_id ): array;

	/**
	 * @param int $post_id
	 *
	 * @return string
	 */
	public function getStats( int $post_id ): string;

	/**
	 * @param int $post_id
	 *
	 * @return string
	 */
	public function generateInterface( int $post_id ): string;

}