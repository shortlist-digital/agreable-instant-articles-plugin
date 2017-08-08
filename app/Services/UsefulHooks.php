<?php

namespace AgreableUtility;

class UsefulHooks {

	public static $disabled = false;

	public function __construct() {

		add_action( 'save_post', array( $this, 'save_post_intent' ) );
		add_action( 'transition_post_status', array( $this, 'transition_intent' ), 10, 3 );
	}

	public static function disableOnSaveFunctionality() {
		self::$disabled = true;
	}

	public function transition_intent( $new_status, $old_status, $post ) {
		if ( self::$disabled ) {
			return;
		}

		$status_string = $old_status . "_to_" . $new_status;
		switch ( $status_string ) {
			case "new_to_auto-draft":
				$this->create( $post->ID );
				break;
			case "new_to_draft":
				$this->create( $post->ID );
				break;
		}
	}

	public function create( $post_id ) {
		do_action( 'useful-hooks-create', $post_id );
	}

	public function save_post_intent( $post_id ) {
		if ( self::$disabled ) {
			return;
		}

		$post   = get_post( $post_id );
		$status = $post->post_status;
		switch ( $status ) {
			case "closed":
				$this->delete( $post_id );
				break;
			case "pending":
				$this->delete( $post_id );
				break;
			case "draft":
				$this->delete( $post_id );
				break;
			case "publish":
				$this->update( $post_id );
				break;

		}

	}

	public function delete( $post_id ) {
		do_action( 'useful-hooks-delete', $post_id );
	}

	public function update( $post_id ) {
		do_action( 'useful-hooks-update', $post_id );
	}

}

new UsefulHooks();
