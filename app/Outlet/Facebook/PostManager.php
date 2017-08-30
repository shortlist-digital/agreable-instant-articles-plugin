<?php


namespace AgreableInstantArticlesPlugin\Outlet\Facebook;


use AgreableInstantArticlesPlugin\Helper;
use AgreableInstantArticlesPlugin\OutletInterface;
use Croissant\Helper\ArrayHelper;
use Facebook\InstantArticles\Elements\InstantArticle;

/**
 * Class PostManager
 * Post manager is responsible for all the post related actions Like saving post fields etc.
 *
 * @package AgreableInstantArticlesPlugin\Outlet\Facebook
 */
class PostManager {

	/**
	 * @var Api
	 */
	private $api;

	/**
	 * @var string
	 */
	private $key;

	/**
	 * @var int
	 */
	private $post_id;

	/**
	 * @var Generator
	 */
	private $generator;

	/**
	 * @var OutletInterface
	 */

	private $outlet;

	/**
	 *
	 */
	const ACTIVE_STATUS = 'publish';

	/**
	 * Admin constructor.
	 *
	 * @param OutletInterface $outlet
	 * @param $name
	 * @param null $post_id
	 */
	public function __construct( Outlet $outlet, int $post_id ) {

		$this->api     = $outlet->getApi();
		$this->key     = $outlet->getUniqueKey();
		$this->outlet  = $outlet;
		$this->post_id = $post_id;

	}


	/**
	 * @param $post_id int
	 *
	 * @return bool
	 */
	public function handleChange() {

		$isActive = $this->isSyncActive();

		if ( self::isAdminRequest() ) {
			$isActive = $this->updateCheckbox();
		}

		if ( $isActive && get_post_status( $this->post_id ) === self::ACTIVE_STATUS ) {

			$instant = $this->getInstantArticle();
			$errors  = $this->getTransformerErrors();
			if ( ! empty($errors) ) {
				throw new \Exception( 'There were some issues when generating content for post id: ' . $this->post_id );
			}
			$hash      = md5( serialize( $instant ) );
			$last_hash = $this->getField( 'last_update_hash' );
			$res       = false;

			if ( $last_hash !== $hash ) {

				$res = $this->api->update( $this->post_id, $instant );

				if ( $res !== false ) {

					$this->setField( 'last_update_hash', $hash );
				} else {

					Helper::set_notification( 'There was problem while updating instant articles. Please contact developer' );
				}

			}

			return $res;

		} else {
			$this->api->delete( $this->post_id );
		}

		return true;
	}

	/**
	 * @return string
	 */
	public function printStats(): string {

		$gen_stats = $this->getGenerator()->getStats( $this->key );
		$api_stats = $this->api->getStats( $this->post_id );

		$rows = [ '<h4 style="margin-bottom:0;padding-bottom:0;">Generator</h4>' ];

		foreach ( $gen_stats as $index => $gen_stat ) {
			if ( is_array( $gen_stat ) || is_object( $gen_stat ) ) {
				$rows[] = "<span><b>$index</b>: " . json_encode( $gen_stat ) . "</span>";
			} else {
				$rows[] = "<span><b>$index</b>: $gen_stat</span>";
			}

		}

		$rows[] = '<h4 style="margin-bottom:0;padding-bottom:0;">Api</h4>';

		foreach ( $api_stats as $index => $gen_stat ) {
			if ( is_array( $gen_stat ) || is_object( $gen_stat ) ) {
				$rows[] = "<span><b>$index</b>: " . json_encode( $gen_stat ) . "</span>";
			} else {
				$rows[] = "<span><b>$index</b>: $gen_stat</span>";
			}
		}

		return implode( '<br>' . PHP_EOL, $rows );
	}

	/**
	 * @return Generator
	 */
	public function getGenerator() {
		if ( ! isset( $this->generator ) ) {
			$this->generator = $this->outlet->createGenerator( $this->post_id );
		}

		return $this->generator;
	}

	/**
	 * @return array
	 */
	public function getTransformerErrors() {
		return $this->getGenerator()->getWarnings();
	}

	/**
	 * @return InstantArticle
	 */
	public function getInstantArticle() {

		return $this->getGenerator()->get();
	}


	/**
	 * @return bool
	 */
	static public function isAdminRequest() {
		return isset( $_REQUEST, $_REQUEST['sharing_center_editor'] ) && $_REQUEST['sharing_center_editor'] == 1;
	}

	/**
	 * @return bool
	 */
	public function isSyncActive() {

		return (bool) $this->getField( 'sync' );
	}

	/**
	 * @return bool
	 */
	public function updateCheckbox() {
		$val = ArrayHelper::getValueByPath( $_REQUEST, 'sharing_center.' . $this->key, 0 );

		$this->setField( 'sync', $val );

		return (bool) $val;
	}

	/**
	 * @param $name
	 * @param null $value
	 *
	 * @return bool|int
	 * @internal param $post_id
	 */
	public function setField( $name, $value = null ) {
		return update_post_meta( $this->post_id, $this->key . '_' . $name, $value );
	}

	/**
	 * @param $name
	 *
	 * @return mixed
	 * @internal param $post_id
	 */
	public function getField( $name ) {
		return get_post_meta( $this->post_id, $this->key . '_' . $name, true );
	}
}
