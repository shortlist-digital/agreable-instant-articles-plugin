<?php


namespace AgreableInstantArticlesPlugin\Outlet\Facebook;


use AgreableInstantArticlesPlugin\ApiInterface;
use AgreableInstantArticlesPlugin\Exceptions\ApiException;
use Facebook\InstantArticles\Client\Client;

/**
 * Class Api
 *
 * @package AgreableInstantArticlesPlugin\Outlet\Facebook
 */
class Api implements ApiInterface {
	/**
	 * @var static
	 */
	private $client;
	/**
	 * @var string created from app id/page_id/mode everything else can be changed
	 */
	private $uniqueKey;

	/**
	 * Api constructor.
	 *
	 * @param $appID
	 * @param $appSecret
	 * @param $accessToken
	 * @param $pageID
	 * @param $developmentMode
	 */
	public function __construct( $appID, $appSecret, $accessToken, $pageID, $developmentMode ) {
		$this->uniqueKey = implode( '_', [ 'ia', $appID, $pageID, $developmentMode ? 'dev' : 'prod' ] );
		$this->client    = Client::create( $appID, $appSecret, $accessToken, $pageID, $developmentMode );
	}

	/**
	 * @param $post_id int
	 *
	 * @return int Outlet id of element
	 */
	public function add( $post_id ) {
		// TODO: Implement create() method.
	}

	/**
	 * @param $post_id
	 *
	 * @return int
	 * @throws ApiException
	 */
	public function update( $post_id ) {

	}

	/**
	 * @param $post_id
	 *
	 * @return bool
	 */
	public function delete( $post_id ) {
		// TODO: Implement delete() method.
	}

	/**
	 * @return mixed
	 */
	public function getStatus() {
		// TODO: Implement getStatus() method.
	}

	/**
	 * @param $post_id
	 * @param $name
	 * @param null $value
	 *
	 * @return bool|int
	 */
	public function setField( $post_id, $name, $value = null ) {
		return update_post_meta( $post_id, $this->uniqueKey . '_' . $name, $value );
	}

	/**
	 * @param $post_id
	 * @param $name
	 *
	 * @return mixed
	 */
	public function getField( $post_id, $name ) {
		return get_post_meta( $post_id, $this->uniqueKey . '_' . $name, true );
	}


}