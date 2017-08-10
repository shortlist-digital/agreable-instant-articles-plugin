<?php


namespace AgreableInstantArticlesPlugin\Outlet\Facebook;


use AgreableInstantArticlesPlugin\AdminInterface;
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
			'debug'      => null
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
		if ( $this->config['app_id'] === null ) {
			$this->config['app_id'] = getenv( 'INSTANT_ARTICLES_APP_ID' );
		}
		if ( $this->config['app_secret'] === null ) {
			$this->config['app_secret'] = getenv( 'INSTANT_ARTICLES_APP_SECRET' );
		}
		if ( $this->config['page_token'] === null ) {
			$this->config['page_token'] = getenv( 'INSTANT_ARTICLES_PAGE_TOKEN' );
		}
		if ( $this->config['page_id'] === null ) {
			$this->config['page_id'] = getenv( 'INSTANT_ARTICLES_PAGE_ID' );
		}
		if ( $this->config['debug'] === null ) {
			if ( getenv( 'FB_INSTANT_ARTICLES_DEVELOPMENT_MODE' ) === "false" ) {
				$this->config['debug'] = false;
			} else {
				$this->config['debug'] = true;
			}
		}


		$this->api = new Api( $this->config['app_id'], $this->config['app_secret'],  $this->config['page_token'],  $this->config['page_id'], true );

	}

	/**
	 * @return AdminInterface
	 */
	public function getAdmin() {
		// TODO: Implement getAdmin() method.
	}
}