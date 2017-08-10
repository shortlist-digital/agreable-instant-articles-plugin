<?php


add_filter( 'shortlist_get_outlets', function ( $outlets ) {
	$outlets['fb'] = new \AgreableInstantArticlesPlugin\Outlet\Facebook\Outlet();

	return $outlets;
} );
