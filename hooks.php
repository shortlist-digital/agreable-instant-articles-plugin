<?php

namespace AgreableInstantArticlesPlugin;


add_action( 'save_post', function ( $post_id ) {

	if ( wp_is_post_revision( $post_id ) ) {
		return;
	}

	if ( ! in_array( get_post_status( $post_id ), [ 'publish', 'draft' ] ) ) {
		Api::delete( $post_id );
		return;
	}
	Api::update( $post_id );
} );


