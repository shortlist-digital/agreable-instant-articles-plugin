<?php

namespace AgreableInstantArticlesPlugin\Controllers;

use TimberPost;

use AgreableInstantArticlesPlugin\Services\Client;
use AgreableInstantArticlesPlugin\Services\ClientProvider;
use AgreableInstantArticlesPlugin\Services\Generator;
use Facebook\InstantArticles\Elements\InstantArticle;
use Facebook\InstantArticles\Transformer\Transformer;

class SaveController {
	function __construct(TimberPost $post) {
		// not published, no Facebook IA for you
		if ( $post->post_status !== 'publish' ) {
			return;
		}

		$instant_article = (new Generator)->create_object($post);

		try {
			$client = (new ClientProvider())->get_client_instance();

			$response = $client->importArticle( $instant_article );

			if ($id = $response->id) {
				update_field('instant_articles_status_id', $id, $post);
			}
		} catch (Exception $e) {
			echo 'Could not import the article: '.$e->getMessage();
		}
	}
}
