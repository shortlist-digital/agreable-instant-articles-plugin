<?php


namespace AgreableInstantArticlesPlugin\Outlet\Facebook;


use AgreableInstantArticlesPlugin\ApiInterface;
use Facebook\Authentication\AccessToken;
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
class Api implements ApiInterface {
	/**
	 * @var Client
	 */
	private $client;
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
	 *
	 */
	const STATUS_PENDING = 'PENDING';

	/**
	 *
	 */
	const STATUS_SUCCESS = 'SUCCESS';
	/**
	 *
	 */
	const STATUS_OFFLINE = 'OFFLINE';

	/**
	 * Api constructor.
	 *
	 * @param $appID int
	 * @param $appSecret string
	 * @param $userToken string
	 * @param $pageID int
	 * @param $developmentMode
	 */
	public function __construct( $appID, $appSecret, $userToken, $pageID, $developmentMode ) {
		$this->appId     = $appID;
		$this->appSecret = $appSecret;
		$this->userToken = $userToken;
		$this->uniqueKey = implode( '_', [ 'ia', $appID, $pageID, $developmentMode ? 'dev' : 'prod' ] );
		$accessToken     = $this->getPageAccessToken( $pageID );
		exit($developmentMode);
		$this->client = Client::create( $appID, $appSecret, $accessToken, $pageID, $developmentMode );

	}

	/**
	 * @param $post_id int
	 * @param $content InstantArticle
	 *
	 * @return string Outlet id of element
	 */
	public function update( int $post_id, $content ): string {

		$resp = $this->client->importArticle( $content, ( WP_ENV === 'production' ), true, true );
		$this->setSubmissionId( $post_id, $resp );

		return $resp;
	}

	/**
	 * @param int $post_id
	 *
	 * @return string
	 */
	public function delete( int $post_id ): string {

		$this->client->removeArticle( get_permalink( $post_id ) )->getStatus();

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
				//$this->setPageAccessToken( $page->getField( 'id' ), $page->getField( 'access_token' ) );
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
	public function getOption( $name, $def = false ) {
		return get_option( $this->uniqueKey . '_' . $name, $def );
	}

	/**
	 * @param $name
	 * @param $val
	 *
	 * @return bool
	 */
	public function setOption( $name, $val ) {
		return update_option( $this->uniqueKey . '_' . $name, $val );
	}

	/**
	 * @param int $post_id
	 *
	 * @return string
	 */
	public function getStatus( int $post_id ): string {


		$submission_status = $this->getSubmissionStatus( $post_id );

		if ( $submission_status === InstantArticleStatus::SUCCESS ) {
			return self::STATUS_SUCCESS;
		}

		$submission_status = $this->getSubmissionStatus( $post_id, true );

		if ( $submission_status === InstantArticleStatus::SUCCESS ) {
			return self::STATUS_SUCCESS;
		}

		return self::STATUS_PENDING;
	}

	/**
	 * @param $post_id
	 *
	 * @return int
	 */
	public function getSubmissionId( $post_id ) {

		$submission_id = $this->getField( $post_id, 'submission_id' );
		if ( ! $submission_id ) {
			$submission_id = $this->client->getArticleIDFromCanonicalURL( get_permalink( $post_id ) );
			if ( $submission_id ) {
				$this->setSubmissionId( $post_id, $submission_id );
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
	public function getSubmissionStatus( $post_id, $force = false ) {

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

		$submission_status = $this->client->getSubmissionStatus( $submission_id )->getStatus();

		if ( $submission_status ) {

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
	public function setSubmissionId( $post_id, $value ) {
		return $this->setField( $post_id, 'submission_id', $value );
	}


	/**
	 * @param $post_id
	 * @param $value
	 *
	 * @return bool|int
	 */
	public function setSubmissionStatus( $post_id, $value ) {
		return $this->setField( $post_id, 'submission_status', $value );
	}


	/**
	 * @param $post_id
	 * @param $hash
	 *
	 * @return bool|int
	 */
	public function setLastUpdatedHash( $post_id, $hash ) {
		return $this->setField( $post_id, 'active', $hash );
	}

	/**
	 * @param $post_id
	 *
	 * @return mixed
	 */
	public function getLastUpdatedHash( $post_id ) {
		return $this->getField( $post_id, 'active' );
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
	private function setField( $post_id, $name, $value = null ) {
		return update_post_meta( $post_id, $this->uniqueKey . '_' . $name, $value );
	}

	/**
	 * @param $post_id
	 * @param $name
	 *
	 * @return mixed
	 */
	private function getField( $post_id, $name ) {
		return get_post_meta( $post_id, $this->uniqueKey . '_' . $name, true );
	}

	/**
	 * @param $post_id
	 *
	 * @return array
	 */
	public function getStats( $post_id ) {
		return [
			'status'            => $this->getStatus( $post_id ),
			'submission_id'     => $this->getSubmissionId( $post_id ),
			'submission_status' => $this->getSubmissionStatus( $post_id ),
			'hash'              => $this->getLastUpdatedHash( $post_id )
		];
	}


}