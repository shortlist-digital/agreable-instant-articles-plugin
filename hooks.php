<?php

namespace AgreableInstantArticlesPlugin;


add_action( 'save_post', function ( $post_id ) {

	if ( wp_is_post_revision( $post_id ) ) {
		return;
	}

	$outlets = Helper::getOutlets();

	foreach ( $outlets as $index => $outlet ) {
		$outlet->getAdmin()->handleChange();
	}
} );


