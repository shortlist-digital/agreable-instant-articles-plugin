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
		foreach ( $outlets as $index => $outlet ) {
			if ( $outlet->getUniqueKey() === $name ) {
				return $outlet;
			}
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

		return rtrim( str_replace( rtrim( $web_base_url, '/' ), rtrim( getenv( 'WP_HOME' ), '/' ), $permalink ), '/' );
	}
}