<?php

namespace AgreableInstantArticlesPlugin;


add_action( 'save_post', function ( $post_id ) {
	/**
	 * Check if not revision and it is triggered by editor
	 */
	if ( wp_is_post_revision( $post_id ) && isset( $_REQUEST['sharing_center_editor'] ) && $_REQUEST['sharing_center_editor'] ) {
		return;
	}

	$outlets = Helper::getOutlets();

	foreach ( $outlets as $index => $outlet ) {
		$outlet->getAdmin()->handleChange();
	}
} );


add_action( 'admin_notices', array( Helper::class, 'admin_notices' ) );

