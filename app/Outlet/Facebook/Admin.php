<?php


namespace AgreableInstantArticlesPlugin\Outlet\Facebook;


use AgreableInstantArticlesPlugin\AdminInterface;
use AgreableInstantArticlesPlugin\ApiInterface;
use AgreableInstantArticlesPlugin\OutletInterface;
use Croissant\Helper\ArrayHelper;

/**
 * Class Admin
 *
 * @package AgreableInstantArticlesPlugin\Outlet\Facebook
 */
class Admin implements AdminInterface {

	/**
	 * @var ApiInterface
	 */
	private $api;

	/**
	 * @var string
	 */
	private $name;

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
	const WILL_UPDATE = 'WILL_UPDATE';

	/**
	 *
	 */
	const WILL_DELETE = 'WILL_DELETE';

	/**
	 *
	 */
	const WILL_CREATE = 'WILL_CREATE';

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
	public function __construct( OutletInterface $outlet, $name, $post_id = null ) {

		$this->api = $outlet->getApi();

		$this->name   = $name;
		$this->key    = $this->api->getUniqueKey();
		$this->outlet = $outlet;

		if ( $post_id === null ) {
			$this->post_id = get_the_ID();
		}
	}

	/**
	 * @return string
	 */
	public function render() {
		return '<label><input name="sharing_center[' . $this->key . ']" type="checkbox" value="1" ' . ( $this->isActive() ? 'checked' : '' ) . '><span class="dashicons dashicons-facebook-alt" alt="' . esc_attr( $this->getName() ) . '"></span></label>';
	}

	/**
	 * @return bool
	 */
	public function handleChange() {
		$action    = null;
		$wasActive = $this->isActive();
		$isActive  = $wasActive;
		if ( $this->isAdminRequest() ) {
			$isActive = $this->updateCheckbox();
		}

		if ( $isActive && get_post_status( $this->post_id ) === self::ACTIVE_STATUS ) {

			$insta = $this->getInstantArticle();
			$hash  = md5( $insta );
			$res   = false;
			if ( ! $wasActive ) {
				$res = $this->api->add( $this->post_id, $insta );
				$this->setField( 'active', $res );
				//updates only if hash different
			} elseif ( $this->getField( 'last_update_hash' ) !== $hash ) {
				$res = $this->api->update( $this->post_id, $insta );
			}

			$this->setField( 'last_update_hash', $hash );

			return $res;
		}


		$this->api->delete( $this->post_id );
	}

	public function printStats() {
		$this->getGenerator()->get();
		$gen_stats = $this->getGenerator()->getStats( $this->key );
		$api_stats = $this->api->getStats( $this->post_id );

		$rows = [ '<span>Generator</span>' ];

		foreach ( $gen_stats as $index => $gen_stat ) {
			if ( is_array( $gen_stat ) || is_object( $gen_stat ) ) {
				$rows[] = "<span>$index: " . json_encode( $gen_stat ) . "</span>";
			} else {
				$rows[] = "<span>$index: $gen_stat</span>";
			}

		}

		$rows[] = '<span>Api</span>';

		foreach ( $api_stats as $index => $gen_stat ) {
			$rows[] = "<span>$index: $gen_stat</span>";
		}

		return implode( '<br>' . PHP_EOL, $rows );
	}

	/**
	 * @return string
	 */
	public function getName() {
		return $this->name;
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
	 * @return string
	 */
	public function getInstantArticle() {

		return $this->getGenerator()->get();
	}


	/**
	 * @return bool
	 */
	private function isAdminRequest() {
		return isset( $_REQUEST, $_REQUEST['sharing_center_editor'] ) && $_REQUEST['sharing_center_editor'] == 1;
	}

	/**
	 * @return bool
	 */
	public function isActive() {

		return (bool) $this->getField( 'checkbox' ) && $this->getField( 'checkbox_active' );
	}

	/**
	 * @return bool
	 */
	public function updateCheckbox() {
		$val = ArrayHelper::getValueByPath( $_REQUEST, 'sharing_center.' . $this->key, 0 );
		$this->setField( 'checkbox', $val );

		return (bool) $val;
	}

	/**
	 * @param $post_id
	 * @param $name
	 * @param null $value
	 *
	 * @return bool|int
	 */
	public function setField( $name, $value = null ) {
		return update_post_meta( $this->post_id, $this->key . '_' . $name, $value );
	}

	/**
	 * @param $post_id
	 * @param $name
	 *
	 * @return mixed
	 */
	public function getField( $name ) {
		return get_post_meta( $this->post_id, $this->key . '_' . $name, true );
	}
}
