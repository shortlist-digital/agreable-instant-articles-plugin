<?php


namespace AgreableInstantArticlesPlugin\Outlet\Facebook;


use Facebook\Authentication\AccessToken;
use Facebook\Facebook;
use Facebook\GraphNodes\GraphNode;
use Facebook\InstantArticles\Client\Client;
use Facebook\InstantArticles\Client\Helper;
use Facebook\InstantArticles\Client\InstantArticleStatus;
use Facebook\InstantArticles\Elements\InstantArticle;

/**
 * Class Api
 *
 * @package AgreableInstantArticlesPlugin\Outlet\Facebook
 */
class Api {

	const SUBMISSION_ID_FIELD_KEY = 'submission_id';

	/**
	 * @var Client
	 */
	private $instaClient;

	/**
	 * @var int
	 */
	private $appId;

	/**
	 * @var string
	 */
	private $appSecret;

	/**
	 * @var string
	 */
	private $userToken;

	/**
	 * @var string created from app id/page_id/mode everything else can be changed
	 */
	private $uniqueKey;

	/**
	 * @var Facebook
	 */
	private $fbClient;

	/**
	 * Api constructor.
	 *
	 * @param $appID string
	 * @param $appSecret string
	 * @param $userToken string
	 * @param $pageID string
	 * @param $developmentMode
	 */
	public function __construct( string $appID, string $appSecret, string $userToken, string $pageID, bool $developmentMode ) {

		$this->appId     = $appID;
		$this->appSecret = $appSecret;
		$this->userToken = $userToken;
		$this->uniqueKey = implode( '_', [ 'ia', $appID, $pageID, $developmentMode ? 'dev' : 'prod' ] );
		$accessToken     = $this->getPageAccessToken( $pageID );

		$this->fbClient = new Facebook( [
			'app_id'                => $appID,
			'app_secret'            => $appSecret,
			'default_access_token'  => $accessToken,
			'default_graph_version' => 'v2.5'
		] );

		$this->instaClient = new Client( $this->fbClient, $pageID, $developmentMode );

	}

	/**
	 * @param $post_id int
	 * @param $content InstantArticle
	 *
	 * @return string Outlet id of element
	 */
	public function update( int $post_id, $content ): string {

		$resp = $this->instaClient->importArticle( $content, ( WP_ENV === 'production' ), true, true );

		$this->setSubmissionId( $post_id, $resp );
		$this->setSubmissionStatus( $post_id, null );

		return $resp;
	}

	/**
	 * @param int $post_id
	 *
	 * @return string
	 */
	public function delete( int $post_id ): string {

		$this->instaClient->removeArticle( get_permalink( $post_id ) )->getStatus();

		/**
		 * Do a cleanup
		 */
		$this->setSubmissionStatus( $post_id, null );
		$this->setSubmissionId( $post_id, null );

		return true;
	}

	/**
	 * @param $id
	 *
	 * @return mixed
	 */
	public function getPageAccessToken( string $id ): string {

		$accessToken = '';//$this->getOption( 'page_access_token_' . $id );

		if ( ! $accessToken ) {
			$helper = Helper::create(
				$this->appId,
				$this->appSecret
			);
			/**
			 * @var $edge \Facebook\GraphNodes\GraphEdge
			 * @var $pages GraphNode
			 */
			$edge  = $helper->getPagesAndTokens( new AccessToken( $this->userToken ) );
			$pages = $edge->all();

			foreach ( $pages as $index => $page ) {
				$sId = $page->getField( 'id' );
				if ( $sId == $id ) {
					$accessToken = $page->getField( 'access_token' );

				}

			}

		}

		return $accessToken;
	}


	/**
	 * @param $name
	 * @param bool $def
	 *
	 * @return mixed
	 */
	public function getOption( string $name, $def = false ) {
		return get_option( $this->uniqueKey . '_' . $name, $def );
	}

	/**
	 * @param $name
	 * @param $val
	 *
	 * @return bool
	 */
	public function setOption( string $name, $val ): bool {
		return update_option( $this->uniqueKey . '_' . $name, $val );
	}

