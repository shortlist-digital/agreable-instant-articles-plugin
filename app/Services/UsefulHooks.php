<?php

namespace AgreableUtility;

class UsefulHooks {

	public static $disabled = false;

	public static function disableOnSaveFunctionality() {
		self::$disabled = true;
	}


	public function __construct() {
		// Trash
		//add_action('wp_trash_post', array($this, 'delete'));
		// Equivalent to a create
		//add_action('wp_untrash_post', array($this, 'create'));
		// Create
		//add_action('draft_to_publish', array($this, 'create'));
		//add_action('pending_to_publish', array($this, 'create'));
		//add_action('auto-draft_to_publish', array($this, 'create'));
		// Update
		//add_action('publish_to_publish', array($this, 'update'));
		// Equivalent to delete
		add_action( 'save_post', array( $this, 'save_post_intent' ) );
		add_action( 'transition_post_status', array( $this, 'transition_intent' ), 10, 3 );
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

	public function create( $post_id ) {
		do_action( 'useful-hooks-create', $post_id );
	}

	public function update( $post_id ) {
		do_action( 'useful-hooks-update', $post_id );
	}

	public function delete( $post_id ) {
		do_action( 'useful-hooks-delete', $post_id );
	}

}

new UsefulHooks();
