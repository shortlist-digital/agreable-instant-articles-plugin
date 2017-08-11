<?php


namespace AgreableInstantArticlesPlugin\Outlet\Facebook;


use AgreableInstantArticlesPlugin\ApiInterface;
use Facebook\InstantArticles\Client\Client;
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
	 * @param $appID
	 * @param $appSecret
	 * @param $accessToken
	 * @param $pageID
	 * @param $developmentMode
	 */
	public function __construct( $appID, $appSecret, $accessToken, $pageID, $developmentMode ) {
		$this->uniqueKey = implode( '_', [ 'ia', $appID, $pageID, $developmentMode ? 'dev' : 'prod' ] );
		$this->client    = Client::create( $appID, $appSecret, $accessToken, $pageID, $developmentMode );
	}

	/**
	 * @param $post_id int
	 * @param $content InstantArticle
	 *
	 * @return bool Outlet id of element
	 */
	public function update( $post_id, $content ) {
		if ( $this->getActive( $post_id ) ) {
			$hash = $this->getLastUpdatedHash( $post_id );
			if ( $hash ) {
				$newHash = md5( $content->render() );
				if ( $newHash === $hash ) {
					return true;
				}
			}
		}
		$id = $this->client->importArticle( $content, ( WP_ENV === 'production' ) );
		if ( $id ) {
			$this->setLastUpdatedHash( $post_id, md5( $content->render() ) );
			$this->setSubmissionId( $post_id, $id );
			$this->setActive( $post_id, true );
			$this->setSubmissionStatus( $post_id, true );

			return true;
		}

		return false;
	}

	/**
	 * @param $post_id
	 *
	 * @return bool
	 */
	public function delete( $post_id ) {

		$this->client->removeArticle( get_permalink( $post_id ) )->getStatus();

		/**
		 * Do a cleanup
		 */
		$this->setSubmissionStatus( $post_id, null );
		$this->setActive( $post_id, null );
		$this->setSubmissionId( $post_id, null );


	}

	/**
	 * @return mixed
	 */
	public function getStatus( $post_id ) {


		if ( ! $this->getActive( $post_id ) ) {
			return self::STATUS_OFFLINE;
		}

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
	 *
	 * @return mixed
	 */
	public function getActive( $post_id ) {
		return $this->getField( $post_id, 'active' );
	}

	/**
	 * @param $post_id
	 * @param $value
	 *
	 * @return bool|int
	 */
	public function setActive( $post_id, $value ) {
		return $this->setField( $post_id, 'active', $value );
	}

	public function setLastUpdatedHash( $post_id, $hash ) {
		return $this->setField( $post_id, 'active', $hash );
	}

	public function getLastUpdatedHash( $post_id ) {
		return $this->getField( $post_id, 'active' );
	}

	/**
	 * @return string
	 */
	public function getUniqueKey() {
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
			'active'            => $this->getActive( $post_id ),
			'status'            => $this->getStatus( $post_id ),
			'submission_id'     => $this->getSubmissionId( $post_id ),
			'submission_status' => $this->getSubmissionStatus( $post_id ),
			'hash'              => $this->getLastUpdatedHash( $post_id )
		];
	}


}