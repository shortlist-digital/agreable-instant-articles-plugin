<?php


namespace AgreableInstantArticlesPlugin\Outlet\Facebook;


use AgreableInstantArticlesPlugin\ApiInterface;
use AgreableInstantArticlesPlugin\GeneratorInterface;

/**
 * Class Outlet
 *
 * @package AgreableInstantArticlesPlugin\Outlet\Facebook
 */
class Outlet extends \AgreableInstantArticlesPlugin\Outlet {
	/**
	 * @var Api
	 */
	public $api;

	/**
	 * @var array
	 */
	public $config;
	/**
	 * @var array
	 */
	private $post_managers = [];

	/**
	 * Outlet constructor.
	 *
	 * @param array $config
	 */
	public function __construct( $config = [] ) {

		$this->config = array_merge( [
			'app_id'     => null,
			'app_secret' => null,
			'user_token' => null,
			'page_id'    => null,
			'debug'      => null,
			'name'       => 'Instant Articles',
		], $config );


	}
	/**
	 * Interface methods
	 */
	/**
	 * @return string
	 */
	public function getUniqueKey() {
		return $this->getApi()->getUniqueKey();
	}


	/**
	 * @param int $post_id
	 *
	 * @return PostManager
	 */
	public function getPostManager( int $post_id ) {

		if ( ! isset( $this->post_managers[ $post_id ] ) ) {
			$this->post_managers[ $post_id ] = new PostManager( $this, $post_id );
		}

		return $this->post_managers[ $post_id ];
	}

	/**
	 * @inheritdoc
	 */
	public function getStatus( int $post_id ): string {

		$isActive = $this->getPostManager( $post_id )->isSyncActive();
		if ( ! $isActive ) {
			return self::STATUS_DISABLED;
		}

		return $this->getApi()->getStatus( $post_id );

	}

	/**
	 * @inheritdoc
	 */
	public function handleChange( int $post_id ): bool {

		return $this->getPostManager( $post_id )->handleChange();
	}

	/**
	 * @inheritdoc
	 */
	public function generateExetrnalPageDebugCode( int $post_id ): array {

		return $this->createGenerator( $post_id )->generateDebugCode();
	}

	/**
	 * @inheritdoc
	 */
	public function getStats( int $post_id ): string {

		return $this->getPostManager( $post_id )->printStats();
	}

	/**
	 * @inheritdoc
	 */
	public function generateInterface( int $post_id ): string {

		return '<label class="sharing_center_label sharing_center_label-' . $this->getStatus( $post_id ) . '"><input name="sharing_center[' . $this->getUniqueKey() . ']" type="checkbox" value="1" ' . ( $this->getPostManager( $post_id )->isSyncActive() ? 'checked' : '' ) . '><span class="dashicons dashicons-facebook-alt" alt="' . esc_attr( $this->getName() ) . '"></span></label>';
	}

	/**
	 * Non interface methods
	 */

	/**
	 * @param $post_id
	 *
	 * @return Generator
	 */
	public function createGenerator( $post_id ) {
		return new Generator( $post_id );
	}

	/**
	 * @return Api
	 */
	public function getApi() {
		if ( $this->api ) {
			return $this->api;
		}

		$this->api = new Api( $this->config['app_id'], $this->config['app_secret'], $this->config['user_token'], $this->config['page_id'], $this->config['debug'] === true );

		return $this->api;
	}

	/**
	 * @return string
	 */
	private function getName() {
		return $this->config['name'];
	}
}