<?php


namespace AgreableInstantArticlesPlugin\Outlet\Facebook;


use AgreableInstantArticlesPlugin\ApiInterface;
use AgreableInstantArticlesPlugin\GeneratorInterface;
use AgreableInstantArticlesPlugin\OutletInterface;

/**
 * Class Outlet
 *
 * @package AgreableInstantArticlesPlugin\Outlet\Facebook
 */
class Outlet implements OutletInterface {
	/**
	 * @var Api
	 */
	public $api;

	/**
	 * @var array
	 */
	public $config;

	/**
	 * Outlet constructor.
	 */
	public function __construct( $config = [] ) {

		$this->config = array_merge( [
			'app_id'     => null,
			'app_secret' => null,
			'page_token' => null,
			'page_id'    => null,
			'debug'      => null,
			'name'       => 'Instant Articles',
		], $config );


	}

	/**
	 * @return GeneratorInterface
	 */
	public function createGenerator( $post_id ) {
		return new Generator( $post_id );
	}

	/**
	 * @return ApiInterface
	 */
	public function getApi() {
		if ( $this->api ) {
			return $this->api;
		}

		$this->api = new Api( $this->config['app_id'], $this->config['app_secret'], $this->config['page_token'], $this->config['page_id'], true );

		return $this->api;
	}

	/**
	 * @return string
	 */
	public function getUniqueKey() {
		return $this->getApi()->getUniqueKey();
	}

	/**
	 * @return string
	 */
	public function getName() {
		return $this->config['name'];
	}


	/**
	 * @return Admin
	 */
	public function getAdmin() {
		return new Admin( $this, $this->getName() );
	}


}