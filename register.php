<?php


add_filter( 'shortlist_get_outlets', function ( $outlets ) {
	$outlets[] = new \AgreableInstantArticlesPlugin\Outlet\Facebook\Outlet( 'fb_default' );
} );

add_filter( 'shortlist_get_outlets', function ( $outlets ) {
	$outlets[] = new \AgreableInstantArticlesPlugin\Outlet\Facebook\Outlet( 'fb_2nd' );
} );
