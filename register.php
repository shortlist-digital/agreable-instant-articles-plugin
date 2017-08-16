<?php
ini_set( 'display_errors', 1 );
ini_set( 'display_startup_errors', 1 );
error_reporting( E_ALL );

add_filter( 'shortlist_get_outlets', function ( $outlets ) {

	// key uid this same as bottom uid
	$outlets['fb'] = new \AgreableInstantArticlesPlugin\Outlet\Facebook\Outlet( [
		'app_id'       => getenv( 'INSTANT_ARTICLES_APP_ID' ),
		'app_secret'   => getenv( 'INSTANT_ARTICLES_APP_SECRET' ),
		'page_id'      => getenv( 'INSTANT_ARTICLES_PAGE_ID' ),
		'user_token' => getenv( 'INSTANT_ARTICLES_USER_TOKEN' ),
		'debug'        => ! ( getenv( 'FB_INSTANT_ARTICLES_DEVELOPMENT_MODE' ) === "false" ),
	] );

	/*	if ( is_super_admin() ) {
			// key uid this same as bottom uid
			$outlets['fb_debug'] = new \AgreableInstantArticlesPlugin\Outlet\Facebook\Outlet( [
				'app_id'     => getenv( 'INSTANT_ARTICLES_APP_ID' ),
				'app_secret' => getenv( 'INSTANT_ARTICLES_APP_SECRET' ),
				'page_token' => getenv( 'INSTANT_ARTICLES_PAGE_TOKEN' ),
				'page_id'    => getenv( 'INSTANT_ARTICLES_PAGE_ID' ) . 'asd',
				'debug'      => true,
				'name'       => 'Fb Preview',
				'key'        => null
			] );
		}*/

	return $outlets;
} );
