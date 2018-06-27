<?php

namespace AgreableInstantArticlesPlugin\Controllers;

use Timberpost;

use AgreableInstantArticlesPlugin\Services\ClientProvider;

class DeleteController {

	private $client_provider;
	private $facebook_ia_domain;

	public function __construct( ClientProvider $client_provider, $facebook_ia_domain ) {
		$this->client_provider = $client_provider;
		$this->facebook_ia_domain = $facebook_ia_domain;
	}

    function delete( \WP_Post $post ) {
        $client = $this->client_provider->get_client_instance();
        $final_url = get_permalink( $post->ID );
        $url = parse_url( $final_url );

        if ( $url['host'] !== $this->facebook_ia_domain ) {
            $final_url = $url['scheme'] . '://' . $this->facebook_ia_domain . $url['path'];
        }

        $client->removeArticle( $final_url );
    }
}
