<?php

namespace AgreableInstantArticlesPlugin;


/**
 * Class Helper
 *
 * @package AgreableInstantArticlesPlugin
 */
class Helper {
	/**
	 * @var OutletInterface[]
	 */
	private static $outlets;

	public static function getOutlets() {

		if ( ! isset( self::$outlets ) ) {
			self::$outlets = apply_filters( 'shortlist_get_outlets', [] );
		}

		return self::$outlets;

	}

	/**
	 * @param $name
	 *
	 * @return OutletInterface|bool
	 */
	public static function getOutletByKey( $name ) {
		$outlets = self::getOutlets();
		if ( isset( $outlets[ $name ] ) ) {
			return $outlets[ $name ];
		}

		return false;
	}

	/**
	 * @param $permalink string
	 *
	 * @return string
	 */
	public static function reverseLinkReplacement( $permalink ) {

		$web_base_url = getenv( 'WEB_BASE_PROTOCOL' ) . getenv( 'WEB_BASE_DOMAIN' );

		return str_replace( $web_base_url, getenv( 'WP_HOME' ), $permalink );
	}
}