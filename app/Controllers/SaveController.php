<?php namespace AgreableInstantArticlesPlugin\Controllers;

use AgreableInstantArticlesPlugin\Services\ClientProvider;
use TimberPost;

class SaveController {

	function __construct( TimberPost $post ) {
		if ( ! property_exists( $post, 'catfish_importer_url' ) ) {
			return;
		}
		$this->post      = $post;
		$take_live       = ! empty( $post->instant_articles_is_preview );
		$permalink       = get_permalink( $this->post->id );
		$url             = "$permalink/instant-articles?bypass";
		$instant_article = $this->build_article_object( $url );
		$client          = ( new ClientProvider() )->get_client_instance();
		try {
			$response = $client->importArticle( $instant_article, $take_live );
			if ( $id = $response->id ) {
				update_field( 'instant_articles_status_id', $id, $post );
			}
		} catch ( Exception $e ) {
			echo 'Could not import the article: ' . $e->getMessage();
		}
	}

	public function build_article_object( $url ) {
		try {
			$html = file_get_contents( $url, true );
		} catch ( \Exception $e ) {
			echo $e->getMessage();
			die;
		}

		return $html;

	}

}
