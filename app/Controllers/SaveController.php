<?php

namespace AgreableInstantArticlesPlugin\Controllers;

use AgreableInstantArticlesPlugin\Services\Client;
use AgreableInstantArticlesPlugin\Services\ClientProvider;
use AgreableInstantArticlesPlugin\Services\Generator;
use Facebook\InstantArticles\Elements\InstantArticle;
use Facebook\InstantArticles\Transformer\Transformer;

class SaveController {

	private $generator;
	private $client_provider;

	public function __construct( Generator $generator, ClientProvider $client_provider ) {
		$this->generator = $generator;
		$this->client_provider = $client_provider;
	}

	public function save( \WP_Post $post ) {
		if ( $post->post_status !== 'publish' ) {
			return;
		}

		$instant_article = $this->generator->create_object( $post );

		try {
			$client = $this->client_provider->get_client_instance();
			$response = $client->importArticle( $instant_article );

			if ( isset( $response->id ) ) {
				update_field('instant_articles_status_id', $response->id, $post);
			}
		} catch (Exception $e) {
			echo 'Could not import the article: '.$e->getMessage();
		}
	}
}
