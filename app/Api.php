<?php


namespace AgreableInstantArticlesPlugin;


use Facebook\InstantArticles\Client\Client;

abstract class Api {
	const IA_PUBLISH = 'article_should_publish_to_instant_articles';
	const IA_PREVIEW = 'instant_articles_is_preview';
	const IA_STATUS = 'instant_articles_status_id';

	public static function update( $post_id ) {


		$take_live = get_field( self::IA_PUBLISH, $post_id );
		$preview   = get_field( self::IA_PREVIEW, $post_id );

	}

	/**
	 * @param $post_id
	 * @param null $client
	 *
	 * @return bool|\Facebook\InstantArticles\Client\InstantArticleStatus
	 */
	public static function delete( $post_id, $client = null ) {
		$perm = get_permalink( $post_id );

		if ( $perm ) {
			return false;
		}

		return self::getClient( $client )->removeArticle( $perm );

	}

	/**
	 * Creates or updates item
	 *
	 * @param $post_id
	 * @param null $client
	 */
	public static function save( $post_id, $client = null ) {

		$take_live = get_field( 'instant_articles_is_preview', $post_id );


		$response = self::getClient( $client )->importArticle( $instant_article, $take_live );
		update_field( 'instant_articles_status_id', $response->id, $post_id );

	}

	public static function getStatus( $post_id, $client = null ) {
		return self::getClient( $client )->getSubmissionStatus( get_field( self::IA_STATUS, $post_id ) );
	}

	/**\
	 * @param $client
	 *
	 * @return Client
	 * @throws \Exception
	 */
	public static function getClient( $client ) {

		if ( $client instanceof Client ) {
			return $client;
		}

		if ( $client === null ) {
			return self::createClient();
		}

		throw new \Exception( 'Client need to be instance of ' . Client::class . ' or NULL, ' . gettype( $client ) . ':' . get_class( $client ) . ' given' );
	}

	/**
	 * @param null $appID
	 * @param null $appSecret
	 * @param null $accessToken
	 * @param null $pageID
	 * @param null $developmentMode
	 *
	 * @return Client
	 */
	public static function createClient( $appID = null, $appSecret = null, $accessToken = null, $pageID = null, $developmentMode = null ) {

		if ( $appID === null ) {
			$appID = getenv( 'INSTANT_ARTICLES_APP_ID' );
		}
		if ( $appSecret === null ) {
			$appSecret = getenv( 'INSTANT_ARTICLES_APP_SECRET' );
		}
		if ( $accessToken === null ) {
			$accessToken = getenv( 'INSTANT_ARTICLES_PAGE_TOKEN' );
		}
		if ( $pageID === null ) {
			$pageID = getenv( 'INSTANT_ARTICLES_PAGE_ID' );
		}
		if ( $developmentMode === null ) {
			if ( getenv( 'FB_INSTANT_ARTICLES_DEVELOPMENT_MODE' ) === "false" ) {
				$developmentMode = false;
			} else {
				$developmentMode = true;
			}
		}


	}

	public function createIA( $post_id ) {
		$permalink       = get_permalink( $post_id );
		$url             = "$permalink/instant-articles?bypass";
		$instant_article = file_get_contents( $url, true );
	}
}