	/**
	 * @param int $post_id
	 *
	 * @return string
	 */
	public function getStatus( int $post_id ): string {

		/**
		 * If we got it before and there was no change it should be this same as last one.
		 */
		$submission_status = $this->getSubmissionStatus( $post_id );

		if ( $submission_status === InstantArticleStatus::SUCCESS ) {
			return Outlet::STATUS_PUBLISHED;
		}

		$submission_status = $this->getSubmissionStatus( $post_id, true );

		switch ( $submission_status ) {
			case( InstantArticleStatus::SUCCESS ):
				return Outlet::STATUS_PUBLISHED;
			case( InstantArticleStatus::IN_PROGRESS ):
				return Outlet::STATUS_PENDING;

		}

		return Outlet::STATUS_FAILED;
	}

	/**
	 * @param $post_id
	 *
	 * @return int
	 */
	public function getSubmissionId( int $post_id ) {

		$submission_id = $this->getField( $post_id, 'submission_id' );
		if ( ! $submission_id ) {
			$submission_id = $this->instaClient->getArticleIDFromCanonicalURL( get_permalink( $post_id ) );
			if ( is_null( $submission_id ) ) {
				return false;
			}
		}

		return $submission_id;
	}


	/**
	 * @param $post_id
	 * @param bool $force
	 *
	 * @return mixed|string
	 */
	public function getSubmissionStatus( int $post_id, $force = false ): string {

		if ( ! $force ) {
			$submission_status = $this->getField( $post_id, 'submission_status' );

			if ( $submission_status ) {
				return $submission_status;
			}
		}

		$submission_id = $this->getSubmissionId( $post_id );

		if ( ! $submission_id ) {
			return InstantArticleStatus::NOT_FOUND;
		}

		$submission_status = $this->instaClient->getSubmissionStatus( $submission_id )->getStatus();

		if ( $submission_status === InstantArticleStatus::SUCCESS ) {

			$this->setSubmissionStatus( $post_id, $submission_status );

			return $submission_status;
		}

		return InstantArticleStatus::NOT_FOUND;
	}

	/**
	 * @param $post_id
	 * @param $value
	 *
	 * @return bool|int
	 */
	public function setSubmissionId( int $post_id, $value ): bool {
		return $this->setField( $post_id, 'submission_id', $value );
	}


	/**
	 * @param $post_id
	 * @param $value
	 *
	 * @return bool|int
	 */
	public function setSubmissionStatus( int $post_id, $value ): bool {
		return $this->setField( $post_id, 'submission_status', $value );
	}


	/**
	 * @param $post_id
	 * @param $hash
	 *
	 * @return bool|int
	 */
	public function setLastUpdatedHash( int $post_id, $hash ): bool {
		return $this->setField( $post_id, 'last_update_hash', $hash );
	}

	/**
	 * @param $post_id
	 *
	 * @return mixed
	 */
	public function getLastUpdatedHash( int $post_id ): string {
		return $this->getField( $post_id, 'last_update_hash' );
	}

	/**
	 * @return string
	 */
	public function getUniqueKey(): string {
		return $this->uniqueKey;
	}

	/**
	 * @param $post_id
	 * @param $name
	 * @param null $value
	 *
	 * @return bool|int
	 */
	private function setField( int $post_id, $name, $value = null ): bool {
		return update_post_meta( $post_id, $this->uniqueKey . '_' . $name, $value );
	}

	/**
	 * @param $post_id
	 * @param $name
	 *
	 * @return mixed
	 */
	private function getField( int $post_id, $name ) {
		return get_post_meta( $post_id, $this->uniqueKey . '_' . $name, true );
	}

	private function getErrors( int $post_id ): array {
		$submissionId = $this->getSubmissionId( $post_id );

		if ( ! $submissionId ) {
			return [];
		}
		$res    = $this->fbClient->get( $this->getSubmissionId( $post_id ) . '?fields=errors' )->getDecodedBody();
		$errors = [];
		if ( ! isset( $res['errors'] ) || ! is_array( $res ) ) {
			return [];
		}
		$res = $res['errors'];
		foreach ( $res as $index => $re ) {
			$errors[] = $re['message'];
		}

		return $errors;
	}

	/**
	 * @param $post_id
	 *
	 * @return array
	 */
	public function getStats( int $post_id ): array {
		return [
			'status'          => $this->getStatus( $post_id ),
			'submission_id'   => $this->getSubmissionId( $post_id ),
			'facebook_status' => $this->getSubmissionStatus( $post_id ),
			'hash'            => $this->getLastUpdatedHash( $post_id ),
			'warnings'        => $this->getErrors( $post_id )
		];
	}


}