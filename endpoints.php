<?php

namespace AgreableInstantArticlesPlugin;


function show_404() {
	status_header( 404 );
	nocache_headers();
	exit( 'Sorry, we couldn\'t find what you\'re looking for.' );
}

add_filter( 'query_vars', function ( $vars ) {

	$vars[] = "photos";

	return $vars;
} );

/**
 *   Add the 'photos' query variable so Wordpress
 *   won't mangle it.
 */

add_action( 'init', function () {

	add_rewrite_endpoint( 'sharing_center', EP_PERMALINK | EP_PAGES );
} );


add_filter( 'single_template', function () {

	global $wp_query;


	// if this is not a request for json or a singular object then bail
	if ( ! is_super_admin() && ! isset( $wp_query->query_vars['sharing_center'] ) ) {
		return;
	}

	$route = explode( '/', trim( $wp_query->query_vars['sharing_center'], '/' ) );

	$outletKey = array_shift( $route );
	$action    = array_shift( $route );

	if ( ! $outletKey || ! $action || count( $route ) > 0 ) {
		throw new \Exception( 'It seems like one of the attributes is missing' );
	}

	$outlet = Helper::getOutletByKey( $outletKey );

	if ( ! $outlet ) {
		throw new \Exception( 'Outlet with this name does not exist' );
	}

	//if outlet not defined bail
	if ( ! $outletKey ) {
		return;
	}
	/**
	 * @var $outlet OutletInterface
	 */
	switch ( $action ) {
		case ( 'generate' ):

			$html = $outlet->createGenerator( get_the_ID() )->render()->__toString();
			include __DIR__ . '/views/editor.php';

			break;
		case( 'stats' ):
			echo $outlet->getApi()->getStatus( get_the_ID() );
			break;
		default:
			throw new \Exception( 'It seems like this action does not exist' );
	}


	exit( );
}, 0, 0 );