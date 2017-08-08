<?php

namespace AgreableInstantArticlesPlugin\Controllers;

use AgreableInstantArticlesPlugin\Services\ClientProvider;
use TimberPost;

class StatusController {

	function __construct() {
		$this->client = ( new ClientProvider() )->get_client_instance();
	}

	public function index( $category_slug, $post_slug ) {
		$post          = get_page_by_path( $post_slug, OBJECT, 'post' );
		$post          = new TimberPost( $post->ID );
		$canonical_url = $post->catfish_importer_url;

		return $this->client->getSubmissionStatus( get_field( 'instant_articles_status_id', $post ) );
	}

}
